<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    public $timestamps = false;

    protected $table = 'timetable';

    protected $fillable = [
        'day',
        'id_place',
        'slot_duration',
        'max_user',
        'start_time',
        'end_time',
    ];
}
