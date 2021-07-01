<?php

namespace Modules\CoreModule\Entities;
use Modules\TransactionModule\Entities\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'name', 'currency'
    ];

    public function getWalletTransactions()
    {
        return $this->hasMany(Transaction::class,'from_wallet_id');
    }

    public function getUserInformations()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userWallet()
    {
        return $this->belongsTo(User::class);
    }

    
}
