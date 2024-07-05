<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegistarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[RegistarController::class,'register']);
Route::post('login',[RegistarController::class,'login']);


Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::resource('product',ProductController::class);
    Route::get('logout',[RegistarController::class,'logout']);

});