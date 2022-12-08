<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleMail extends Mailable
{
    private $data;

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
            ->cc($this->data['email'], $this->data['to'])
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Novo Evento na Agenda - ' . env('APP_NAME'))
            ->markdown('emails.schedule', [
                'title' => $this->data['title'],
                'description' => $this->data['description'],
                'start' => $this->data['start'],
                'end' => $this->data['end'],
                'user' => $this->data['user']
            ]);
    }
}
