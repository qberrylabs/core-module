<?php

namespace Modules\CoreModule\Entities;


use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'content','name','subject'
    ];
}
