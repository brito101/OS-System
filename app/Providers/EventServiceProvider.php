<?php

namespace App\Providers;

use App\Models\Guest;
use App\Models\PurchaseOrder;
use App\Models\ServiceOrder;
use App\Observers\GuestObserver;
use App\Observers\PurchaseOrderObserver;
use App\Observers\ServiceOrderObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        PurchaseOrder::observe(PurchaseOrderObserver::class);
        ServiceOrder::observe(ServiceOrderObserver::class);
        Guest::observe(GuestObserver::class);
    }
}
