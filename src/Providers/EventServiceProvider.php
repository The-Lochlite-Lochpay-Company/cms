<?php

namespace lochlite\cms\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use lochlite\cms\Events\Update;
use lochlite\cms\Listeners\UpdateListeners;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Update::class => [
            UpdateListeners::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
