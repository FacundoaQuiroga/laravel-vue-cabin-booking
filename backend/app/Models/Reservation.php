<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'guest_name',
        'guest_email',
        'guest_phone',
        'cabin_name',
        'check_in',
        'check_out',
        'guests',
        'status',
        'notes',
    ];
}
