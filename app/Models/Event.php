<?php

namespace App\Models;

use App\EventStatus;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_owner',
        'event_taker',
        'event_start',
        'event_end',
        'num_pets',
        'num_days',
        'num_credits',
        'is_active',
        'is_settled',
        'description',
        'city',
        'state',
        'zip',
    ];

    public function pets()
    {
        return $this->belongsToMany(Pet::class);
    }

    protected $casts = [
        'status' => EventStatus::class,
        'is_active' => 'boolean',
        'is_settled' => 'boolean',
    ];

}