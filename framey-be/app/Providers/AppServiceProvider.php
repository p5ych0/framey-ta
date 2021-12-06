<?php

namespace App\Providers;

use App\Services\EmployeeService;
use App\Validation\Rules\DifferentPosition;
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
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EmployeeService::class, EmployeeService::class);
        $this->app->bind('differentPosition', DifferentPosition::class);
    }
}
