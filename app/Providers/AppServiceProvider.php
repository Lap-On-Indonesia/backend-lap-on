<?php

namespace App\Providers;

use App\Models\Owner;
use App\Observers\OwnerObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\Responses\CustomLoginViewResponse;
use App\Models\OwnerMarketplace;
use App\Observers\OwnerMarketplaceObserver;
use Laravel\Fortify\Contracts\LoginViewResponse;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LoginViewResponse::class);
    }

    public function boot()
    {
        Owner::observe(OwnerObserver::class);
        OwnerMarketplace::observe(OwnerMarketplaceObserver::class);
    }
}
