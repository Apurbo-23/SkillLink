<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'skill_offered', 'skill_wanted', 'category', 'description', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function swapRequests(): HasMany
    {
        return $this->hasMany(SwapRequest::class);
    }
}
