<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function (){
	//======================================================================
	// GENERIC CRUD BY TABLE NAME 
	//======================================================================
	Route::get('getRowByTableName/{data_table_name}/{id}', 'GenericClassCrudController@getRowByTableName');
	Route::post('insertRowByTableName', 'GenericClassCrudController@insertRowByTableName');
	Route::put('updateRowByTableName', 'GenericClassCrudController@updateRowByTableName');
	Route::delete('deleteRowByTableName', 'GenericClassCrudController@deleteRowByTableName');

	//Account Verification
	Route::get('accountVerification/{username}/{password}', 'AccountController@accountVerification');
});