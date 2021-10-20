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
	return redirect('login');
    //return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => ['auth','verify.admin']], function () {
	Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
	Route::get('maps', ['as' => 'pages.maps', 'uses' => 'PageController@maps']);
	Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
	Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'PageController@rtl']);
	Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
	Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
	Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'PageController@upgrade']);
});

Route::group(['middleware' => ['auth','verify.admin']], function () {
	Route::get('view-user/{user_id}', ['as' => 'view-user', 'uses' => 'UserController@viewuser']);
	Route::get('user-list', 'UserController@filterusers');
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('view-profile', ['as' => 'profile.view', 'uses' => 'ProfileController@view']);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => ['auth','verify.admin']], function () {
	Route::get('projects', ['as' => 'projects', 'uses' => 'ProjectsController@index']);

	Route::get('add-project', ['as' => 'add-project', 'uses' => 'ProjectsController@addproject']);
	Route::post('save-project', ['as' => 'save-project', 'uses' => 'ProjectsController@saveproject']);

	Route::get('edit-project/{project_id}', ['as' => 'edit-project', 'uses' => 'ProjectsController@editproject']);
	Route::post('save-edited-project', ['as' => 'save-edited-project', 'uses' => 'ProjectsController@saveEditedProject']);
	
	Route::get('view-project/{project_id}', ['as' => 'view-project', 'uses' => 'ProjectsController@viewproject']);
	Route::get('projects-list', 'ProjectsController@filterprojects');

	Route::get('delete-project/{project}', ['as' => 'delete-project', 'uses' => 'ProjectsController@deleteproject']); 
});

Route::group(['middleware' => ['auth','verify.admin']], function () {
	Route::get('dsr', ['as' => 'dsr', 'uses' => 'DsrAdminController@index']);
	Route::get('view-dsr/{dsr_id}', ['as' => 'view-dsr', 'uses' => 'DsrAdminController@viewDsrEntry']);
});

/* ------------------------------------- Employee routes ------------------------------------------- */

Route::group(['middleware' => ['auth','verify.notadmin']], function () {
	Route::get('my-profile', ['as' => 'my-profile', 'uses' => 'Employee\EmployeeProfileController@index']);
	Route::get('edit-profile', ['as' => 'edit-profile', 'uses' => 'Employee\EmployeeProfileController@edit']);
	Route::post('save-profile', ['as' => 'save-profile', 'uses' => 'Employee\EmployeeProfileController@saveProfile']);
	Route::get('update-password', ['as' => 'update-password', 'uses' => 'Employee\EmployeeProfileController@updatePassword']);
	Route::post('save-password', ['as' => 'save-password', 'uses' => 'Employee\EmployeeProfileController@savePassword']);
	//Route::get('edit-profile}', ['as' => 'edit-profile', 'uses' => 'ProfileController@edit']);
	///Route::post('update-profile', ['as' => 'save-project', 'uses' => 'ProfileController@update']);
	Route::get('assigned-projects', ['as' => 'assigned-projects', 'uses' => 'Employee\EmployeeProfileController@assignedProjects']);
	Route::get('project/{project_id}', ['as' => 'project', 'uses' => 'Employee\EmployeeProfileController@viewproject']);
});

Route::group(['middleware' => ['auth','verify.notadmin']], function () {
	Route::get('fill-dsr', ['as' => 'fill-dsr', 'uses' => 'Employee\DsrController@index']);
	Route::post('save-employee-dsr', ['as' => 'save-employee-dsr', 'uses' => 'Employee\DsrController@saveDsr']);
	Route::get('edit-dsr/{dsr_id}', ['as' => 'edit-dsr', 'uses' => 'Employee\DsrController@editDsr']);
	Route::post('save-edited-dsr', ['as' => 'save-edited-dsr', 'uses' => 'Employee\DsrController@saveEditedDsr']);
	Route::get('send-email', ['as' => 'send-email', 'uses' => 'Employee\DsrController@sendEmail']);
});
