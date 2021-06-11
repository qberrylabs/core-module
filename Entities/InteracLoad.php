<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class InteracLoad extends Model
{
    use ClearsResponseCache;
    // protected $fillable = [
    //     'name','email_name', 'reference_number','amount_paid','currency','is_available','user_id','note'
    // ];

    protected $guarded = [];

    

}
