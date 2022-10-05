<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(env('MAIL_TO_ADDRESS_FINANCE'), 'Financeiro')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Nova Ordem de Compra ' . env('APP_NAME'))
            ->markdown('emails.purchase_order', [
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'number_series' => $this->data['number_series'],
                'job' => $this->data['job'],
                'subsidiary' => $this->data['subsidiary'],
            ]);
    }
}
