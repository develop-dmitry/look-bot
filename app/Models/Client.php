<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telegram_id',
        'lat',
        'lon'
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clothes(): BelongsToMany
    {
        return $this->belongsToMany(Clothes::class);
    }
}
