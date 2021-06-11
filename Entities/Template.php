<?php

namespace Modules\CoreModule\Entities;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use ClearsResponseCache;
    protected $fillable = [
        'content','name','subject'
    ];
}
