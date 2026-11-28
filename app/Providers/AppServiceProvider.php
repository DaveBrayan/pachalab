<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        $cmsFile = storage_path('cms/pachalab_content.json');
        $cms = [];
        if (file_exists($cmsFile)) {
            $cms = json_decode(file_get_contents($cmsFile), true) ?: [];
        }
        View::share('cms', $cms);
    }
}
