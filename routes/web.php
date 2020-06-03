<?php

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

Route::get('/', function () {
    return view('home');
})->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'api'], function () {
        //Get home statistics
        Route::get('/home-statistics', 'HomeController@getStats')->name('user.home.getStats');

        //Notifications
        Route::get('/notifications', 'UsersController@notifications');
        Route::post('/markAsRead', 'UsersController@markAsRead');

        //Get members
        Route::get('/members', 'UsersController@members')->name('user.members.index');
        Route::get('/profile/{slug}', 'UsersController@show')->name('user.profile.shoe');
        Route::post('/profile/update', 'UsersController@update')->name('user.profile.update');

        //Get chatroom messages
        Route::get('/chatroom', 'ChatroomController@chatroom')->name('user.chatroom.index');
        Route::post('/send-message-chatroom', 'ChatroomController@sendMessage')->name('user.chatroom.send');

        //Get private messages
        Route::get('/get-conversations', 'MessagesController@getConversations')->name('user.messages.conversations');
        
        /*messages without conversation*/
        Route::get('/messages/{slug}', 'MessagesController@fetchMessages')->name('user.messages.fetchMessages');
        
        /*messages with conversation*/
        Route::get('/messages-with-conversation/{conversation_id}', 'MessagesController@fetchConvoMessages')->name('user.messages.fetchConvoMessages');
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

        //Recent profiles
        Route::get('/recent-profiles', 'UsersController@recent')->name('user.posts.recent');

        //Admin settings
        Route::any('/settings', 'AdminController@settings')->name('admin.settings');
        Route::post('/trigger-broadcast', 'BroadcastController@triggerBroadcast')->name('user.triggerBroadcast');
    });

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('user.dashboard');

    Route::any('/dashboard/{any}', 'HomeController@index')->where('any', '.*')->name('app');
});
