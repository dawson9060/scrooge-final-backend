<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'name',
        'date',
        'user_id',
    ];

    protected $casts = [];
}