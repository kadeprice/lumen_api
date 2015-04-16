<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() 
    {
        if (App::environment() == 'local') {
            App::register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
