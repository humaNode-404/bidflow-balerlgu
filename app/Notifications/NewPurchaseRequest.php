<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewPurchaseRequest extends Notification
{
    use Queueable;

    public $prdoc;

    /**
     * Create a new notification instance.
     */
    public function __construct($prdoc)
    {
        $this->prdoc = $prdoc;
        $this->afterCommit();

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $creator = Auth::user();
        $user = $this->prdoc->user;

        return [
            'title' => 'New PR Created',
            'subtitle' => $user->name . ' from ' . $user->office->abbr . ', the request of purchase has been created.',
            'avatar' => $user->only(['id', 'name_initial', 'avatar']),
            'action' => route('pr', ['number' => $this->prdoc->number]),
        ];
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
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return 'new-pr';
    }

    /**
     * Get the initial value for the "read_at" column.
     */
    public function initialDatabaseReadAtValue()
    {
        return null;
    }
}
