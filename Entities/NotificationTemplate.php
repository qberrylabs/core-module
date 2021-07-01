<?php

namespace Modules\CoreModule\Entities;


use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = [
        'user_id', 'notification_title', 'notification_type','contant','type'
    ];
}
