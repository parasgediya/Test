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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['prefix' => 'admin'], function () {

    Auth::routes();
    Route::impersonate();
    Route::group(['middleware' => 'auth'], function () {
        /*dashboard*/
        Route::get('/', 'admin\DashboardController@index');
        Route::get('/dashboard', 'admin\DashboardController@index')->name('dashboard');
        Route::get('/getCounter', 'admin\DashboardController@getCounter');

        Route::get('impersonate/user/{id}', 'admin\ImpersonateController@index');
        Route::get('impersonate/destroy', 'admin\ImpersonateController@destroy');
        
        /*User profile*/
        Route::get('profile', 'admin\UserController@getProfile');
        Route::post('save_profile', ['as' => 'save_profile', 'uses' => 'admin\UserController@saveUser']);

        /*Users*/
        Route::get('users', 'admin\UserController@users');
        Route::get('users/add', 'admin\UserController@add');
        Route::post('postUser',['as' => 'postUser', 'uses' =>'admin\UserController@postUser']);
        Route::post('users/fetchData', 'admin\UserController@getUsers');
        Route::get('users/edit/{id}', 'admin\UserController@add');
        Route::post('updateRole','admin\UserController@updateRole');
        Route::post('users/del','admin\UserController@deleteUser');
        

        /*Clubs*/
        Route::get('clubs/add', 'admin\ClubController@clubs');
        Route::post('clubs/add', 'admin\ClubController@postClub');
        Route::post('clubs/fetchData', 'admin\ClubController@Displaydata');
        Route::post('clubs/getformdata', 'admin\ClubController@getformdata');
        Route::post('clubs/del', 'admin\ClubController@delClub');

        /*Teams*/
        Route::get('teams', 'admin\TeamController@teams');
        Route::post('teams', 'admin\TeamController@postData');
        Route::post('teams/fetchData', 'admin\TeamController@Displaydata');
        Route::post('teams/getformdata', 'admin\TeamController@getformdata');
        Route::post('teams/del', 'admin\TeamController@delTeam');

        /*Group*/
        Route::get('groups', 'admin\GroupController@groups');
        Route::post('groups', 'admin\GroupController@postData');
        Route::post('groups/fetchData', 'admin\GroupController@Displaydata');
        Route::post('groups/getformdata', 'admin\GroupController@getformdata');
        Route::post('groups/del', 'admin\GroupController@delGroup');

        /*Playees*/
        Route::get('players', 'admin\PlayerController@players');
        Route::post('players', 'admin\PlayerController@postData');
        Route::post('players/fetchData', 'admin\PlayerController@Displaydata');
        Route::post('players/getformdata', 'admin\PlayerController@getformdata');
        Route::post('players/del', 'admin\PlayerController@delPlayer');
        Route::post('cmbGroup','admin\PlayerController@cmbGroup');

    });

});