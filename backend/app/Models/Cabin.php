<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cabin extends Model
{
    use HasFactory;

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
