<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginViewResponse;
use App\Http\Responses\CustomLoginViewResponse;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LoginViewResponse::class, CustomLoginViewResponse::class);
    }

    public function boot()
    {
        //
    }
}

