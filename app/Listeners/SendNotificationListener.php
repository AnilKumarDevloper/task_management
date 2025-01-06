<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\Mail\NotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Models\Backend\Notification;

class SendNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct(){
        //
    }

    /**
     * Handle the event.
     */

    public function handle(NotificationEvent $notificationEvent): void{
        $notificationData = $notificationEvent->notificationData;
        Notification::create([
            "text" => $notificationData['text'],
            "for" => $notificationData['for'],
            "by" => $notificationData['by'],
            "url" => $notificationData['url'],
            "icon" => $notificationData['icon'],
            "status" => $notificationData['status']
        ]);
        // Mail::to($notificationData['email'])
        // ->send(new NotificationMail($notificationData));
    }
}
