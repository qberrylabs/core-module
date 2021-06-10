<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use ClearsResponseCache;
    protected $fillable = [
        'user_id', 'notification_title', 'notification_type','contant'
    ];

}
