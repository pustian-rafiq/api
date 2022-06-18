<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:api')->prefix('auth')->group(function() {
//     Route::post("/register",[AuthController::class,'Register']);
//     Route::post("/login",[AuthController::class,'Login']);
// });

// Route::group(['middleware'=>'api','prefix'=>'auth'], function($router){
//     Route::post("register",[AuthController::class,'register']);
//     Route::post("login",[AuthController::class,'login']);
//     Route::get("/profile",[AuthController::class,'profile']);
   
// });

//Person routes
Route::prefix('auth')->group(function (){

    Route::post("/login",[AuthController::class, 'login']);
    Route::post("/register",[AuthController::class, 'register']);
   
});

//Page routes
Route::group(['middleware'=>'auth:api','prefix'=>'page'], function($router) {
    Route::post("/create",[PageController::class, 'store']);
});
//Post routes for person
Route::group(['middleware'=>'auth:api','prefix'=>'person'], function($router) {
    Route::post("/attach-post",[PostController::class, 'UserPostStore']);
    Route::get("/feed",[PostController::class, 'GetAllPost']);
});

//Post routes for page
Route::group(['middleware'=>'auth:api','prefix'=>'page'], function($router) {
    Route::post("/{id}/attach-post",[PostController::class, 'PagePostStore']);
});

//Page and user follower routes
Route::group(['middleware'=>'auth:api','prefix'=>'follow'], function($router) {
    Route::put("/page/{id}",[PageController::class, 'AddPageFollower']);
    Route::put("/person/{id}",[UserController::class, 'AddUserFollower']);
});

//Page and user follower routes
// Route::group(['middleware'=>'auth:api','prefix'=>'person'], function($router) {
//     Route::put("/feed",[UserController::class, 'GetFollowingUser']);
// });

 

// Route::get("users",[UserController::class,'GetUser']);