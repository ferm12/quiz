<?php

namespace App\Providers;

// use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    // by kuang
    // protected $listen = [
    //     'App\Events\SomeEvent' => [
    //         'App\Listeners\EventListener',
    //     ],
    // ];

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];
    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    // public function boot(DispatcherContract $events)
    public function boot()
    {
        // parent::boot($events);
        parent::boot();

        //
    }
}
