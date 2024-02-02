<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Subcategory;


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
        Schema::defaultStringLength(191);

            // Retrieve subcategories
            $subcategories = Subcategory::all(); // Adjust this based on your actual subcategory retrieval logic
    
            // Share subcategories with all views
            view()->share('subcategories', $subcategories);



    }
}
