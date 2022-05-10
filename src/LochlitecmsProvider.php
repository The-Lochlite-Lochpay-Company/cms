<?php

namespace lochlite\cms;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use lochlite\cms\Providers\EventServiceProvider;
use lochlite\cms\Jobs\UpdateJob;

class LochlitecmsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('lochlitecms', function($app) {
            return new Lochlitecms();
        });
        $this->app->register(EventServiceProvider::class);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->job(new UpdateJob('2.0.5'))->daily();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    $this->loadMigrationsFrom(__DIR__ . './migrations');
    }
}
