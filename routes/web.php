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
    // return view('front-side.dashboard');
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('crm','CrmController');
    Route::resource('paxprofile','PaxProfileController');
    Route::resource('passport','PassportController');
    Route::resource('membershipcard','MembershipCardController');
    Route::resource('protector','ProtectorController');
    Route::resource('accountopen','AccountOpenController');
    Route::resource('dashboard','DashboardController');
});

// Route::get('admin/dashboard', 'AdminController@index')->name('admin.home')->middleware('is_admin');


// Route::prefix('admin')->middleware(['is_admin'])->group(function () {
//    Route::get('/dashboard', 'admin\DashboardController@index')->name('dashboard');
//    // Route::get('/airlienList', 'admin\AirlineListController@index');
//    Route::resource('airlienList', 'admin\AirlineListController')->name('airlienList');
// });

Route::group(array('namespace' => 'admin', 'prefix' => 'admin','middleware' => 'is_admin'), function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/getRolePermission', 'UserController@getRolePermission')->name('getRolePermission');
    Route::resource('airlienList', 'AirlineListController');
    Route::resource('airlineGroup', 'AirlineGroupController');
    Route::resource('users', 'AirlineGroupController');
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('permissions','PermissionController');
    Route::resource('services','ServiceController');
    Route::resource('under','UnderController');
});
// Route::group(['prefix' => 'admin'], function(){
// 	Route::get('/dashboard', 'admin\DashboardController@index')->name('dashboard');
//     Route::resource('airlienList', 'AirlineListController');
// });
