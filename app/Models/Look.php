<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Look extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'lower_temperature_range',
        'upper_temperature_range'
    ];

    public function makeups(): BelongsToMany
    {
        return $this->belongsToMany(Makeup::class);
    }

    public function hairs(): BelongsToMany
    {
        return $this->belongsToMany(Hair::class);
    }

    public function clothes(): BelongsToMany
    {
        return $this->belongsToMany(Clothes::class);
    }
}
