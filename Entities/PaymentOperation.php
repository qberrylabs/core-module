<?php

namespace Modules\CoreModule\Entities;


use Illuminate\Database\Eloquent\Model;

class PaymentOperation extends Model
{
    protected $fillable = [
        'from_wallet_id', 'to_wallet_id', 'transaction_amount', 'currency','uuid_code','payment_operation_date'
    ];
}
