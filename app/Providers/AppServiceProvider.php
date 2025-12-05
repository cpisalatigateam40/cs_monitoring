<?php

namespace App\Providers;

use App\Models\Plant;
use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function ($view) {
            $plants = collect();

            if (Auth::check()) {
                // Lazy-load to avoid "Class not found"
                $plants = function () {
                    return \App\Models\User::find(auth()->id())->accessiblePlants();
                };
            }

            $view->with('plants', $plants);
        });
    }
}
