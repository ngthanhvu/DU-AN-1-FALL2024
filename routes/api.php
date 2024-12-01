<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;

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
Route::middleware('auth:api')->get('/admin/users', [UserController::class, 'getAllUsers']);

// Các API khác vẫn cần xác thực
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('skus', SkuController::class);
Route::apiResource('images', ImageController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('address', AddressController::class);

// Routes đăng ký, đăng nhập, lấy thông tin người dùng, và logout
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::get('user', [UserController::class, 'getUser'])->middleware('auth:api');
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::put('/users/{id}/role', [UserController::class, 'updateRole']);
Route::middleware('auth:api')->group(function () {
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::post('password/forgot', [UserController::class, 'forgotPassword']);
Route::post('password/reset', [UserController::class, 'resetPassword']);

Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'getCart']);
Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
Route::post('/cart/update', [CartController::class, 'updateQuantity']);
Route::delete('cart/clear/{userId}', [CartController::class, 'clearCart']);
Route::apiResource('carts', CartController::class);

Route::post('/posts', [PostController::class, 'store']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::delete('posts/{id}', [PostController::class, 'destroy']);
Route::put('posts/{id}', [PostController::class, 'update']);
Route::apiResource('posts', PostController::class);

Route::post('/payment', [PaymentController::class, 'create']);
Route::get('/payment/callback', [PaymentController::class, 'callback']);

Route::post('/momo', [MomoController::class, 'create']);
Route::get('/momo/callback', [MomoController::class, 'callback']);

Route::post('/discounts', [DiscountController::class, 'createDiscount']);
Route::get('/discounts', [DiscountController::class, 'getDiscounts']);
Route::post('/discounts/apply', [DiscountController::class, 'applyDiscount']);
Route::delete('/discounts/{id}', [DiscountController::class, 'deleteDiscount']);
Route::put('/discounts/{id}', [DiscountController::class, 'update']);

Route::apiResource('orders', OrderController::class);
Route::get('/orders/{orderId}', [OrderController::class, 'getOrderStatus']);
Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUserId']);
Route::get('/orders', [OrderController::class, 'getOdersAll']);
Route::put('/orders/{orderId}', [OrderController::class, 'updateOrderStatus']);

Route::get('orders/{orderId}/details', [OrderDetailController::class, 'index']);
Route::post('order-details', [OrderDetailController::class, 'store']);

Route::get('product/view', [ProductController::class, 'view']);
Route::get('/products/category/{categoryId}', [ProductController::class, 'getProductsByCategory']);

Route::get('comments/{productId}', [CommentController::class, 'getComments']);
Route::post('/comments', [CommentController::class, 'store']);
