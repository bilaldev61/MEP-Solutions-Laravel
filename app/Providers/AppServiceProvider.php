<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the live site name (for the wordmark) with the layouts, plus a
        // FIXED "BR" logo mark. The mark stays "BR" regardless of the site name.
        View::composer(['layouts.admin', 'layouts.guest', 'layouts.website'], function ($view) {
            $name = SiteSetting::where('key', 'site_name')->value('value') ?: config('app.name', 'MEP Solutions');

            $view->with('brandName', $name)
                ->with('brandInitials', 'BR');
        });
    }
}
