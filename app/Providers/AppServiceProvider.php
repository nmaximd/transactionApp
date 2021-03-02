<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Models\User;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Validator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Transaction::observe(TransactionObserver::class);

        Validator::extend('afterTodayWithHours', function ($attribute, $value, $parameters, $validator) {
            $requestDateTime = \Carbon\Carbon::parse($value . ' ' . $validator->getData()[$parameters[0]] . ':00');
            return $requestDateTime->isAfter(now());
        });
    }
}
