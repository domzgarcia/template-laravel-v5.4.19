<?php

/*
|-------------
| Web Routes
|-------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|-------------------
| Login Redirection
|-------------------
*/
Route::get('/login', function(){
	return redirect('/admin/login');
});
Route::get('/dashboard', function(){
	return redirect('/admin/dashboard');
});
/*
|----------------------------------------------------------
| Mail From User (action trigger outside no auth required)
|----------------------------------------------------------
*/
Route::post('/user/send_inquiry','UserInquiriesController@send_inquiry');

Route::group(['prefix' => 'admin'], function(){
	Auth::routes();
	Route::get('/', function(){
		return redirect('admin/login');
	});

	Route::group(['middleware' => ['auth','roles']], function(){

		Route::get('/dashboard', function() {
			if(Auth::user()->role_id == 3){
				return redirect('/admin/inquiry');
			}
			return view('cms.pages.dashboard');
		});
		/*
		  |-------------------
          | Register Redirect
          |-------------------
        */
		Route::get('/user', function() {
			return 'User Registered Successfully.';
		});
		/*
		  |----------------
          | Role - Editors
          |----------------
        */
        Route::group( ['roles' => ['Editors'] ] , function(){
			Route::get('/pages/news', function() { 
				return view('cms.pages.default');
			});
			Route::get('/pages/about', function() { 
				return view('cms.pages.default');
			});
			Route::get('/pages/faq', function() { 
				return view('cms.pages.default');
			});
			Route::get('/homepage_default', function() {
				return view('cms.pages.default');
			});
		});
		/*
		  |--------------------
          | Role - Moderators
          |--------------------
        */
        Route::group( ['roles' => ['Moderators'] ] , function(){
			Route::get('/mailer', 'UserInquiriesController@render_mailer'); # Added mailer for testing while no website were ready.
			Route::get('/inquiry', 'UserInquiriesController@index'); # All inquiry here
			Route::get('/inquiry/inbox', 'UserInquiriesController@get_inbox'); # All inquiry here
		});
		/*
		  |-----------------------
          | Role - Administrators
          |-----------------------
        */
		Route::group(['roles' => ['Administrators']], function(){
			Route::get('/user_settings', 'UserSettingsController@index');
			Route::get('/user_settings/show/{id}', 'UserSettingsController@show');
			Route::post('/user_settings/store', 'UserSettingsController@store');
			Route::post('/user_settings/update', 'UserSettingsController@update');
			Route::post('/user_settings/destroy', 'UserSettingsController@destroy');
			Route::post('/user_settings/unlock', 'UserSettingsController@unlock');
		});
		/*
		  |------------
          | My Account
          |------------
        */
		Route::get('/my_account', 'UserProfileController@index');
		Route::post('/my_account/update', 'UserProfileController@update');

	//-End-Of-Auth-Page-
	});
});