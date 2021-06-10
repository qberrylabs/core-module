<?php

namespace Modules\CoreModule\Traits;

use Illuminate\Http\Request;

use Modules\CoreModule\Entities\Notification;

trait NotificationTraits {

    public function sendNotificationToTokens($token,$title,$body,$type)
    {
        $firebaseToken = $token;
        $SERVER_API_KEY = 'AAAAjYYkNjo:APA91bH5hFC9KqP37q-8DepAxc0U9inBPjrU_aeoa5mFxGnm3rbohc15jJNdLDLpds2PBGJOEPurs0knmHDQlOrhwa_isfq6pYiUyJ-Aod84ct8XZBhfxdJf4RAeLWVR89Ubf1Km4seV';
        //$SERVER_API_KEY = 'AAAAXF-71xs:APA91bH1ZH77AZiXqD5yiMqtCr6X9yv8d5zg_6CVIxRfIT-IUJ2S8fXtqhefpkIyfZ0emVvHVZZ_IPMF8fxl0JRMddK11I-4I5PJQt7yLSJdjFmXe0ItwsxJ6JiYWhoTDH1-el5n2zni';

        $data = [
            "registration_ids" =>array( $firebaseToken),
            "notification" => [
                "title" => $title,
                "body" => $body,
                "type" =>$type
            ]
        ];
        $dataString = json_encode($data);
        //dd($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function sendNotification($user,$title,$body,$type)
    {
        $notification=new Notification();
        $notification->user_id=$user->id;
        $notification->notification_type=$type;
        $notification->notification_title=$title;
        $notification->contant=$body;
        $notification->save();

        $userTokens=$user->getUserDeviceTokens()->get();

        foreach ($userTokens as $userToken) {

           $this->sendNotificationToTokens($userToken->device_token,$title,$body,$type);
        }
    }


}
