<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {                   // request this name who service container
        $this->app->bind('cart.cookie_id',function(){
        $cookie_id = Cookie::get('cart_id');
        if( ! $cookie_id)
        {
            $cookie_id = Str::uuid();              
            Cookie::queue('cart_id', $cookie_id , 24 *60 *30);
        }
        return $cookie_id ; 
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        // Paginator::useBootstrap();
        Paginator::defaultView('pagination.store');
    }
}
