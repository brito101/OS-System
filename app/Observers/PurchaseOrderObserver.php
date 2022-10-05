<?php

namespace App\Observers;

use App\Mail\PurchaseOrderMail;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderObserver
{
    /**
     * Handle the PurchaseOrder "created" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function created(PurchaseOrder $purchaseOrder)
    {
        $data = [
            'name' => $purchaseOrder->user->name,
            'email' => $purchaseOrder->user->email,
            'number_series' => $purchaseOrder->number_series,
            'job' => $purchaseOrder->job,
            'subsidiary' => $purchaseOrder->subsidiary
        ];

        $email = new PurchaseOrderMail($data);
        Mail::send($email);
    }

    /**
     * Handle the PurchaseOrder "updated" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function updated(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "deleted" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function deleted(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "restored" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function restored(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "force deleted" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function forceDeleted(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
