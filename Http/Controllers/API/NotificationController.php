<?php

namespace Modules\CoreModule\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CoreModule\Entities\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Traits\ErrorHandlingTraits;
use App\Traits\NotificationTraits;

class NotificationController extends Controller
{
    use ErrorHandlingTraits,NotificationTraits;
    public function createNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'notification_title' => 'required',
            'notification_type' => 'required',
            'contant' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 'false','status'=>$this->getStatusCode(400),'error'=>$validator->errors()], 400);
        }

        $user=User::find($request['user_id']);
        if($user){
            $input = $request->all();

            $notification = Notification::create($input);

            if($notification){
                return response()->json(['notification' => "Notification Created" ]);
            }else{
                return response()->json(['message' => "Fail"]);
            }
        }else{
            return response()->json(['message' => "There Are No User"]);
        }

    }
    public function getUserNotifications($type,$id)
    {
        $user=User::find($id);

        if (!$user) {
            return response()->json(['message' => "There Are No User"]);
        }

        if($type == "all"){
            $notifications=$this->getUserAllNotification($user);

        }else if ($type == "new"){
            $notifications=$this->getUserNewNotification($user);
        }

        return response()->json(['notifications' => $notifications], 200);


    }

    public function getUserAllNotification(User $user)
    {
        return $user->getUserNotifications()->get();
    }

    public function getUserNewNotification(User $user)
    {
        return $user->getUserNotifications()->where("was_readed",0)->get();
    }

    public function notificationRead($id)
    {
        $notification = Notification::find($id);
        if($notification){
            $notification->was_readed = 1;
            $notification->save();
            return response()->json(['success' => 'true','message' => "Notification Readed"]);

        }else{
            return response()->json(['success' => 'false','message' => "There Are No Notification"]);
        }

    }

    public function createFirebaseNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'title'     => 'required',
            'type'      => 'required',
            'body'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 'false','status'=>$this->getStatusCode(400),'error'=>$validator->errors()], 400);
        }

        $userID=$request['user_id'];

        $user=User::find($userID);
        $title=$request['title'];
        $type=$request['type'];
        $body=$request['body'];

        if($user){
            $this->sendNotification($user,'',$title,$body,$type);
            return response()->json(['success' => 'true','message' => "Done"],200);
        }
        return response()->json(['success' => 'false','message' => "User Not Found"],400);

    }
}
