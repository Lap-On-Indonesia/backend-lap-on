<?php

namespace App\Providers;

use Filament\FilamentServiceProvider as BaseFilamentServiceProvider;
use Illuminate\Support\Facades\Gate;

class FilamentServiceProvider extends BaseFilamentServiceProvider
{
    public function boot()
    {
        parent::boot();

        // Register middleware
        $this->app['router']->middlewareGroup('web', [
            \App\Http\Middleware\CheckOwnerMarketplace::class,
        ]);
    }
}
