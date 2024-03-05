<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('path.public',function(){
        //     return base_path().'/public_html';
        // });
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //descomentar esta linea para produccion
        // $this->app->bind('path.public', function() {
        //     return base_path().'/../../public_html/madepa';

        // });

     }
}
