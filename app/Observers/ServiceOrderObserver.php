<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Guest;
use App\Models\Schedule;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Notifications\ServiceOrderWhatsAppProcessed;
use Carbon\Carbon;

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

        $data = [
            'title' => Activity::find($serviceOrder->activity_id)->name,
            'description' => $serviceOrder->description,
            'start' => Carbon::createFromFormat('d/m/Y', $serviceOrder->execution_date)->format('Y-m-d'),
            'end' =>  Carbon::createFromFormat('d/m/Y', $serviceOrder->deadline)->format('Y-m-d 23:59'),
            'user_id' => $serviceOrder->author->id,
        ];

        $schedule = Schedule::create($data);

        if ($schedule->save()) {
            Guest::create([
                'schedule_id' => $schedule->id,
                'user_id' => $participant->id
            ]);
        }

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
