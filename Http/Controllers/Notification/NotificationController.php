<?php

namespace Modules\CoreModule\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Modules\CoreModule\Http\Controllers\User\UserSingleton;
use Modules\CoreModule\Entities\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user=UserSingleton::getUser();
        $notifications=Notification::where('user_id',$user->id)->where('was_readed',0)->orderBy('id','DESC')->get();
        return view('notification.index',['notifications' => $notifications]);

    }

    public function readNotification(Request $request)
    {
        $notificationID=$request['id'];
        $notification=Notification::find($notificationID);
        if ($notification) {
            $notification->was_readed=1;
            $notification->save();
        }

    }
}
