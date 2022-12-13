<?php

namespace App\Observers;

use App\Models\ServiceOrder;
use App\Models\User;
use App\Notifications\ServiceOrderWhatsAppProcessed;

class ServiceOrderObserver
{
    /**
     * Handle the ServiceOrder "created" event.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return void
     */
    public function created(ServiceOrder $serviceOrder)
    {
        $participant = User::find($serviceOrder->user_id);
        // if ($participant->cell) {
        //     $participant->notify(new ServiceOrderWhatsAppProcessed($serviceOrder));
        // }
    }

    /**
     * Handle the ServiceOrder "updated" event.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return void
     */
    public function updated(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Handle the ServiceOrder "deleted" event.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return void
     */
    public function deleted(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Handle the ServiceOrder "restored" event.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return void
     */
    public function restored(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Handle the ServiceOrder "force deleted" event.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return void
     */
    public function forceDeleted(ServiceOrder $serviceOrder)
    {
        //
    }
}
