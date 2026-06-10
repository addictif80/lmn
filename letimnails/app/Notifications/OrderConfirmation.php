<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $name = $notifiable->name ?? ($this->order->shipping_address['first_name'] ?? 'Client');

        return (new MailMessage)
            ->subject('Confirmation de commande #' . $this->order->order_number)
            ->greeting('Bonjour ' . $name)
            ->line('Votre commande #' . $this->order->order_number . ' a bien été confirmée.')
            ->line('Montant total : ' . number_format($this->order->total, 2) . ' €')
            ->line('Merci de votre confiance !');
    }
}
