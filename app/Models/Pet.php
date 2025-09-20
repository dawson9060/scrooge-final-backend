<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'breed',
        'age',
        'is_pet_friendly',
        'is_kid_friendly',
        'has_special_needs',
        'has_medication_needs',
        'description'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    protected $casts = [
        'is_pet_friendly' => 'boolean',
        'is_kid_friendly' => 'boolean',
        'has_medication_needs' => 'boolean',
        'has_special_needs' => 'boolean',
    ];

}