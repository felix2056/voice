<?php 

use Illuminate\Database\Seeder;

use App\Setting;
use App\AboutContent;
use App\Post;
use Carbon\Carbon;
use Faker\Factory;

use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class DemoSiteMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate previous data
        echo 'deleting old data.....';
        $this->deletePreviousData();

        //seed common settings
        echo PHP_EOL , 'seeding settings...';
        $this->settingsData();

        //contact details
        echo PHP_EOL , 'seeding contact info...';
        $this->contactData();

        //about us data
        echo PHP_EOL , 'seeding about us...';
        $this->aboutSectionData();

        //roles and permissions data
        echo PHP_EOL , 'seeding roles and permissions...';
        $this->roleAndPermissionData();

        //user data
        echo PHP_EOL , 'seeding users...';
        $this->usersData();

        //seed posts data
        echo PHP_EOL , 'seeding posts...';
        $this->postsData();


        echo PHP_EOL , 'seeding completed.';

    }


    private function deletePreviousData()
    {
        /***
         * This code is MYSQL specific
         */
        app()['cache']->forget('spatie.permission.cache');

        DB::statement("SET foreign_key_checks=0");

        Setting::truncate();
        AboutContent::truncate();
        User::truncate();
        Role::truncate();
        Permission::truncate();

        DB::statement("SET foreign_key_checks=1");

        //delete images
        $storagePath = storage_path('app/public');
        $dirs = [
            $storagePath.'/site',
            $storagePath.'/auth',
        ];

        foreach ($dirs as $dir){
            system("rm -rf ".escapeshellarg($dir));
        }
    }

    private function settingsData()
    {        
        //Site Images
        $originFilePath = resource_path('images/site/');
        $destinationPath = storage_path('app').'/public/site/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $logo = 'logo.png';
        copy($originFilePath.$logo, $destinationPath.$logo);
        Setting::updateOrCreate(
            ['meta_key' => 'logo'],
            ['meta_value' => $logo]
        );


        $favicon = 'favicon.png';
        copy($originFilePath.$favicon, $destinationPath.$favicon);
        Setting::updateOrCreate(
            ['meta_key' => 'favicon'],
            ['meta_value' => $favicon]
        );


        $site_name = 'Voice';
        Setting::updateOrCreate(
            ['meta_key' => 'site_name'],
            ['meta_value' => $site_name]
        );

        $short_name = 'voice';
        Setting::updateOrCreate(
            ['meta_key' => 'short_name'],
            ['meta_value' => $short_name]
        );

        $site_desc = 'Voice is a website';
        Setting::updateOrCreate(
            ['meta_key' => 'site_desc'],
            ['meta_value' => $site_desc]
        );

        $site_link = 'www.gyft.co.nz';
        Setting::updateOrCreate(
            ['meta_key' => 'site_link'],
            ['meta_value' => $site_link]
        );

        $email = 'info@gyft.co.nz';
        Setting::updateOrCreate(
            ['meta_key' => 'email'],
            ['meta_value' => $email]
        );

        $keywords = 'voice, broadcast, chat, play';
        Setting::updateOrCreate(
            ['meta_key' => 'keywords'],
            ['meta_value' => $keywords]
        );

        $facebook = 'https://www.facebook.com/voice';
        Setting::updateOrCreate(
            ['meta_key' => 'facebook'],
            ['meta_value' => $facebook]
        );

        $twitter = 'https://www.twitter.com/voice';
        Setting::updateOrCreate(
            ['meta_key' => 'twitter'],
            ['meta_value' => $twitter]
        );

        $instagram = 'https://www.instagram.com/voice';
        Setting::updateOrCreate(
            ['meta_key' => 'instagram'],
            ['meta_value' => $instagram]
        );
    }
    
    private function contactData()
    {
        //now crate or update model
        Setting::updateOrCreate(
            ['meta_key' => 'contact_address'],
            [ 'meta_value' => 'Netherlands-1207']
        );
        Setting::updateOrCreate(
            ['meta_key' => 'contact_phone'],
            [ 'meta_value' => '+880258685']
        );
        Setting::updateOrCreate(
            ['meta_key' => 'contact_email'],
            [ 'meta_value' => 'info@voice.net']
        );
        Setting::updateOrCreate(
            ['meta_key' => 'contact_latlong'],
            [ 'meta_value' => '23.7340076,90.3841824']
        );
    }
    
    private function aboutSectionData()
    {

        $data = [
            'why_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy.',
            'key_point_1_title' => 'Key point 1',
            'key_point_1_content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock',
            'key_point_2_title' => 'Key point 2',
            'key_point_2_content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock',
            'about_us' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'who_we_are' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution',
            'intro_video_embed_code' => '<iframe src="https://www.youtube.com/embed/6sa1G_9jCb0" frameborder="0"  allowfullscreen></iframe>',
            'video_site_link' => 'https://www.youtube.com',

        ];

        //now crate or update model
        AboutContent::updateOrCreate(
            ['id' => 1],
           $data
        );
    }

    private function roleAndPermissionData()
    {
        //Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /*-----------------------------------
        * All Permissions
        ------------------------------------**/
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'create-broadcasts']);
        Permission::create(['name' => 'view-broadcasts']);
        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'assign-users-role']);
        Permission::create(['name' => 'update-settings']);

        Role::create(['name' => 'Admin'])
            ->givePermissionTo([Permission::all()]);
        
        Role::create(['name' => 'Broadcaster'])
            ->givePermissionTo(['create-broadcasts']);

        Role::create(['name' => 'Writer'])
            ->givePermissionTo(['create-posts',]);

        Role::create(['name' => 'Viewer'])
            ->givePermissionTo(['view-broadcasts']);
    }

    private function usersData()
    {
        $faker = Factory::create();

        for($i = 0; $i < 20; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'phonenumber' => 1234567890,
                'street' => '123 street',
                'city' => 'example city',
                'state' => 'example state',
                'postalcode' => '100001',
            ]);

            $user->assignRole('Viewer');

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('public/avatars/'.$user->id.'/avatar.png', (string) $avatar);
        }

        // Make Admin 
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'phonenumber' => 1234567890,
            'street' => '123 street',
            'city' => 'example city',
            'state' => 'example state',
            'postalcode' => '100001',
        ]);

        $admin->assignRole('Admin');

        $avatar = Avatar::create($admin->name)->getImageObject()->encode('png');
        Storage::put('public/avatars/'.$admin->id.'/avatar.png', (string) $avatar);

        // Make Broadcaster 
        $broadcaster = User::create([
            'name' => 'Broadcaster',
            'email' => 'broadcaster@gmail.com',
            'password' => Hash::make('broadcaster'),
            'phonenumber' => 1234567890,
            'street' => '123 street',
            'city' => 'example city',
            'state' => 'example state',
            'postalcode' => '100001',
        ]);

        $broadcaster->assignRole('Broadcaster');

        $avatar = Avatar::create($broadcaster->name)->getImageObject()->encode('png');
        Storage::put('public/avatars/'.$broadcaster->id.'/avatar.png', (string) $avatar);

        // Make Writer 
        $writer = User::create([
            'name' => 'Writer',
            'email' => 'writer@gmail.com',
            'password' => Hash::make('writer'),
            'phonenumber' => 1234567890,
            'street' => '123 street',
            'city' => 'example city',
            'state' => 'example state',
            'postalcode' => '100001',
        ]);

        $writer->assignRole('writer');

        $avatar = Avatar::create($writer->name)->getImageObject()->encode('png');
        Storage::put('public/avatars/'.$writer->id.'/avatar.png', (string) $avatar);


        // Make Viewer 
        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@gmail.com',
            'password' => Hash::make('viewer'),
            'phonenumber' => 1234567890,
            'street' => '123 street',
            'city' => 'example city',
            'state' => 'example state',
            'postalcode' => '100001'
        ]);

        $viewer->assignRole('Viewer');

        $avatar = Avatar::create($viewer->name)->getImageObject()->encode('png');
        Storage::put('public/avatars/'.$viewer->id.'/avatar.png', (string) $avatar);
    }

    private function postsData()
    {
        $faker = Factory::create();

        for($i = 0; $i < 30; $i++) {
            $posts = Post::create([
                'user_id' => rand(1, 10),
                'headline' => 'Covid-19 New Cases',
                'body' => $faker->text
            ]);
        }
    }
}
