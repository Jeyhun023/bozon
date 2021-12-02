<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Cart\CartController;
use App\Http\Controllers\Api\V1\Cart\CityController;
use App\Http\Controllers\Api\V1\Cart\OrderController;
use App\Http\Controllers\Api\V1\Other\BlogController;
use App\Http\Controllers\Api\V1\Other\ContactController;
use App\Http\Controllers\Api\V1\Other\VacancyController;
use App\Http\Controllers\Api\V1\Product\BannerController;
use App\Http\Controllers\Api\V1\Product\CategoryController;
use App\Http\Controllers\Api\V1\Product\ColorController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Product\RatingController;
use App\Http\Controllers\Api\V1\User\AddressController;
use App\Http\Controllers\Api\V1\User\StoreController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\WishlistController;
use Illuminate\Support\Facades\Route;

Route::post('user/login',[LoginController::class,'login']);
    Route::post('user/resetPassword',[LoginController::class,'resetPassword']);

// Register routes
Route::post('auth/register/sendCode',[RegisterController::class,'sendCode']);
Route::post('auth/register/checkCode',[RegisterController::class,'checkVerificationCode']);
Route::post('auth/register',[RegisterController::class,'register']);

Route::apiResource('categories',CategoryController::class)->only(['index','show']);
Route::get('getCategoriesByStore/{storeId}',[CategoryController::class,'getCategoriesByStore']);
Route::apiResource('products',ProductController::class)->only(['index','show']);
Route::get('variations',[ProductController::class,'getVariations']);

Route::get('colors',[ColorController::class,'index']);

Route::get('stores',[StoreController::class,'index']);
Route::get('stores/{storeId}',[StoreController::class,'getStoreById']);

Route::get('cities',[CityController::class,'index']);

// Banners
Route::get('banners',[BannerController::class,'getAllBanners']);

// Contact
Route::post('contact',[ContactController::class,'store']);

// BLog
Route::get('posts',[BlogController::class,'index']);
Route::get('posts/{slug}',[BlogController::class,'show']);

// Vacancies
Route::get('vacancies',[VacancyController::class,'index']);
Route::get('vacancies/{slug}',[VacancyController::class,'show']);

Route::apiResource('ratings',RatingController::class)->only(['index']);

// Orders

Route::post('makeOrder',[OrderController::class,'makeOrder']);
Route::post('/order/{product_id}', [OrderController::class, 'payDirectly']);
Route::get('trackOrder/{orderNumber}',[OrderController::class,'getOrderItemsByOrderNumber']);

Route::group(['middleware' => 'auth:api'],function (){
    Route::get('auth/me',[UserController::class,'getAuthenticatedUser']);
    Route::post('auth/update',[UserController::class,'update']);
    Route::post('auth/password/update',[UserController::class,'updatePassword']);

    Route::apiResource('categories',CategoryController::class)->except(['index','show']);
    Route::apiResource('addresses',AddressController::class);
    Route::post('addresses/setDefault',[AddressController::class,'setDefault']);

    // Orders
    Route::get('orders',[OrderController::class,'getOrders']);
    Route::get('orders/{orderId}/items',[OrderController::class,'getOrderItems']);
    Route::get('orders/details',[OrderController::class,'getOrderItemsByUser']);

    // Wislist
    Route::post('addWishlist/{productId}',[WishlistController::class,'addWishlist']);
    Route::delete('removeWishlist/{productId}',[WishlistController::class,'removeWishlist']);
    Route::get('getWishlists',[WishlistController::class,'getWishlists']);

    Route::get('cart',[CartController::class,'getCart']);
    Route::post('cart',[CartController::class,'store']);
    Route::post('cart/updateProductCount',[CartController::class,'updateProductCount']);
    Route::delete('cart/{productId}/delete',[CartController::class,'removeProduct']);
    Route::delete('cart/delete',[CartController::class,'removeCart']);
    Route::apiResource('ratings',RatingController::class)->only(['store','update']);
});
