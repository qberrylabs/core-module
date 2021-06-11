<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use ClearsResponseCache;
}
