<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Makeup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'level'
    ];

    public function styles(): MorphToMany
    {
        return $this->morphToMany(Style::class, 'styleable');
    }

    public function looks(): BelongsToMany
    {
        return $this->belongsToMany(Look::class);
    }

    public function events(): MorphToMany
    {
        return $this->morphToMany(Event::class, 'eventtable');
    }
}
