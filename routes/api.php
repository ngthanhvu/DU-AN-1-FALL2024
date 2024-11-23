<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
| Đăng ký các route API cho ứng dụng.
|
| Các route này được tải bởi RouteServiceProvider và tất cả chúng sẽ được
| gán cho nhóm middleware "api". Hãy tạo ra điều tuyệt vời!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Các API khác vẫn cần xác thực
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('skus', SkuController::class);
Route::apiResource('images', ImageController::class);
Route::apiResource('users', UserController::class);

// Routes đăng ký, đăng nhập, lấy thông tin người dùng, và logout
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('user', [UserController::class, 'getUser'])->middleware('auth:api');
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:api');

Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'getCart']);
Route::post('/cart/remove', [CartController::class, 'removeFromCart']);

Route::apiResource('carts', CartController::class);
