<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountDeactivatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
                    ->subject('Account Deactivated')
                    ->greeting(__('Hello :name ,', ['name' => $notifiable->username]))
                    ->line('You are receiving this email because you account was deactivated.')
                    ->line(__('If no action is taken you account will be deactivated for 7 days.'))
                    ->line('If you think this was a mistake, please contact the system admin.')
                    ->salutation(new HtmlString("Regards<br>Prakhar Gyawali<br>(Principal Admin)"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
