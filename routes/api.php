<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\TypeApiController;
use App\Http\Controllers\Api\TypeOfMeatApiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('products_by_id/{id}', [ProductApiController::class, 'getAllById']);
Route::resource('products', ProductApiController::class);
Route::resource('categories', CategoryApiController::class);
Route::resource('typeofmeats', TypeOfMeatApiController::class);
Route::resource('types', TypeApiController::class);

Route::post('auth/register',[AuthController::class,'register']);
Route::post('auth/login',[AuthController::class,'login']);