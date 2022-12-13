<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;
use App\Models\ServiceOrder;

class ServiceOrderWhatsAppProcessed extends Notification
{
    use Queueable;


    public $order;

    public function __construct(ServiceOrder $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $message = "GABControl API";
        $orderUrl = url("/admin/service-orders/{$this->order->id}");
        $text = ": - Nova OS para a sua execução criada pelo {$this->order->author->name}. Serviço:  {$this->order->activity->name} - Prioridade: {$this->order->priority} - Cliente: {$this->order->client->name} - Prazo: {$this->order->deadline}. Detalhes: {$orderUrl}";

        return (new WhatsAppMessage)->content("Your $message code is $text");
    }
}
