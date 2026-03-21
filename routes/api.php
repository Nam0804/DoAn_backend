<?php

use App\Http\Controllers\Api\AdminAuth;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\BorderApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\InvoiceDetailApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RevenueController;
use App\Http\Controllers\Api\ToppingApiController;
use App\Http\Controllers\Api\TypeApiController;
use App\Http\Controllers\Api\TypeOfMeatApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BlogImageUploadController;
use App\Http\Controllers\RolesAndPermissionsController;
use Whoops\Run;

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
Route::get('show_by_id/{id}', [ProductApiController::class, 'showProductById']);
Route::resource('products', ProductApiController::class);
Route::resource('categories', CategoryApiController::class);
Route::resource('typeofmeats', TypeOfMeatApiController::class);
Route::resource('types', TypeApiController::class);
Route::resource('toppings', ToppingApiController::class);
Route::resource('borders', BorderApiController::class);

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::post('auth/admin/login', [AdminAuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/admin/logout', [AdminAuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('index-users',[UserController::class,'index'])->middleware('permission:view_user');
    Route::post('create-user',[UserController::class,'create'])->middleware('permission:create_user');
    Route::get('show-user/{id}',[UserController::class,'showUserById']);
    Route::put('update-user/{id}',[UserController::class,'update'])->middleware('permission:edit_user');
    Route::delete('delete-user/{id}',[UserController::class,'destroy'])->middleware('permission:delete_user');
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/update-profile/{id}', [UserController::class,'profileUpdate']);
    Route::get('index-invoices',[InvoiceApiController::class,'index']);
    Route::get('show/{id}',[InvoiceApiController::class,'show']);
    Route::get('show-invoice/{id}',[InvoiceDetailApiController::class,'invoiceDetailById']);
    Route::get('revenue',[RevenueController::class,'getRevenue']);
});



Route::post('cart/store', [CartApiController::class, 'store']);
Route::delete('cart/deleteAll', [CartApiController::class, 'deleteAll']);
    Route::post('vn_payment', [ProductApiController::class, 'vnpayment']);

Route::post('/upload-image', [BlogImageUploadController::class, 'upload']);

Route::resource('blogs',BlogApiController::class);

Route::post('admin-asign-role',[RolesAndPermissionsController::class,'assignRoleForAdmin']);

Route::get('roles-and-permissions', [RolesAndPermissionsController::class,'showPermissions']);
Route::post('assignRole/{user_id}/{user_type}',[RolesAndPermissionsController::class,'assignRole']);

Route::get('/setup-db', function () {
    Artisan::call('migrate', ['--force' => true]);

    Artisan::call('db:seed', ['--force' => true]);

    // Trả về chuẩn JSON cho đúng với phong cách API
    return response()->json([
        'status' => 'success',
        'message' => 'Chạy Migration thành công! Bảng đã được tạo.'
    ]);
});
