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

	// Route for Admin Users creation, updation and listing
	Route::get('admins', ['as' => 'admins', 'uses' => 'UserController@allAdmins']);
	Route::get('add-admin', ['as' => 'add-admin', 'uses' => 'UserController@addAdmin']);
	Route::post('save-admin', ['as' => 'save-admin', 'uses' => 'UserController@saveAdmin']);
	Route::get('edit-admin/{admin}', ['as' => 'edit-admin', 'uses' => 'UserController@editAdmin']);
	Route::put('save-edited-admin/{admin}', ['as' => 'save-edited-admin', 'uses' => 'UserController@saveEditedAdmin']);
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

	Route::get('backdate-dsr-requests', ['as' => 'backdate-dsr-requests', 'uses' => 'DsrAdminController@viewDsrBackDateEntries']);
	Route::get('approve-backdate-dsr-request/{id}', ['as' => 'approve-backdate-dsr-request', 'uses' => 'DsrAdminController@approveBackdateDsrRequest']);
});

Route::group(['middleware' => ['auth','verify.admin']], function () {
	Route::get('reports', ['as' => 'reports', 'uses' => 'ReportsController@index']);
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
	
	Route::get('delete-dsr/{dsr_id}', ['as' => 'delete-dsr', 'uses' => 'Employee\DsrController@deleteDsr']);
	Route::get('old-dsr', ['as' => 'old-dsr', 'uses' => 'Employee\DsrController@viewOldDsr']);

	Route::get('backdate-request', ['as' => 'backdate-request', 'uses' => 'Employee\DsrController@BackDateRequest']);
	Route::post('save-backdate-request', ['as' => 'save-backdate-request', 'uses' => 'Employee\DsrController@saveBackDateRequest']);

	Route::get('add-old-date-dsr/{token}', ['as' => 'add-old-date-dsr', 'uses' => 'Employee\DsrController@addOldDayDSR']);
	Route::post('save-old-date-dsr/{token}', ['as' => 'save-old-date-dsr', 'uses' => 'Employee\DsrController@saveOldDateDsr']);

	Route::get('edit-old-date-dsr/{dsrId}/{token}', ['as' => 'edit-old-date-dsr', 'uses' => 'Employee\DsrController@editOldDayDSR']);
	Route::post('save-edited-olddate-dsr/{token}', ['as' => 'save-edited-olddate-dsr', 'uses' => 'Employee\DsrController@saveEditedOldDateDsr']);

	Route::get('send-email', ['as' => 'send-email', 'uses' => 'Employee\DsrController@sendEmail']);
});

/*-------------------------------------Routes for TL section------------------------------------------*/

Route::group(['middleware' => ['auth','verify.notadmin']], function(){
	Route::get('tl/projects', ['as' => 'tl/projects', 'uses' => 'Employee\TlProjectController@index']);
	Route::get('tl/projects-list', 'Employee\TlProjectController@filterprojects'); 

	Route::get('tl/add-project',['as' => 'tl/add-project', 'uses' => 'Employee\TlProjectController@addproject']);
	Route::post('tl/save-project', ['as' => 'tl/save-project', 'uses' => 'Employee\TlProjectController@saveproject']);

	Route::get('tl/edit-project/{project_id}', ['as' => 'tl/edit-project', 'uses' => 'Employee\TlProjectController@editproject']);
	Route::post('tl/save-edited-project', ['as' => 'tl/save-edited-project', 'uses' => 'Employee\TlProjectController@saveEditedProject']);

	Route::get('tl/view-project/{project_id}', ['as' => 'tl/view-project', 'uses' => 'Employee\TlProjectController@viewproject']);
});


// Special section for Mirror sites tracker sheet and is for both admin and some specific employees

Route::get('mirror-sheet', 'MirrorsSheetController@index')->name('mirror-sheet')->middleware('auth');
Route::get('add-task', 'MirrorsSheetController@addtask')->name('add-task')->middleware('auth');
Route::post('save-task', ['as' => 'save-task', 'uses' => 'MirrorsSheetController@saveTask']);
Route::get('task-list', 'MirrorsSheetController@taskList');

Route::get('view-task/{task}', 'MirrorsSheetController@viewtask')->name('view-task')->middleware('auth');
Route::get('edit-task/{task}', 'MirrorsSheetController@edittask')->name('edit-task')->middleware('auth');
Route::post('save-edited-task/{task}', ['as' => 'save-edited-task', 'uses' => 'MirrorsSheetController@saveEditedTask']);
