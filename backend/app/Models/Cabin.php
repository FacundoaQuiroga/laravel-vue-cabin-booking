<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Cabin extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'description',
        'status',
    ];
    
    public function reservations()  {
        return $this->hasMany(Reservation::class);
    }

}
