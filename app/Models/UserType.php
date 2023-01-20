<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;

    protected $table = 'user_type';

    protected $fillable = [
        'id_user',
        'id_type',
    ];
}
