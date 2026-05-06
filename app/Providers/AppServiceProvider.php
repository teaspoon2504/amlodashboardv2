<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

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
        Blade::directive('alpinejs', function () {
            $manifest = File::get(public_path('build/manifest.json'));
            $data = json_decode($manifest, true);
            $js = $data['assets']['app.js'] ?? null;
            if ($js) {
                return '<script src="/build/'.$js.'"></script>';
            }
            return '';
        });
    }
}
