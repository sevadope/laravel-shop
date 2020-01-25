<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CartManagerInterface;
use App\Managers\Cart\RedisCartManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartManagerInterface::class, RedisCartManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
