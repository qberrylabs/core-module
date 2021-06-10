<?php

namespace Modules\CoreModule\Traits;

use Illuminate\Http\Request;

use App\Models\User;
use Modules\CoreModule\Entities\Wallet;

trait WalletTrait {
    public function getUserInformationByWallet($walletID)
    {

        $wallet=Wallet::find($walletID)->getUserInformations;
        if ($wallet) {
            return $wallet;
        }
        return "unknow user";

    }
    public function addCredit($wallet,$amount)
    {
        $wallet->balance += $amount;
        $wallet->save();
    }

    public function moneyTransfer($fromWallet,$toWallet,$requiredAmount,$receivedAmount)
    {
        $fromWallet->balance -= $requiredAmount;
        $fromWallet->save();

        $toWallet->balance += $receivedAmount;
        $toWallet->save();
    }
    public function getWalletByUserID($userID)
    {
        $user=User::find($userID);
        return $user->getUserWallets->first();
    }

    public function CreateWallet($user,$currency)
    {

        $wallet = new Wallet();
        $wallet->name="Main Wallet";
        $wallet->currency=$currency;
        $wallet->user_id=$user->id;
        $wallet->save();
    }
}
