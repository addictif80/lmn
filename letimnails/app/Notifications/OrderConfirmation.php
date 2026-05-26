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
        return (new MailMessage)
            ->subject('Confirmation de commande #' . $this->order->order_number)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre commande #' . $this->order->order_number . ' a bien été confirmée.')
            ->line('Montant total : ' . number_format($this->order->total, 2) . ' €')
            ->action('Voir ma commande', route('account.order.detail', $this->order->order_number))
            ->line('Merci de votre confiance !');
    }
}
