<?php

namespace Modules\CoreModule\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserSingleton
{
    private static  $user;

    private function __construct() {}
    private function __clone() {}


    public static function getUser()
    {
        if(self::$user === null){
            $userID = Auth::id();
            self::$user = User::find($userID);
        }

        return self::$user;
    }
}
