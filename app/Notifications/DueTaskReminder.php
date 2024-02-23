<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueTaskReminder extends Notification
{
    use Queueable;

    protected $task;
    protected $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct($task, $daysLeft)
    {
        $this->task = $task;
        $this->daysLeft = $daysLeft;
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
    public function toMail($task, $daysLeft): MailMessage
    {
        return (new MailMessage)
            ->line('Task due date is approaching for your tasks. Please check.');
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
