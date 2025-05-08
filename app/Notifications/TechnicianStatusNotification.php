<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TechnicianStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $reason;

    public function __construct($status, $reason = null)
    {
        $this->status = $status;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject('Technician Account Status Update');

        if ($this->status === 'active') {
            $mailMessage->line('Your technician account has been approved!')
                       ->line('You can now login and start accepting jobs.')
                       ->action('Login Now', url('/login'));
        } else {
            $mailMessage->line('Your technician account application has been rejected.')
                       ->line('Reason: ' . ($this->reason ?? 'Did not meet our requirements'));
            
            if ($this->reason === 'documents') {
                $mailMessage->line('You may reapply with corrected documents.');
            }
        }

        return $mailMessage;
    }
}