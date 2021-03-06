<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('posts', 'PostController');
Route::get('/post-detail/{id}', 'PostController@detail')->name('Post Detail');

Route::resource('users', 'UserController');

Route::resource('notifications', 'NotificationController');

Route::get('privacy', array('as' => 'privacy', function()
{
    return View::make('pages/privacy');
}));

Route::get('/pusher', function() {
    event(new App\Events\PostPusherEvent('Hi there Pusher!'));
    return "Event has been sent!";
});

