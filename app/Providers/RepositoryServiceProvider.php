<?php

namespace App\Providers;

use App\Repositories\Interfaces\LastTransactionsRepositoryInterface;
use App\Repositories\LastTransactionsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LastTransactionsRepositoryInterface::class,
            LastTransactionsRepository::class
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
