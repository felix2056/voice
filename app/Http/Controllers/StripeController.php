<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Notifications\NewSale;

use \Stripe\Stripe;

use App\User;

use Cache;

class StripeController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }


    public function connect(Request $request)
    {
        /*$account = \Stripe\Account::retrieve(
            'acct_1GZbEmDpXMw0PxCF'
          );
          $account->delete();
          return $account;*/

          //return $request->all();

        if (Auth::user()->hasRole('Genin')) {
            return redirect()->back()->with('error', 'Sorry You do not have the required rank to join animestock affiliates.');
        }

        if (Auth::user()->hasAnyRole('Anbu|Sannin')) {
            return redirect()->back()->with('error', 'Only creator ranks are allowed to join. Sannin & Anbus are moderator ranks');
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'state' => 'required',
            'postal_code' => 'postal_code:'. $request->get('country'),
            'country' => 'required',
            'phone_number' => 'required',
        ];
        

        $this->validate($request, $rules);

        $user = User::find(Auth::user()->id);

        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $address = $request->get('address');
        $country = $request->get('country');
        $state = $request->get('state');
        $city = $request->get('city');
        $postal_code = $request->get('postal_code');
        $phone_number = $request->get('phone_number');

        $day = $request->get('day');
        $month = $request->get('month');
        $year = $request->get('year');

        $account = \Stripe\Account::create([
            'type' => 'custom',
            'country' => $country,
            'email' => $user->email,
            'requested_capabilities' => [
              'card_payments',
              'transfers'
            ],
            'business_type' => 'individual',
            'individual' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone_number,
                'email' => $user->email,
                'address' => [
                    'line1' => $address,
                    'line2' => ($request->get('address2')) ? $request->get('address2') : $address,
                    'postal_code' => $postal_code,
                    'city' => $city,
                    'state' => $state
                ],
                'dob' => [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ]
            ],
            'business_profile' =>  [
                'url' => 'https://animestock.net',
                'mcc' => '5045',
            ],
            'tos_acceptance' => [
                'date' => time(),
                'ip' => \Request::ip()
            ]
        ]);

        if ($account) {
            $user->stripe_id = $account->id;
            $user->givePermissionTo('earn');
            $user->save();

            return redirect()->route('user.seller.index')->with('success', 'Congratulations, your account is set up. Fire up your editing skills and upload your first template.');
        }
        return response($account);
    }

    public function createSession(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $item = Item::find($request->item);
        $price = $item->price;

        $percentage = 0;
        $fee = 0;

        if ( $item->user->hasRole('AnimeStock') || $item->user->hasRole('Kage') ) {
            $percentage = 20;
            $fee = ($percentage / 100) * $price;
        }
        elseif ( $item->user->hasRole('Jonin') ) {
            $percentage = 30;
            $fee = ($percentage / 100) * $price;
        }
        elseif ( $item->user->hasRole('Chunin') ) {
            $percentage = 40;
            $fee = ($percentage / 100) * $price;
        }
        else {
            $percentage = 5;
            $fee = ($percentage / 100) * $price;
        }

        $application_fee = $fee * 100;

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'name' => $item->title,
              'description' => strip_tags(Str::words($item->description, 100, '...')),
              'images' => [($item->video_id == null) ? 'https://animestock.net' .$item->preview_image : 'https://img.youtube.com/vi/' .$item->video_id. '/maxresdefault.jpg'],
              'amount' => $item->price * 100,
              'currency' => 'usd',
              'quantity' => 1,
            ]],
            'payment_intent_data' => [
                'application_fee_amount' => $application_fee,
            ],
            'success_url' => 'https://animestock.net/store/check-payment?session_id={CHECKOUT_SESSION_ID}&item_id='. $item->id . '&user_id=' .$user->id,
            'cancel_url' => 'https://animestock.net/store/payment-failed',
            ], ['stripe_account' => $item->user->stripe_id]);

        return response()->json(['sessionId' => $session['id']]);
    }

    public function check(Request $request)
    {
        if ( !$request->session_id ) {
            return abort(404);
        }
        
        /*$session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if (!$session) {
            return abort(404);
        }

        if ($session == null) {
            return abort(404);
        }*/
        
        $item = Item::find($request->item_id);
        $user = User::find($request->user_id); 

        if (!$item) {
            return abort(404);
        }

        if (Cache::has('user-has-purchased-' . $item->id . '-' . $user->id)) {
            if ( $user->id != Auth::user()->id ) {
                return abort(401);
            }

            return redirect()->route('store.payment.success', ['item_id' => $item->id, 'user_id' => $user->id]);
        }

        if(Auth::check()) {
            $expiresAt = Carbon::now()->addDays(2);
            Cache::put('user-has-purchased-' . $item->id . '-' . $user->id, true, $expiresAt);
        }

        $item->sales++;
        $item->save();

        //Send Notification To Thread Owner
	    $data = [];
        $data['user'] = $user;
        $data['item'] = $item;
        
        $item->user->notify(new NewSale($data));

        return redirect()->route('store.payment.success', ['item_id' => $item->id, 'user_id' => $user->id]);
    }

    public function paymentSuccess(Request $request, $item_id, $user_id)
    {
        $item = Item::find($item_id);
        $user = User::find($user_id);

        if (!$item) {
            return abort(404);
        }

        if ( !Cache::has('user-has-purchased-' . $item->id . '-' . $user->id ) ) {
            return abort(401);    
        }

        if ( $user->id != Auth::user()->id ) {
            return abort(401);
        }

        if($request->isMethod('post')) {
            $id = $item->file_id;

            $folder = 'Items';
            $contents = collect(Storage::cloud()->listContents('/', false));

            // Find the folder...
            $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $folder)
                ->first();


            // Get the files inside the folder...
            $file = collect(Storage::cloud()->listContents($dir['path'], false))
                ->where('type', '=', 'file')
                ->where('basename', '=', $id)->first();

            // Stream the file for larger downloads...
            $readStream = Storage::cloud()->getDriver()->readStream($file['path']);

            if (!$readStream) {
                return redirect()->back()->with('error', "Couldn't find the requested asset. Please contact an admin or sannin member if problem persists!");
            }
      
            $fileItemName = str_replace(' ', '_', $item->title) .'.'. $file['extension'];

            return response()->stream(function () use ($readStream) {
                fpassthru($readStream);
            }, 200, ['Content-Type' => $file['mimetype'],
                'Content-disposition' => 'attachment; filename="'.$fileItemName.'"',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Length' => $file['size'],
                'Pragma' => 'public',
            ]);
        }

        $folder = 'Items';

        $contents = collect(Storage::cloud()->listContents('/', false));

        // Find the folder you are looking for...
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $folder)
            ->first(); // There could be duplicate directory names!

        // Get the files inside the folder...
        $file = collect(Storage::cloud()->listContents($dir['path'], false))
        ->where('type', '=', 'file')
        ->where('basename', '=', $item->file_id)->first();

        $item['filename'] = $file['filename'].'.'.$file['extension'];
        $item['filesize'] = bcdiv($file['size'], 1048576, 2);
        $item['mimetype'] = $file['mimetype'];

        return view('store.paymentsuccess', compact('item', 'user'));
    }

    public function paymentFailed()
    {
        return view('store.paymentfailed');
    }

    /*public function billing(Request $request, $slug)
    {
        if($request->isMethod('post')) {
            $user = User::find(Auth::user()->id);

            $token = $request->stripeToken;
            $message = "";

        $customer = null;

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        //\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Charge the card
        try {
            if ($user->stripe_id != null) {
                $customer = $stripe->customers()->update($user->stripe_id, [
                    'source' => $token,
                    'name' => $request->name_on_card,
                    'phone' => $request->phone,
                    'address' => [
                        'line1' => $request->address,
                        'city' => $request->city,
                        'postal_code' => $request->zip,
                        'country' => $request->country,
                    ]
                ]);
            }
            else{
                $customer = $stripe->customers()->create([
                    'email' => $user->email,
                    'source' => $token,
                    'name' => $request->name_on_card,
                    'phone' => $request->phone,
                    'address' => [
                        'line1' => $request->address,
                        'city' => $request->city,
                        'postal_code' => $request->zip,
                        'country' => $request->country,
                    ]
                ]);

                $user->stripe_id = $customer['id'];
                $user->save();
            }

            $charge = $stripe->charges()->create([
                'customer' => $user->stripe_id,
                'currency' => 'USD',
                'amount' => filter_var($amount, FILTER_SANITIZE_NUMBER_INT),
                'description' => $user->name .' was charged for '. $plan
            ]);
        }

        $item = Item::where('slug', $slug)->first();
        
        if (!$item) {
            return abort(404);
        }

        return view('store.billing', compact('item'));
    }*/

    public function callback(Request $request)
    {
        if ( $request->get('code') ) {
            $code = $request->get('code');

            $user = User::find(Auth::user()->id);
            
            // Set your secret key. Remember to switch to your live secret key in production!
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $response = \Stripe\OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]);

            // Access the connected account id in the response
            $user->stripe_id = $response->stripe_user_id;
            $user->save();

            $balance = \Stripe\Balance::retrieve([
                'stripe_account' => $user->stripe_id
            ]);

            return redirect()->route('user.seller.home', compact($balance))->with('success', 'CONGRATS: You are now part of animestock affiliates!');
        }
    }
}
