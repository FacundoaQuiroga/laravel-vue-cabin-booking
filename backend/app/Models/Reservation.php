<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cabin;

class Reservation extends Model
{
    protected $fillable = [
        'guest_name',
        'guest_email',
        'guest_phone',
        'cabin_id',
        'check_in',
        'check_out',
        'guests',
        'status',
        'notes',
    ];

    public function cabin() {
        return $this->belongsTo(Cabin::class);
    }
}
