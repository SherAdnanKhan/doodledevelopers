<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PaymentGateways\PaymentRepositoryInterface',
            'App\Repositories\PaymentGateways\Zing\ZingRepository'
        );

        $this->app->bind(
            'App\Repositories\Compressions\Images\ImageRepositoryInterface',
            'App\Repositories\Compressions\Images\SpatieImageRepository'
        );
    }
}
