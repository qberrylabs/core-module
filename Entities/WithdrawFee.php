<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;


class WithdrawFee extends Model
{
    use ClearsResponseCache;
    protected $guarded = [];
}
