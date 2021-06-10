<?php

namespace Modules\CoreModule\Traits;

use Modules\CoreModule\Http\Controllers\User\UserSingleton;

use Modules\PaymentMethodeModule\Entities\PaymentMethod;

trait PaymentMethodTrait {

    public function getUserPaymentMethod()
    {

        $user=UserSingleton::getUser();
        $paymentMethods=PaymentMethod::where('country',$user->country)->get();
        return $paymentMethods;
    }
}
