<?php

namespace App\Http\Controllers\Backend;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Backend\Notification;

class NotificationController extends Controller{
    public function index(){
        $notificationData = [
            'email' => 'anil.digitaldesign@gmail.com',
            'message' => 'This is a test notification',
            'text' => 'This is a test notification from event listener',
            'for' => Auth::user()->id,
            'by' => Auth::user()->id,
            'icon' => '<i class="ri-eject-fill"></i>',
            'url' => '#',
            'status' => 1
        ];
        event(new NotificationEvent($notificationData));
        return response()->json(['status' => 'Notification triggered']);
    }
    public function viewNotification($id){
        $decrypt_id = $id;
        $notification = Notification::where('id', $decrypt_id)->first();
        Notification::where('id', $decrypt_id)->update([
            'status' => 2
        ]);
        return redirect($notification->url);
    }
}
