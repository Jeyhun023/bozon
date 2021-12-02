<?php

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'adminLogin']);

Route::group(['prefix' => '/v2/admin/', 'middleware' => 'admin_user'], function () {
    Route::post('/admin/logout', function () {
        \Illuminate\Support\Facades\Auth::guard('admin_user')->logout();
        \Illuminate\Support\Facades\Auth::guard('seller')->logout();
        return redirect()->route('admin.login');
    })->name('admin.logout');

    Route::group(['middleware' => 'checkRole:admin|seller|courier'], function () {
        Route::get('/orders/index', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{orderId}/{type}/showDetail', [App\Http\Controllers\Admin\OrderController::class, 'showDetail'])->name('orders.showDetail');
        Route::delete('orders/{detailId}/detail', [App\Http\Controllers\Admin\OrderController::class, 'deleteOrderDetail'])->name('orders.deleteOrderDetail');
        Route::post('orders/detail/update', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderDetailStatus'])->name('orders.updateOrderDetailStatus');
    });

    Route::group(['middleware' => 'checkRole:admin'], function () {
        Route::get('/con/index', [\App\Http\Controllers\Admin\ContactFormController::class, 'index'])->name('con.index');
        Route::delete('/con/delete/{con}', [\App\Http\Controllers\Admin\ContactFormController::class, 'destroy'])->name('con.destroy');
        Route::delete('/con_destroyAllSelections', [\App\Http\Controllers\Admin\ContactFormController::class, 'destroyAllSelections'])->name('con.deleteSelections');

        Route::get('/appeals/index', [\App\Http\Controllers\Admin\AppealsController::class, 'index'])->name('appeals.index');
        Route::delete('/appeals/delete/{appeal}', [\App\Http\Controllers\Admin\AppealsController::class, 'destroy'])->name('appeals.destroy');
        Route::delete('/appeals_destroyAllSelections', [\App\Http\Controllers\Admin\AppealsController::class, 'destroyAllSelections'])->name('appeals.deleteSelections');
        Route::put('/appeals/update_status/{appeal}', [\App\Http\Controllers\Admin\AppealsController::class, 'update_status'])->name('appeals.status');

        Route::delete('/banner_destroyAllSelections', [\App\Http\Controllers\Admin\BannerController::class, 'destroyAllSelections'])->name('banner.deleteSelections');
        Route::delete('/city_destroyAllSelections', [\App\Http\Controllers\Admin\CityController::class, 'destroyAllSelections'])->name('cities.deleteSelections');
        Route::delete('/clients_destroyAllSelections', [\App\Http\Controllers\Admin\UserController::class, 'destroyAllSelections'])->name('clients.deleteSelections');
        Route::delete('/admin_destroyAllSelections', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroyAllSelections'])->name('admin.deleteSelections');
        Route::delete('/magaza_destroyAllSelections', [\App\Http\Controllers\Admin\MagazaController::class, 'destroyAllSelections'])->name('magaza.deleteSelections');
        Route::delete('/blog_destroyAllSelections', [\App\Http\Controllers\Admin\BlogController::class, 'destroyAllSelections'])->name('blog.deleteSelections');
        Route::delete('/vacancy_destroyAllSelections', [\App\Http\Controllers\Admin\VacancyController::class, 'destroyAllSelections'])->name('vacancy.deleteSelections');
        Route::delete('/seller_destroyAllSelections', [\App\Http\Controllers\Admin\SellerUsersController::class, 'destroyAllSelections'])->name('seller_user.deleteSelections');
        Route::put('/banners/update_banner', [\App\Http\Controllers\Admin\BannerController::class, 'update_banner'])->name('update_banner');
        Route::put('/cities/update_city', [\App\Http\Controllers\Admin\CityController::class, 'update_city'])->name('update_city');
        Route::put('/banners/update_banner_visibility/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'update_banner_visibility'])->name('update_banner_visibility');
        Route::put('/cities/update_city_visibility/{city}', [\App\Http\Controllers\Admin\CityController::class, 'update_city_visibility'])->name('update_city_visibility');
        Route::put('/magaza/update_magaza_visibility/{magaza}', [\App\Http\Controllers\Admin\MagazaController::class, 'update_magaza_visibility'])->name('update_magaza_visibility');
        Route::put('/blog/update_blog_visibility/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update_blog_visibility'])->name('update_blog_visibility');
        Route::put('/vacancy/update_vacancy_visibility/{vacancy}', [\App\Http\Controllers\Admin\VacancyController::class, 'update_vacancy_visibility'])->name('update_vacancy_visibility');
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->except('show', 'edit', 'create', 'update');
        Route::get('cities', [\App\Http\Controllers\Admin\CityController::class, 'FilterCitiesForAdmin'])->name('cities.index');
        Route::resource('cities', \App\Http\Controllers\Admin\CityController::class)->except('index', 'show', 'edit', 'create', 'update');
        Route::resource('clients', \App\Http\Controllers\Admin\UserController::class)->except('show', 'edit', 'create');
        Route::resource('admin_users', \App\Http\Controllers\Admin\AdminUsersController::class)->except('show', 'edit', 'create');
        Route::resource('magazas', \App\Http\Controllers\Admin\MagazaController::class)->except('show');
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->except('show');
        Route::resource('vacancies', \App\Http\Controllers\Admin\VacancyController::class)->except('show');
        Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class)->except('show');
        Route::delete('/categories_destroyAllSelections', [\App\Http\Controllers\Admin\CategoryController::class, 'destroyAllSelections'])->name('category.deleteSelections');
        Route::put('/categories/update_category_visibility/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update_category_visibility'])->name('update_category_visibility');
        
        Route::get('{category_id}/features', [\App\Http\Controllers\Admin\FeatureController::class, 'FilterFeaturesForAdmin'])->name('features.index');
        Route::resource('{category_id}/features', \App\Http\Controllers\Admin\FeatureController::class)->except('index','show');
        Route::delete('/features_destroyAllSelections', [\App\Http\Controllers\Admin\FeatureController::class, 'destroyAllSelections'])->name('features.deleteSelections');
        Route::delete('/features/value/{id}', [\App\Http\Controllers\Admin\FeatureController::class, 'destroyFeatureValue'])->name('features.value.delete');
        Route::put('/features/update_features_visibility/{feature_id}', [\App\Http\Controllers\Admin\FeatureController::class, 'update_features_visibility'])->name('update_features_visibility');
        
        Route::get('/about_us', [\App\Http\Controllers\Admin\AboutUsController::class, 'edit'])->name('about.edit');
        Route::put('/about_us', [\App\Http\Controllers\Admin\AboutUsController::class, 'update'])->name('about.update');
    });
//    Route::delete('/con/delete/{con}', [\App\Http\Controllers\Admin\ContactFormController::class, 'destroy'])->name('con.destroy');
//    Route::delete('/con_destroyAllSelections', [\App\Http\Controllers\Admin\ContactFormController::class, 'destroyAllSelections'])->name('con.deleteSelections');

    Route::group(['middleware' => 'checkRole:seller'], function () {
        Route::resource('seller_users', \App\Http\Controllers\Admin\SellerUsersController::class)->except('show', 'edit', 'create');
        Route::get('/store/logined/{store}', [\App\Http\Controllers\Admin\LoginedStoreController::class, 'edit'])->name('logined.store.edit');
        Route::put('/store/logined/{store}', [\App\Http\Controllers\Admin\LoginedStoreController::class, 'update'])->name('logined.store.update');
    });

    Route::group(['as' => 'admin.'],function (){
        Route::resource('products', ProductController::class);
    });
    Route::get('products/getFeaturesByCategory/{categoryId}',[ProductController::class,'getFeaturesByCategory']);
    Route::put('products/updateVisible/{product}',[ProductController::class,'updateVisible'])->name('admin.product.visible');
    Route::post('/file/{type}', [FileController::class, 'uploadFile'])->name('admin.file.upload');

    // Catalogs
    Route::get('catalogs',[ProductController::class,'catalogs']);
    Route::get('catalogs/{productId}/getVariation',[ProductController::class,'getVariation']);
    Route::post('catalog/clone',[ProductController::class,'copyProduct'])->name('catalog.copy');
});
