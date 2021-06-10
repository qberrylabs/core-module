<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use ClearsResponseCache;
}
