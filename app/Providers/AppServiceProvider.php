<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(\App\Repositories\IRecordRepository::class, \App\Repositories\RecordRepository::class);
        $this->app->bind(\App\Repositories\IBaseRepository::class, \App\Repositories\BaseRepository::class);
        $this->app->bind(\App\Repositories\IHymnRepository::class, \App\Repositories\HymnRepository::class);
    }

    public function bindInterfaces()
    {


    }
}
