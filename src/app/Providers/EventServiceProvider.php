<?php

namespace App\Providers;
use App\Listeners\CarEventListener;
use App\Events\CarEvent;
use App\Listeners\StationEventListener;
use App\Events\StationEvent;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CarEvent' => [
            'App\Listeners\CarEventListener',
        ],
        'App\Events\StationEvent' => [
            'App\Listeners\StationEventListener',
        ],
        'App\Events\BillEvent' => [
            'App\Listeners\BillEventListener',
        ],
        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\QueryListener',
        ],
    ];
}
