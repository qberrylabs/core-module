<?php

namespace Modules\CoreModule\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CoreModule\Entities\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function getUserWallets()
    {
        $userID = Auth::id();

        $wallets = User::find($userID)->getUserWallets;

        return response()->json(['wallets' => $wallets], 200);
    }

    public function getWallet($id)
    {
        $user=User::find($id);
        if (!$user) {
            return response()->json(['message' => "There Are No User"]);
        }

        $wallet=$user->getUserWallets->first();
        if (!$wallet) {
            return response()->json(['message' => "There Are No Wallet"]);
        }

        return response()->json(['wallets' => $wallet], 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | string',
            'currency' => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $wallet = new Wallet();
        $wallet->name = $request['name'];
        $wallet->currency = $request['currency'];
        $wallet->user_id = Auth::id();
        $wallet->save();

        return response()->json(['message' => 'Wallet Successfully Created'], 200);
    }
}
