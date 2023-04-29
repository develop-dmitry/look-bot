<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function makeups(): MorphToMany
    {
        return $this->morphedByMany(Makeup::class, 'eventtable');
    }

    public function hairs(): MorphToMany
    {
        return $this->morphedByMany(Hair::class, 'eventtable');
    }

    public function clothes(): MorphToMany
    {
        return $this->morphedByMany(Clothes::class, 'eventtable');
    }
}
