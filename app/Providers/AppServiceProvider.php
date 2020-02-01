<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Cache\CacheManager;
use App\Cache\RedisStore;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CacheManager::class, function ($app) {
            return new CacheManager($app);
        });

        $this->app->bind(Cart::class, function ($app) {
            return new Cart($app->make(CacheManager::class), $app->make('auth')->id());
        });
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Repository::class, Cart::class];
    }
}
