<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


/* Temporary Tenant bypass */
//Session::put('dealerId', 3);

/* Authentication routes */
Route::get('/', 'LoginController@index');

Route::controllers([
    'password' => 'Auth\PasswordController',
    'register' => 'Auth\AuthController',
    'login' => 'Auth\AuthController',
    'logout' => 'Auth\AuthController',
]);

Route::post('username', 'Auth\PasswordController@username');

Route::get('register', 'Auth\AuthController@register');

Route::post('register', 'Auth\AuthController@postRegister');

Route::post('login', 'Auth\AuthController@postLogin');
Route::get('login', 'Auth\AuthController@getLogin');

Route::get('logout', 'Auth\AuthController@getLogout');

/* end Authentication routes */


Route::get('products', ['middleware' => 'auth', 'uses'=>'ProductsController@index']);
Route::get('product/{id}', ['middleware' => 'auth', 'uses'=>'ProductsController@product']);
Route::get('productsearch', ['middleware' => 'auth', 'uses'=>'ProductsController@productSearch']);

Route::get('estimates', ['middleware' => 'auth', 'uses'=>'EstimatesController@index']);
Route::get('estimates/getEstimates', ['middleware' => 'auth', 'uses'=>'EstimatesController@getEstimates']);
Route::get('estimates/getEstimateDetails', ['middleware' => 'auth', 'uses'=>'EstimatesController@getEstimateDetails']);
Route::get('estimates/getSections', ['middleware' => 'auth', 'uses'=>'EstimatesController@getSections']);
Route::post('estimates/create', ['middleware' => 'auth', 'uses'=>'EstimatesController@create']);
Route::post('estimates/createSection', ['middleware' => 'auth', 'uses'=>'EstimatesController@createSection']);
Route::post('estimates/addProduct', ['middleware' => 'auth', 'uses'=>'EstimatesController@addProduct']);
Route::get('estimates/export', ['middleware' => 'auth', 'uses'=>'EstimatesController@exportEstimate']);
Route::get('estimates/deleteEstimate', ['middleware' => 'auth', 'uses'=>'EstimatesController@deleteEstimate']);
//Route::post('estimates/updateEstimate', ['middleware' => 'auth', 'uses'=>'EstimatesController@updateEstimate']);
Route::get('estimates/updateEstimate', ['middleware' => 'auth', 'uses'=>'EstimatesController@updateEstimate']);

Route::get('statements', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@statements']);
Route::post('statements', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@statements']);
Route::get('statements/getDoc', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@getDoc']);
Route::get('transactions', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@transactions']);
Route::get('transactions/getDoc', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@getDoc']);
Route::get('transactions/getDetails', ['middleware' => ['auth', 'services'], 'uses'=>'AccountingController@getDetails']);

Route::get('relationships', ['middleware' => 'auth', 'uses'=>'RelationshipsController@index']);
Route::get('logInAs/{id}', ['middleware' => 'auth', 'uses'=>'RelationshipsController@logInAs']);
Route::get('relationships/follow/{id}', ['middleware' => 'auth', 'uses'=>'RelationshipsController@follow']);
Route::get('relationships/unfollow/{id}', ['middleware' => 'auth', 'uses'=>'RelationshipsController@unfollow']);
Route::get('relationships/followAll', ['middleware' => 'auth', 'uses'=>'RelationshipsController@followAll']);
Route::get('relationships/unfollowAll', ['middleware' => 'auth', 'uses'=>'RelationshipsController@unfollowAll']);
Route::get('relationships/recentActivity/{id}', ['middleware' => 'auth', 'uses'=>'RelationshipsController@recentActivity']);
Route::get('logInAsMe', 'RelationshipsController@logInAsMe');

Route::get('account', ['middleware' => 'auth', 'uses'=>'AccountController@index']);
Route::get('accountTest', ['middleware' => 'auth', 'uses'=>'AccountController@accountTest']);

Route::get('settings', ['middleware' => 'auth', 'uses'=>'SettingsController@index']);
Route::post('settings/update', ['middleware' => 'auth', 'uses'=>'SettingsController@updatePersonal']);
Route::post('settings/password', ['middleware' => 'auth', 'uses'=>'SettingsController@updatePassword']);

/* Dealer Admin routes */
// TODO: prevent other users from getting access
Route::get('/admin', ['middleware' => 'auth', 'uses'=>'DealerAdminController@index']);
/* end Dealer Admin routes */


/* BuilderLink Admin routes */
// TODO: prevent other users from getting access
Route::get('users', ['middleware' => 'auth', 'uses'=>'AccountController@associate']);
Route::get('dealers', ['middleware' => 'auth', 'uses'=>'AdminController@dealers']);
Route::get('import', ['middleware' => 'auth', 'uses'=>'AdminController@import']);
/* end BuilderLink Admin routes */

