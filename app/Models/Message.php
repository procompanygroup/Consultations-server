<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'client_id',
        'expert_id',
        'is_active',
        'user_id',
        'status',
        'title',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
