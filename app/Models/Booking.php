<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $timestamps = false;

    protected $table = 'booking';

    protected $fillable = [
        'id_time',
        'id_place',
        'booking_time',
        'user',
        'email',
        'phone',
    ];
}
