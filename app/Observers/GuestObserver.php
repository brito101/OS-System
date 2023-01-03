<?php

namespace App\Observers;

use App\Mail\ScheduleMail;
use App\Models\Guest;
use App\Models\Schedule;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class GuestObserver
{
    /**
     * Handle the Guest "created" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function created(Guest $guest)
    {
        $schedule = Schedule::find($guest->schedule_id);
        $receiver = User::find($guest->user_id);
        if ($schedule && $receiver) {
            $data = [
                'to' => $receiver->name,
                'email' => $receiver->email,
                'from' => $schedule->user->email,
                'title' => $schedule->title,
                'description' => $schedule->description,
                'start' => date('d/m/Y H:i', strtotime($schedule->start)),
                'end' => date('d/m/Y H:i', strtotime($schedule->end)),
                'user' => $schedule->user->name,
            ];

            $email = new ScheduleMail($data);
            try {
                Mail::queue($email);
            } catch (Exception $e) {
                return;
            }
        }
    }

    /**
     * Handle the Guest "updated" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function updated(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "deleted" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function deleted(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "restored" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function restored(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "force deleted" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function forceDeleted(Guest $guest)
    {
        //
    }
}
