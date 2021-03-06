<?php

use App\Events\NewPost;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/broadcast', function() {
//     broadcast(new \App\Events\NewMessage('Sent from my Voice application'));
//     return 'ok';
// });


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/test', function () {
    $data = [
        'username' => 'daniel',
        'avatar' => 'avatar',
        'headline' => 'headline'
    ];
    
    broadcast(new NewPost($data))->toOthers();
});

Route::get('/t', 'Ant\BroadcastController@test');
Route::get('/broadcasts', 'Ant\BroadcastController@broadcast');
Route::get('/admin/broadcast', 'Ant\AdminBroadcastController@broadcast');


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'api'], function () {
        //Payment Routes
        Route::post('/create-checkout-session', 'StripeController@createSession');

        //Get home statistics
        Route::get('/home-statistics', 'HomeController@getStats')->name('user.home.getStats');

        //Notifications
        Route::get('/notifications', 'UsersController@notifications');
        Route::post('/markAsRead', 'UsersController@markAsRead');

        //Get members
        Route::get('/members', 'UsersController@members')->name('user.members.index');
        Route::get('/profile/{slug}', 'UsersController@show')->name('user.profile.shoe');
        Route::post('/profile/update', 'UsersController@update')->name('user.profile.update');
        Route::post('/profile/delete', 'UsersController@destroy')->name('user.profile.destroy');

        //Get chatroom messages
        Route::get('/chatroom', 'ChatroomController@chatroom')->name('user.chatroom.index');
        Route::post('/send-message-chatroom', 'ChatroomController@sendMessage')->name('user.chatroom.send');

        //Get private messages
        Route::get('/get-conversations', 'MessagesController@getConversations')->name('user.messages.conversations');
        
        /*messages without conversation*/
        Route::get('/messages/{slug}', 'MessagesController@fetchMessages')->name('user.messages.fetchMessages');
        
        /*messages with conversation*/
        Route::get('/messages-with-conversation/{conversation_id}', 'MessagesController@fetchConvoMessages')->name('user.messages.fetchConvoMessages');
        Route::get('/get-messages/{user_id}', 'MessagesController@fetchMessages')->name('user.messages.fetchMessages');
        Route::post('/send-message/{user_id}', 'MessagesController@sendMessage')->name('user.messages.sendMessage');

        //Get mail
        Route::get('/mails', 'MailController@index')->name('user.mail.index');
        Route::get('/mails-sent', 'MailController@sent')->name('user.mail.sent');
        Route::get('/mails-starred', 'MailController@starred')->name('user.mail.starred');
        Route::get('/mails-drafted', 'MailController@drafted')->name('user.mail.drafted');
        Route::get('/mails-trashed', 'MailController@trashed')->name('user.mail.trashed');

        Route::get('/mail/{slug}', 'MailController@show')->name('user.mail.show');
        Route::post('/star-mail', 'MailController@star')->name('user.mail.star');
        Route::post('/send-mail', 'MailController@store')->name('user.mail.send');

        //Get newsfeed
        Route::get('/posts', 'PostsController@index')->name('user.posts.index');
        Route::get('/my-posts', 'PostsController@myPosts')->name('user.posts.my-posts');
        Route::get('/post/{slug}', 'PostsController@show')->name('user.posts.show');
        Route::post('/create-post', 'PostsController@store')->name('user.posts.store');
        Route::post('/update-post', 'PostsController@update')->name('user.posts.update');
        Route::post('/delete-post', 'PostsController@destroy')->name('user.posts.delete');

        //Recent profiles
        Route::get('/recent-profiles', 'UsersController@recent')->name('user.posts.recent');

        //Admin settings
        Route::any('/settings', 'AdminController@settings')->name('admin.settings');

        //Broadcasts
        Route::get('/all-broadcasts', 'BroadcastController@index')->name('user.broadcasts');
        Route::post('/upload-broadcast', 'BroadcastController@upload')->name('user.uploadBroadcast');
        Route::post('/stream-broadcast', 'BroadcastController@stream')->name('user.streamBroadcast');
        Route::post('/delete-broadcast', 'BroadcastController@destroy')->name('user.destroyBroadcast');
        Route::post('/trigger-broadcast', 'BroadcastController@trigger')->name('user.triggerBroadcast');

        //profile update
        Route::post('/update-user', 'UsersController@update')->name('user.update');
    });

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('user.dashboard');

    Route::any('/dashboard/{any}', 'HomeController@index')->where('any', '.*')->name('app');
});
