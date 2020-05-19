<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RoomStatus extends Notification
{
    use Queueable;

    public $form;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail', 'database'];

        if($notifiable->user_id == 'admin') {
            array_splice($channels, 0, 1);
        }
        elseif($this->form->isApproved == 0) {
            array_splice($channels, 1, 1);
        }

        return $channels;
    }

    /**
    * Get the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable)
    {
        $closingRemarks = 'Please do not hesitate to send an e-mail to academics@iacademy.edu.ph for concerns.';
        $viewUrl = url('/history');

        if($this->form->isCancelled) {
            $headerStatus = 'Reservation Cancelled';
            $info = 'We regret to inform you that your reservation for Room '.$this->form->room_id.' ('.Carbon::parse($this->form->stime_res)->format('M d, Y h:i A').
            ' - '.Carbon::parse($this->form->etime_res)->format('M d, Y h:i A').') has been cancelled. Reason: '.$this->form->reasonCancelled;
        }
        elseif($this->form->isApproved == 1) {
            $headerStatus = 'Reservation Approved';
            $info = 'Congratulations! Your reservation for Room '.$this->form->room_id.' ('.Carbon::parse($this->form->stime_res)->format('M d, Y h:i A').
            ' - '.Carbon::parse($this->form->etime_res)->format('M d, Y h:i A').') has been approved. 
            Please make sure to adhere to the room usage guidelines to avoid sanctions.';
        }
        elseif($this->form->isApproved == 2) {
            $headerStatus = 'Reservation Rejected';
            $info = 'We regret to inform you that your reservation for Room '.$this->form->room_id.' ('.Carbon::parse($this->form->stime_res)->format('M d, Y h:i A').
            ' - '.Carbon::parse($this->form->etime_res)->format('M d, Y h:i A').') has been rejected.';
        }
        else {
            $headerStatus = 'Request Received';
            $info = 'Your reservation for Room '.$this->form->room_id.' ('.Carbon::parse($this->form->stime_res)->format('M d, Y h:i A').
            ' - '.Carbon::parse($this->form->etime_res)->format('M d, Y h:i A').') has been received. Since this room requires admin approval, 
            please expect a status update within 24-48 hours.';
        }
        
        return (new MailMessage)
                    ->subject($headerStatus)
                    ->greeting($headerStatus)
                    ->line($info)
                    ->action('View Reservation', $viewUrl)
                    ->line($closingRemarks);
     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'form_id' => $this->form->form_id,
            'user_id' => $this->form->user_id,
            'read_at' => $this->form->read_at,
            'status' => $this->form->isApproved,
            'cancel_status' => $this->form->isCancelled,
        ];
    }
}
