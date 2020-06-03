<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Auth;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\UserRole;
use App\Role;
use App\Message;
use Pusher;
use DB;

use App\Order;
use App\User;
use App\Setting;


class AdminController extends Controller
{
  public function home()
  {
    $now = Carbon::now();

    $data = [
      //'broadcasts'=> Property::count(),
      'orders' => Order::count(),
      'users' => User::count(),
      'earnings' => Order::sum('amount')
    ];

    $users = User::orderBy('created_at', 'DESC')->get();
    $orders = Order::orderBy('created_at', 'DESC')->get();

    return view('admin.home', compact('users', 'orders', 'data'));
  }

  public function roles($curPage = null)
  {
    $user = User::find(Auth::user()->id);

    $data = [];

    $data['admins'] = User::role('Admin')->get();
    $data['broadcasters'] = User::role('Broadcaster')->get();
    $data['writers'] = User::role('Writer')->get();

    $count = User::role('Viewer')->count();

    $pages = ceil($count / 5);
    $curPage = is_null($curPage) ? 1 : $curPage;
    $skip = ($curPage - 1) * 5;

    $data['viewers'] = User::role('Viewer')
      ->skip($skip)
      ->take(5)
      ->get();


    return view('admin.roles', [
      'user' => $user,
      'data' => $data,
      'count' => $count,
      'pages' => $pages,
      'curPage' => $curPage
    ]);

    /*$broadcasters = User::whereHas('roles', function($query) {
      $query->where('role', 'broadcaster');
    })->get();
    $writters = User::whereHas('roles', function($query) {
      $query->where('role', 'writter');
    })->get();
    $count = User::whereHas('roles', function($query) {
      $query->where('role', 'viewer');
    })->count();
    
    $pages = ceil($count / 5);
    $curPage = is_null($curPage) ? 1 : $curPage;
    $skip = ($curPage - 1) * 5;
    
    $viewers = User::whereHas('roles', function($query) {
      $query->where('role', 'viewer');
    })->skip($skip)->take(5)->get();

    $classes = [
      'dashboard' => '',
      'account' => '',
      'admin' => 'active',
      'message' => '',
      'settings' => ''
    ];
    
    return view('admin.roles', [
      'user' => $user,
      'broadcasters' => $broadcasters,
      'writters' => $writters,
      'viewers' => $viewers,
      'count' => $count,
      'pages' => $pages,
      'curPage' => $curPage,
      'classes' => $classes
    ]);*/
  }

  public function users()
  {
    $users = User::all();
    return view('admin.users')->with('users', $users);
  }

  public function activate($id)
  {
    /*$user = User::where('id', $id)->update([
      'status' => 1
    ]);*/

    $user = User::find($id);
    $user->status = 1;
    $user->save();

    $options = array(
      'cluster' => 'us3',
      'useTLS' => true
    );
    $pusher = new Pusher(
      '79a0fc24043fa9a07d29',
      'ad28fb9c5e520d8dc3a0',
      '892326',
      $options
    );

    $data = [
      'type' => 'activated',
      'name' => auth()->user()->name,
      'message' => 'You have blocked',
      'userId' => $id,
      'color' => '',
      'created_at' => date("Y-m-d H:i:s a")
    ];
    $pusher->trigger('my-channel', 'my-event', $data);

    //return redirect('/admin/users');
    return redirect()->back()->with('success', $user->name . ' Has Been Activated Successfully!');
  }

  public function block($id)
  {
    /*$user = User::where('id', $id)->update([
      'status' => 0
    ]);*/

    $user = User::find($id);
    $user->status = 0;
    $user->save();

    $options = array(
      'cluster' => 'us3',
      'useTLS' => true
    );
    $pusher = new Pusher(
      '79a0fc24043fa9a07d29',
      'ad28fb9c5e520d8dc3a0',
      '892326',
      $options
    );

    $data = [
      'type' => 'blocked',
      'name' => auth()->user()->name,
      'message' => 'You have blocked',
      'userId' => $id,
      'color' => '',
      'created_at' => date("Y-m-d H:i:s a")
    ];
    $pusher->trigger('my-channel', 'my-event', $data);

    //return redirect('/admin/users');
    return redirect()->back()->with('error', $user->name . ' Has Been Blocked Successfully!');
  }

  public function delete($role, $id)
  {
    $newRole = Role::where('role', 'viewer')->first();
    $exist = User::whereHas('roles', function ($query) use ($role) {
      $query->where('role', $role);
    })->get();
    if (sizeof($exist) > 1) {
      UserRole::where('user_id', $id)->delete();
      userRole::create([
        'user_id' => $id,
        'role_id' => $newRole->id
      ]);
    }

    return redirect('/admin/users');
  }

  public function chgMesColor(Request $request)
  {
    $data = $request->all();
    $ids = array();
    $explode = explode(",", $data['ids']);
    for ($i = 0; $i < sizeof($explode); $i++) {
      array_push($ids, $explode[$i]);
    }

    Message::whereIn('id', $ids)->update([
      'color' => $data['color']
    ]);

    return "success";
  }

  public function getViewers($page, $option = null)
  {
    if (is_null($option)) {
      return $this->users($page);
    } else if ($option == 'next') {
      return $this->users($page + 1);
    } else if ($option == 'prev') {
      return $this->users($page - 1);
    }
  }

  public function settings(Request $request)
  {
    //for save on POST request
    if ($request->isMethod('post')) {
      $messages = [
        'site_name.required' => 'The website name field is required',
        'short_name.required' => 'The short name field is required',
        'site_desc.required' => 'A good description of your website is used as meta data for SEO',
        //'logo.max' => 'The :attribute size must be under 1MB.',
        //'logo.dimensions' => 'The :attribute dimensions max be 430 X 80.',
        //'favicon.max' => 'The :attribute size must be under 512kb.',
        //'favicon.dimensions' => 'The :attribute dimensions must be 32 X 32.',
      ];

      $rules = [
        'site_name' => 'required|min:5|max:255',
        'short_name' => 'required|min:3|max:255',
        'site_desc' => 'required|min:200|max:1000',
        //'logo' => 'mimes:jpeg,jpg,png|max:1024|dimensions:max_width=430,max_height=80',
        //'favicon' => 'mimes:png|max:512|dimensions:min_width=32,min_height=32,max_width=32,max_height=32',
        'site_link' => 'max:255',
        'email' => 'nullable|email|max:255',
        'contact_phone' => 'min:8|max:15',
        'contact_address' => 'max:500',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);
      
      if ($validator->fails()) {
        return response()->json([
          'status' => "error",
          'error' => $validator->errors()
        ], 401);
      }

      if ($request->hasFile('logo')) {
        $exists = Storage::exists('public/site/' . $request->oldlogo);

        if ($exists) {
          Storage::delete('public/site/' . $request->oldlogo);
        }

        $storagepath = $request->file('logo')->store('public/site');
        $fileName = basename($storagepath);
        $logo = $fileName;
        
        Setting::updateOrCreate(
          ['meta_key' => 'logo'],
          ['meta_value' => $logo]
        );
      }

      if ($request->hasFile('favicon')) {
        $exists = Storage::exists('public/site/' . $request->oldfavicon);

        if ($exists) {
          Storage::delete('public/site/' . $request->oldfavicon);
        }

        $storagepath = $request->file('favicon')->store('public/site');
        $fileName = basename($storagepath);
        $favicon = $fileName;

        Setting::updateOrCreate(
          ['meta_key' => 'favicon'],
          ['meta_value' => $favicon]
        );
      }

      $site_name = $request->get('site_name');

      Setting::updateOrCreate(
        ['meta_key' => 'site_name'],
        ['meta_value' => $site_name]
      );

      $short_name = $request->get('short_name');
      Setting::updateOrCreate(
        ['meta_key' => 'short_name'],
        ['meta_value' => $short_name]
      );

      $site_desc = $request->get('site_desc');
      Setting::updateOrCreate(
        ['meta_key' => 'site_desc'],
        ['meta_value' => $site_desc]
      );

      $site_link = $request->get('site_link');
      Setting::updateOrCreate(
        ['meta_key' => 'site_link'],
        ['meta_value' => $site_link]
      );

      $email = $request->get('email');
      Setting::updateOrCreate(
        ['meta_key' => 'email'],
        ['meta_value' => $email]
      );

      $contact_phone = $request->get('contact_phone');
      Setting::updateOrCreate(
        ['meta_key' => 'contact_phone'],
        ['meta_value' => $contact_phone]
      );

      $contact_address = $request->get('contact_address');
      Setting::updateOrCreate(
        ['meta_key' => 'contact_address'],
        ['meta_value' => $contact_address]
      );

      $facebook = $request->get('facebook');
      Setting::updateOrCreate(
        ['meta_key' => 'facebook'],
        ['meta_value' => $facebook]
      );

      $twitter = $request->get('twitter');
      Setting::updateOrCreate(
        ['meta_key' => 'twitter'],
        ['meta_value' => $twitter]
      );

      $instagram = $request->get('instagram');
      Setting::updateOrCreate(
        ['meta_key' => 'instagram'],
        ['meta_value' => $instagram]
      );

      //now notify the admins about this record
      $msg = "Website settings was recently updated by " . auth()->user()->name;
      //$alertAdmins = self::sendNotificationToAdmins('info', $msg);

      return redirect()->back()->with('success', 'Settings updated!');
    }

    $settings = Setting::whereIn(
      'meta_key',
      [
        'logo',
        'favicon',
        'site_name',
        'short_name',
        'site_desc',
        'site_link',
        'email',
        'contact_phone',
        'contact_address',
        'facebook',
        'twitter',
        'instagram',
      ]
    )->get();

    $metas = [];

    foreach ($settings as $setting) {
      $metas[$setting->meta_key] = $setting->meta_value;
    }

    $info = $metas;

    return response()->json([
      'settings' => $info
    ]);
  }


  public function contactUs(Request $request)
  {
    //for save on POST request
    if ($request->isMethod('post')) { //
      $this->validate($request, [
        'address' => 'required|min:5|max:500',
        'phone_no' => 'required|min:5|max:500',
        'email' => 'required|email|min:5|max:500',
        'latlong' => 'required|min:5|max:500',

      ]);

      //return $request->all();

      //now create or update model
      $content = Setting::updateOrCreate(
        ['meta_key' => 'contact_address'],
        ['meta_value' => $request->get('address')]
      );
      $content = Setting::updateOrCreate(
        ['meta_key' => 'contact_phone'],
        ['meta_value' => $request->get('phone_no')]
      );
      $content = Setting::updateOrCreate(
        ['meta_key' => 'contact_email'],
        ['meta_value' => $request->get('email')]
      );
      $content = Setting::updateOrCreate(
        ['meta_key' => 'contact_latlong'],
        ['meta_value' => $request->get('latlong')]
      );

      if ($content) {
        return redirect()->back()->with('success', 'Information saved!');
      } else {
        return redirect()->back()->with('error', 'Failed to save Information!');
      }
    }

    //for get request
    $address = Setting::where('meta_key', 'contact_address')->first();
    $phone = Setting::where('meta_key', 'contact_phone')->first();
    $email = Setting::where('meta_key', 'contact_email')->first();
    $latlong = Setting::where('meta_key', 'contact_latlong')->first();

    return view('admin.contact_us', compact('address', 'phone', 'email', 'latlong'));
  }

  public function analytics(Request $request)
  {
    //for save on POST request
    if ($request->isMethod('post')) {
      //validate form
      $this->validate($request, [
        'ga_tracking_id' => 'required|max:255',
        'ga_report_id' => 'required|max:255',
        'ga_key_file' => 'required|file|mimetypes:text/plain',
      ]);


      $storagepath = $request->file('ga_key_file')->storeAs('secrets', 'ga_key_file.json');
      $fileName = basename($storagepath);

      //now crate
      Setting::updateOrCreate(
        ['meta_key' => 'ga_key_file'],
        ['meta_value' => $fileName]
      );
      Setting::updateOrCreate(
        ['meta_key' => 'ga_tracking_id'],
        ['meta_value' => $request->get('ga_tracking_id')]
      );
      Setting::updateOrCreate(
        ['meta_key' => 'ga_id'],
        ['meta_value' => $request->get('ga_report_id')]
      );

      return redirect()->route('admin.analytics')->with('success', 'Analytics Record Updated!');
    }

    //for get request
    $info = new \stdClass();
    $info->key_file = null;
    $info->ga_id = null;
    $info->ga_tracking_id = null;

    $gaInfo = Setting::where('meta_key', 'ga_key_file')->first();
    if ($gaInfo) {
      $info->key_file = $gaInfo->meta_value;
    }
    $gaInfo = Setting::where('meta_key', 'ga_id')->first();
    if ($gaInfo) {
      $info->ga_id = $gaInfo->meta_value;
    }
    $gaInfo = Setting::where('meta_key', 'ga_tracking_id')->first();
    if ($gaInfo) {
      $info->ga_tracking_id = $gaInfo->meta_value;
    }

    //return view('admin.analytics', compact('info'));
    return view('admin.analytics', compact('info'));
  }

  public function terms(Request $request)
  {
    //for save on POST request
    if ($request->isMethod('post')) {

      //validate form
      $messages = [
        'terms.required' => 'The name field is required'
      ];

      $rules = [
        'terms' => 'required|min:50'
      ];

      $this->validate($request, $rules, $messages);

      Setting::updateOrCreate(
        ['meta_key' => 'terms'],
        ['meta_value' => $request->terms]
      );

      return redirect()->back()->with('success', 'Terms has been updated!');
    }

    $terms = Setting::where('meta_key', 'terms')->pluck('meta_value');


    return view('admin.terms', compact('terms'));
  }

  public function timeline(Request $request)
  {
    //for save on POST request
    if ($request->isMethod('post')) {
      //validate form
      $this->validate($request, [
        'title' => 'required|min:5|max:255',
        'description' => 'required|min:5|max:500',
        'icon' => 'required|mimes:jpeg,jpg,png|max:1024|dimensions:max_width=56,max_height=56',
      ]);

      $data = [
        't' => $request->get('title'),
        'd' => $request->get('description')
      ];

      if ($request->hasFile('icon')) {
        $storagepath = $request->file('icon')->store('public/img/home');
        $fileName = basename($storagepath);
        $data['i'] = $fileName;
      }
      //now crate
      Setting::create(
        [
          'meta_key' => 'timeline',
          'meta_value' => json_encode($data)
        ]
      );
      return redirect()->route('admin.timeline')->with('success', 'Timeline Record Added!');
    }

    //for get request
    $timeline = Setting::where('meta_key', 'timeline')->get();
    return view('admin.timeline', compact('timeline'));
  }

  /**
   * timeline section content image delete
   * @return array
   */
  public function timelineDelete($id)
  {

    $timeline = Setting::findOrFail($id);
    $timeline->delete();

    $file_path = "public/img/home/" . $timeline->image;

    if ($file_path) {
      Storage::delete($file_path);
    }

    return redirect()->route('admin.timeline')->with('success', 'Record Deleted!');
  }
}
