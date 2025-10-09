<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    protected $fillable = [
        'name',
        'day_of_month',
        'amount',
        'type',
        'user_id',
    ];

    protected $casts = [
        'day_of_month' => 'integer',
    ];
}