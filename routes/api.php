<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'APILoginController@login');
Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

Route::group(["middleware" => ["jwt.auth"]], function () {
    Route::get('posts', 'PostController@index')->middleware(["role:admin","permission:get post"]);
    Route::get('posts/{id}', 'PostController@show')->middleware(["role:admin","permission:get post"]);
    Route::post('posts', 'PostController@store')->middleware(["role:admin","permission:create post"]);
    Route::put('posts/{id}', 'PostController@update')->middleware(["role:admin","permission:update post"]);
    Route::delete('posts/{id}', 'PostController@destroy')->middleware(["role:admin","permission:delete post"]);
});


Route::post("/role", "RolePermissionController@createRole");
Route::get("/role", "RolePermissionController@getRoles");

Route::post("/permission", "RolePermissionController@createPermission");
Route::get("/permission", "RolePermissionController@getPermissions");
Route::put("/role/{id}/permission", "RolePermissionController@addPermissionsToRole");
Route::put("/role/{role_id}/{user_id}", "RolePermissionController@assignRoleToUser");
