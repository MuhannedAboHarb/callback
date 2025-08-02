<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\DatabaseRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use PayPalHttp\Environment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {                   // request this name who service container
        $this->app->bind('cart.cookie_id',function($app){
        $cookie_id = Cookie::get('cart_id');
        if( ! $cookie_id)
        {
            $cookie_id = Str::uuid();              
            Cookie::queue('cart_id', $cookie_id , 24 *60 *30);
        }
        return $cookie_id ; 
        });

        $this->app->bind(CartRepository::class, function($app){
            return new DatabaseRepository($app->make('cart.cookie_id'));
        });
        
        $this->app->singleton('paypal.client', function ($app) {
            $clientId = config('services.paypal.client_id');
            $clientSecret = config('services.paypal.client_secret');

            if (config('services.paypal.env') == 'sandbox') {
                $environment = new SandboxEnvironment($clientId, $clientSecret);
            } else {
                $environment = new Environment($clientId, $clientSecret);
            }

            $client = new PayPalHttpClient($environment);
            return $client;
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
