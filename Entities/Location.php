<?php

namespace Modules\CoreModule\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Location extends Model
{
    protected $fillable = [
        'address_latitude', 'address_longitude','user_id'
    ];

    public function getUserInformationsByLocation()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
