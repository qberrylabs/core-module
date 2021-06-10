<?php

namespace Modules\CoreModule\Http\Controllers\Wallet;

use Modules\CoreModule\Http\Controllers\User\UserSingleton;

class WalletSingleton
{
    public static $userWallet;
    private function __construct() {}
    private function __clone() {}

    public static function getUserWallet()
    {

        if(self::$userWallet === null){

            $user=UserSingleton::getUser();
        
            self::$userWallet = $user->getUserWallets->first();

        }
        return self::$userWallet;
    }
}
