<?php

namespace App\Notifications;

use App\Models\MaintenanceTicket;
use App\Models\User;
use Filament\Notifications\Notification as NotificationFilament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CostMaintenance extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private MaintenanceTicket $maintenance) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(User $notifiable): array
    {
        $message = "Hola $notifiable->name, el costo del mantenimiento del equipo {$this->maintenance->device->model} es de {$this->maintenance->parts_cost}$. Ahora debes aprobar o desaprobar el mantenimiento.";

        return NotificationFilament::make()
            ->title('Aprobación de mantenimiento pendiente.')
            ->body($message)
            ->success()
            ->getDatabaseMessage();
    }
}
