<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendApplication extends Notification
{
    use Queueable;

    protected $apply_user;
    protected $work;

    /**
     * Create a new notification instance.
     * 
     * @param App\User $apply_user
     * @param App\Work $work
     *
     * @return void
     */
    public function __construct($apply_user, $work)
    {
        $this->apply_user = $apply_user;
        $this->work = $work;
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
        return (new MailMessage)
            ->subject(__('Your Work Applied'))
            ->line($this->apply_user->name.__(' applied your work'))
            ->line('案件 : '.$this->work->title)
            ->action(__('Message Applying User'), route('message.show',['message_type'=>'direct','w' => $this->work->id,'u' => $this->apply_user->id]));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
