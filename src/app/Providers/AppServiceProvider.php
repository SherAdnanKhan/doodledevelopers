<?php

namespace App\Providers;

use App\Models\Game;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        }

        Validator::extend('base64pdf', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['pdf'];
            $format = str_replace(
                [
                    'data:application/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }

            $fileBase64 = $explode[1];
            if (base64_decode($fileBase64, true) === false) {
                return false;
            }

            return true;
        });

        Validator::extend('base64kyc', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
            $format = str_replace(
                [
                    'data:',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }

            $fileBase64 = $explode[1];
            if (base64_decode($fileBase64, true) === false) {
                return false;
            }

            return true;
        });

        Validator::extend('base64img', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['image/png', 'image/jpg', 'image/jpeg'];
            $format = str_replace(
                [
                    'data:',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }

            $fileBase64 = $explode[1];
            if (base64_decode($fileBase64, true) === false) {
                return false;
            }

            return true;
        });

        Validator::extend('gamestatus', function ($attribute, $value, $parameters, $validator)
        {
            $statuses = explode(',', $value);
            foreach($statuses as $status)
            {
                if(!in_array($status, array_keys(Game::statuses())))
                {
                    return false;
                }
            }
            return true;
        });

        if(parse_url(env('API_URL'), PHP_URL_SCHEME) === 'https')
        {
            \URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
