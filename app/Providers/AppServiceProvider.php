<?php

namespace App\Providers;

use App\Repository\Auth\LoginRepositoryImpl;
use App\Repository\Contracts\BrandRepository;
use App\Repository\Contracts\CategoryRepository;
use App\Repository\Contracts\LoginRepository;
use App\Repository\Contracts\ProductRepository;
use App\Repository\Product\BrandRepositoryImpl;
use App\Repository\Product\CategoryRepositoryImpl;
use App\Repository\Product\ProductRepositoryImpl;
use App\Services\Auth\LoginServicesImpl;
use App\Services\Contracts\BrandService;
use App\Services\Contracts\CategoryServices;
use App\Services\Contracts\LoginService;
use App\Services\Contracts\ProductServices;
use App\Services\Product\BrandServicesImpl;
use App\Services\Product\CategoryServiceImpl;
use App\Services\Product\ProductServicesImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(LoginService::class,       LoginServicesImpl::class);
         $this->app->bind(LoginRepository::class,    LoginRepositoryImpl::class);
         $this->app->bind(BrandService::class,       BrandServicesImpl::class);
         $this->app->bind(BrandRepository::class ,   BrandRepositoryImpl::class);
         $this->app->bind(CategoryServices::class,   CategoryServiceImpl::class);
         $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
         $this->app->bind(ProductServices::class,    ProductServicesImpl::class);
         $this->app->bind(ProductRepository::class,  ProductRepositoryImpl::class);
        // $config = config('bindings.paths', []);

        // foreach ($config as $file) {
        //     if (!file_exists($file)) continue;

        //     $bindings = require $file;
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
