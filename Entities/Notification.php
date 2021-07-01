<?php

namespace Modules\CoreModule\Entities;


use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'notification_title', 'notification_type','contant'
    ];
    

}
