<?php

namespace Modules\CoreModule\Enum;

use Modules\CoreModule\Entities\DepositFee;
use Modules\CoreModule\Entities\Fee;
use Modules\CoreModule\Entities\WithdrawFee;

class FeeTypesEnum
{
    const DEPOSIT       = "deposit";
    const WITHDRAW      = "withdraw";
    const FEE           = "fee";

    public static function getAllFees()
    {
        return [
            self::DEPOSIT       => new DepositFee(),
            self::WITHDRAW      => new WithdrawFee(),
            self::FEE           => new Fee(),
        ];
    }

    public function getFeeClass($type)
    {
        $feesTypes=$this->getAllFees();
        if (array_key_exists($type , $feesTypes)){
            return $feesTypes[$type];
        }

        return null;
    }
}
