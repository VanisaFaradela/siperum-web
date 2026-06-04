<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cluster;
use App\Models\TipeRumah;

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
        View::composer('layouts.app', function ($view) {
            $tipeRumah = TipeRumah::limit(4)->get();

            $view->with('tipeRumah', $tipeRumah);
        });

        // Share tipeRumah ke semua view (untuk dropdown di navbar)
        View::composer('*', function ($view) {
            $view->with('tipeRumah', TipeRumah::limit(4)->get());
        });
        
        // Share clusters ke semua view (untuk dropdown di navbar)
        View::composer('*', function ($view) {
            $view->with('clusters', Cluster::where('status', 'aktif')->get());
        });
    }
}