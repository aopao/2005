<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CollegeRepository::class, \App\Repositories\CollegeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CollegeCategoryRepository::class, \App\Repositories\CollegeCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProvinceRepository::class, \App\Repositories\ProvinceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CollegeDiplomasRepository::class, \App\Repositories\CollegeDiplomasRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MajorRepository::class, \App\Repositories\MajorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProvinceControlScoreRepository::class, \App\Repositories\ProvinceControlScoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SerialNumberRepository::class, \App\Repositories\SerialNumberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VipCardRepository::class, \App\Repositories\VipCardRepositoryEloquent::class);
    }
}
