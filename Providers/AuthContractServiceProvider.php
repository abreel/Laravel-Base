<?php

namespace App\Base\Providers;

use App\Base\Contracts\CheckAuth;
use App\Base\Contracts\AuthContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthContractServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $singletons = [
        AuthContract::class => CheckAuth::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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

    public function provides()
    {
        return [AuthContract::class];
    }
}
