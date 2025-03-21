<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/orders/' . $this->order->id);

        return (new MailMessage)
            ->subject('Nouvelle commande #' . $this->order->id)
            ->greeting('Bonjour!')
            ->line('Une nouvelle commande a été passée.')
            ->line('Client: ' . $this->order->user->name)
            ->line('Montant: ' . number_format($this->order->total_amount, 2) . ' €')
            ->action('Voir les détails', $url)
            ->line('Merci de traiter cette commande rapidement!');
    }
}
