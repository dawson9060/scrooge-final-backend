<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueExpense extends Model
{
    protected $fillable = [
        'name',
        'date',
        'amount',
        'type',
        'user_id',
    ];

    protected $casts = [
    ];
}