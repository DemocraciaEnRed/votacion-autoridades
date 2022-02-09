<?php

namespace App\Providers;

use App\Models\Roll;
use App\Models\Vote;
use App\Observers\RollObserver;
use App\Observers\VoteObserver;
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
        Roll::observe(RollObserver::class);
        Vote::observe(VoteObserver::class);
    }
}
