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

Auth::routes(['verify' => true]);
Route::get('/','HomeController@index')->name('home');
Route::get('/language/{lang}','setLanguagesCookiesController@index');
Route::get('/contacts','HomeController@contacts')->name('contacts');
Route::get('/advert/{type}/{id}','AdvertsController@index')->name('advert');
Route::get('/articles','ArticlesController@index')->name('articles');
Route::get('/article/{id}','ArticlesController@single')->name('article-single');
Route::get('/forum','ForumController@index')->name('forum');
Route::get('/forum-categories','ForumController@categories')->name('forum-categories');
Route::get('/forum-single','ForumController@single')->name('forum-single');
Route::get('/search','SearchController@index')->name('search');
Route::get('/search-results','AdvertsController@search_results')->name('search-results');

Route::get('error', function() {
    return view('errors.page');
})->name('error-page');


Route::group(['middleware' => ['guest']], function() {
  Route::get('auth','AuthController@showAuthForms')->name('auth');
  Route::post('login_user', 'Auth\ManualLoginController@authenticate')->name('login');
  Route::post('register', 'Auth\ManualRegisterController@register')->name('register');
  Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

  //Socialite
    Route::get('login/social/{provider}', 'Auth\SocialController@redirectToProvider');
    Route::get('login/social/callback/{provider}', 'Auth\SocialController@handleProviderCallback');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('verify', 'AuthController@verifyForms')->name('verify');
    Route::get('/profile','ProfileController@show_profile')->name('profile');
    Route::get('/my-adverts','AdvertsController@my_adverts')->name('my-adverts');
    Route::get('/my-topics','ForumController@my_topics')->name('my-topics');
    Route::get('/topic-edit/{id}','ForumController@edit')->name('topic-edit');
    Route::post('/update-profile','ProfileController@update_profile')->name('update-profile');
    Route::post('/update-avatar','ProfileController@update_avatar')->name('update-avatar');
    Route::post('/get-avatar','ProfileController@get_avatar')->name('get-avatar');
    Route::post('/delete-profile','ProfileController@delete_user')->name('delete-profile');

    Route::group(['middleware' => 'verified'], function() {
        //New
        Route::get('/new-advert','AdvertsController@show')->name('new-advert');
        Route::get('/new-car','AdvertsController@new_car')->name('new-car');
        Route::get('/new-motobike','AdvertsController@new_motobike')->name('new-motobike');
        Route::get('/new-truck','AdvertsController@new_truck')->name('new-truck');
        Route::get('/new-under-truck','AdvertsController@new_under_truck')->name('new-under-truck');
        Route::get('/new-semi','AdvertsController@new_semi')->name('new-semi');
        Route::get('/new-autotrains','AdvertsController@new_autotrains')->name('new-autotrains');
        Route::get('/new-buses','AdvertsController@new_buses')->name('new-buses');
        //New
    });

});


Route::group(['middleware' => 'admin'], function() {
    //New
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/new-brands','DashboardController@brands')->name('brands');
    Route::post('/store-brand','DashboardController@store_brand')->name('store-brand');
    //New
});

