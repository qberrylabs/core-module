<?php

namespace Modules\CoreModule\Traits;

use App\Mail\SendConfirmationEmailCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

trait UserTrait {
    public function getUserInfomationByID($userID)
    {
        $user=User::find($userID);
        if ($user) {
            return $user;
        }
    }

    public function sendConfirmationEmailCode($user)
    {
        $code =substr(md5(uniqid(rand(), true)), 0, 6);
        try {
            Mail::to($user->email)->send(new SendConfirmationEmailCodeMail($code));
        } catch (\Throwable $th) {
            return Redirect::back()->withErrors(['an error in sending an email']);
        }
        $user->confirmation_email_code=$code;
        $user->save();
    }
}
