<?php

use App\Http\Controllers\Api\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:api')->prefix('auth')->group(function() {
//     Route::post("/register",[AuthController::class,'Register']);
//     Route::post("/login",[AuthController::class,'Login']);
// });

Route::group(['middleware'=>'api','prefix'=>'auth'], function($router){
    Route::post("register",[AuthController::class,'register']);
    Route::post("login",[AuthController::class,'login']);
});