<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', 'TopController@first')->name('first');

// TOPページ
Route::get('/', 'TopController@index')->name('top');

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::get('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::get('/complete', 'Auth\RegisterController@complete')->name('complete');

// パスワード関係
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('/password/reset2', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::get('/password/reset/complete', 'Auth\ResetPasswordController@reset_complete')->name('password.reset_complete');

// ログイン認証関連
Auth::routes([
    'register' => true,
    'reset' => true,
    'verify' => true,
]);

// ログイン認証後
Route::middleware('auth:user')->group(function () {

    Route::get('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
    Route::post('/complete', 'Auth\RegisterController@complete')->name('complete');

    Route::middleware('verified')->group(function () {
        Route::get('/add_information', 'Auth\RegisterController@add_information')->name('add_information');
        Route::post('/add_information', 'Auth\RegisterController@post_add_information')->name('post_add_information');
    });
});

Route::namespace('User')->prefix('user')->name('user.')->group(function () {

    Route::namespace('Event')->group(function () {
        Route::get('/event', 'EventController@index')->name('event');
        Route::get('/event/{event}', 'EventController@show')->name('event.show');

        Route::get('/event/posts/{event}', 'EventPostController@show')->name('event.post.show');

        // イベントを作成したら同期して作成して消したら一緒に消えるようにする為不要
        // Route::post('/post', 'EventPostController@store')->name('post.store');
        // Route::delete('/posts/destroy/{post}/', 'EventPostController@destroy');

        Route::post('/event/posts/{event}/comments', 'EventCommentController@store')->name('event.comment.store');
        Route::delete('/event/posts/comments/{comment}', 'EventCommentController@destroy')->name('event.comment.destroy');

        Route::middleware('auth:user')->group(function () {
            Route::middleware('afterAuthentication')->group(function () {

                //         Route::get('/event/create', 'EventController@create')->name('event.create');
                //         Route::post('/event', 'EventController@store')->name('event.store');
                //         Route::get('/event/edit/{event}', 'EventController@edit')->name('event.edit');
                //         Route::patch('/event/{event}', 'EventController@update')->name('event.update');
                //         Route::delete('/event/{event}', 'EventController@destroy')->name('event.destroy');

                Route::post('event/{event}/participant', 'EventController@eventParticipant')->name('event.participant');
            });
        });
    });

    // 質問ページ
    Route::get('/type', 'TypeController@index')->name('type');
    Route::get('/type/select/{setid}/{nextid}', 'TypeController@select')->name('select.type');
    Route::get('/type/select_complete', 'TypeController@select_complete')->name('select_complete.type');

    //  place
    Route::namespace('Place')->group(function () {
        Route::get('/place', 'PlaceController@index')->name('place');
        Route::get('/place/{result}', 'PlaceController@result')->name('place.result');

        Route::get('/posts/{place_id}', 'PostController@index')->name('post');
        Route::get('/post/create', 'PostController@create')->name('post.create');
        Route::post('/post', 'PostController@store')->name('post.store');

        Route::delete('/posts/destroy/{post}/', 'PostController@destroy')->name('post.destroy');
    });

    // food
    Route::namespace('Food')->group(function () {
        Route::get('/food', 'FoodController@index')->name('food');
    });

    // Route::namespace('Setting')->prefix('Setting')->group(function () {
    Route::middleware('auth:user')->group(function () {
        Route::middleware('afterAuthentication')->group(function () {
            Route::get('/setting', 'SettingController@index')->name('setting');
            Route::patch('/setting/{user}', 'SettingController@update');
            Route::delete('/setting/destroy/{event}/', 'SettingController@event_destroy');
            Route::get('/settings/{user}/edit', 'SettingController@edit')->name('setting.edit');
            Route::get('/setting/withdraw', 'SettingController@withdrawal')->name('setting.withdrawl');
            Route::delete('/setting/withdraw/{user}/', 'SettingController@withdrawal_complate')->name('setting.withdrawl_complate');
        });
    });
    // });

    // contactページ
    Route::get('/contact', 'ContactFormController@index')->name('contact');
    Route::post('/contact/form', 'ContactFormController@form')->name('contact.form');
    Route::post('/contact/send', 'ContactFormController@send')->name('contact.send');
});

// });

// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'reset' => false,
        'verify' => false,
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {

        // root用
        Route::get('/', 'UsersController@index')->name('root');

        // TOPページ
        // Route::resource('home', 'HomeController', ['only' => 'index']);

        // user
        Route::get('users', 'UsersController@index')->name('users.index');
        Route::get('user/{user}', 'UsersController@show')->name('users.show');
        Route::get('user/edit/{user}', 'UsersController@edit')->name('users.edit');
        Route::patch('user/{user}', 'UsersController@update')->name('users.update');
        Route::get('user/create', 'UsersController@create')->name('users.create');
        Route::post('/user/{user}/store', 'UsersController@store')->name('users.store');
        Route::delete('/user/{user}', 'UsersController@destroy')->name('users.destroy');

        // places
        Route::get('places', 'Place\indexController@index')->name('places.index');
        Route::get('place/{place}', 'Place\indexController@show')->name('places.show')->where('place', '[0-9]+');
        Route::get('places/edit/{place}', 'Place\indexController@edit')->name('places.edit');
        Route::get('places/create', 'Place\indexController@create')->name('places.create');
        Route::patch('places/{place}', 'Place\indexController@update')->name('places.update')->where('place', '[0-9]+');
        Route::post('places/{place}', 'Place\indexController@store')->name('places.store')->where('place', '[0-9]+');
        Route::delete('places/{place}', 'Place\indexController@destroy')->name('places.destroy')->where('place', '[0-9]+');

        Route::get('places/post/{place}', 'Place\PlacePostController@index')->name('places.post.index')->where('place', '[0-9]+');

        // event
        Route::resource('events', 'Event\indexController', ['only' => ['index', 'show', 'create', 'edit', 'store', 'update', 'destroy']]);

        // Route::patch('events/{event}', 'Event\indexController@update')->name('events.update');
        // Route::post('/events/{event}/store', 'Event\indexController@store')->name('events.store');

        Route::get('event/participant/{event_id}', 'Event\Participant\ParticipantController@index')->name('participant.index')->where('event_id', '[0-9]+');
        Route::get('event/participant/create/{event_id}', 'Event\Participant\ParticipantController@create')->name('participant.create')->where('event_id', '[0-9]+');
        Route::delete(
            'event/participant/{participant_id}',
            'Event\Participant\ParticipantController@destroy'
        )->name('participant.destroy')->where('participant_id', '[0-9]+');
        Route::resource('event/participant', 'Event\Participant\ParticipantController', ['only' => ['store']]);

        Route::get('event/post/{event_id}', 'Event\EventPostController@index')->name('post.index')->where('event_id', '[0-9]+');
        Route::delete('event/post/comments/{comment}', 'Event\EventPostController@comment_destroy')->name('comment.destroy')->where('comment', '[0-9]+');

        // contact
        Route::resource('contact', 'ContactController', ['only' => 'index']);
        Route::get('contact/{contact}', 'ContactController@show')->name('contact.show');

        Route::fallback(function () { // 存在しないURLは自動的にTOPにリダイレクトさせる。
            return redirect()->route('admin.users.index');
        });
    });
});
