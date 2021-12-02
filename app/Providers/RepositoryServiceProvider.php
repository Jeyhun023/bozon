<?php

namespace App\Providers;

use App\Repositories\V1\Cart\OrderRepository;
use App\Repositories\V1\Contracts\AddressRepositoryInterface;
use App\Repositories\V1\Contracts\AdminCategoryRepositoryInterface;
use App\Repositories\V1\Contracts\AdminUserRepositoryInterface;
use App\Repositories\V1\Contracts\AppealsRepositoryInterface;
use App\Repositories\V1\Contracts\AttributeRepositoryInterface;
use App\Repositories\V1\Contracts\AuthRepositoryInterface;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use App\Repositories\V1\Contracts\BlogRepositoryInterface;
use App\Repositories\V1\Contracts\BrandRepositoryInterface;
use App\Repositories\V1\Contracts\CartRepositoryInterface;
use App\Repositories\V1\Contracts\CategoryRepositoryInterface;
use App\Repositories\V1\Contracts\CityRepositoryInterface;
use App\Repositories\V1\Contracts\ColorRepositoryInterface;
use App\Repositories\V1\Contracts\FileRepositoryInterface;
use App\Repositories\V1\Contracts\FeatureRepositoryInterface;
use App\Repositories\V1\Contracts\OrderRepositoryInterface;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Repositories\V1\Contracts\MagazaUserRepositoryInterface;
use App\Repositories\V1\Contracts\ProductRepositoryInterface;
use App\Repositories\V1\Contracts\RatingRepositoryInterface;
use App\Repositories\V1\Contracts\SellerUserRepositoryInterface;
use App\Repositories\V1\Contracts\StoreRepositoryInterface;
use App\Repositories\V1\Contracts\UserRepositoryInterface;
use App\Repositories\V1\Contracts\VacancyRepositoryInterface;
use App\Repositories\V1\Contracts\WishlistRepositoryInterface;
use App\Repositories\V1\Others\AppealsRepository;
use App\Repositories\V1\Others\BlogRepository;
use App\Repositories\V1\Others\ContactFormRepository;
use App\Repositories\V1\Others\FileRepository;
use App\Repositories\V1\Others\VacancyRepository;
use App\Repositories\V1\Product\AttributeRepository;
use App\Repositories\V1\Product\BannerRepository;
use App\Repositories\V1\Cart\CartRepository;
use App\Repositories\V1\Cart\CartRepositoryOld;
use App\Repositories\V1\Product\BrandRepository;
use App\Repositories\V1\Product\CategoryRepository;
use App\Repositories\V1\Product\ColorRepository;
use App\Repositories\V1\Product\ProductRepository;
use App\Repositories\V1\Product\RatingRepository;
use App\Repositories\V1\User\AddressRepository;
use App\Repositories\V1\User\AdminUserRepository;
use App\Repositories\V1\User\AuthRepository;
use App\Repositories\V1\User\CityRepository;
use App\Repositories\V1\User\MagazaUserRepository;
use App\Repositories\V1\User\SellerUserRepository;
use App\Repositories\V1\User\StoreRepository;
use App\Repositories\V1\User\UserRepository;
use App\Repositories\V1\User\WishlistRepository;
use App\Repositories\V1\User\FeatureRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->singleton(AdminUserRepositoryInterface::class, AdminUserRepository::class);
        $this->app->singleton(MagazaUserRepositoryInterface::class, MagazaUserRepository::class);
        $this->app->singleton(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->singleton(VacancyRepositoryInterface::class, VacancyRepository::class);
        $this->app->singleton(ContactFormRepositoryInterface::class, ContactFormRepository::class);
        $this->app->singleton(AppealsRepositoryInterface::class, AppealsRepository::class);
        $this->app->singleton(SellerUserRepositoryInterface::class, SellerUserRepository::class);
        $this->app->singleton(AdminCategoryRepositoryInterface::class, \App\Repositories\V1\Others\CategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(ColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(WishlistRepositoryInterface::class, WishlistRepository::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(OrderRepositoryInterface::class,OrderRepository::class);
        $this->app->bind(BrandRepositoryInterface::class,BrandRepository::class);
        $this->app->bind(AttributeRepositoryInterface::class,AttributeRepository::class);
        $this->app->bind(FileRepositoryInterface::class,FileRepository::class);
        $this->app->bind(FeatureRepositoryInterface::class,FeatureRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
