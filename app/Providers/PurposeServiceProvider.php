<?php

namespace App\Providers;

use App\Repositories\Purpose\PurposeRepository;
use App\Repositories\Purpose\PurposeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PurposeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PurposeRepositoryInterface::class, 
            PurposeRepository::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
