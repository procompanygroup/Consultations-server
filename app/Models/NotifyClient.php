<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class NotifyClient extends Model
{
    use HasFactory;
    protected $table = 'notify_clients';
    protected $fillable = [
      'expert_id',
'title',
'body',
'notes',


    ];
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function notifyclientstates(): HasMany
    {
        return $this->hasMany(NotifyClientState::class,'notify_client_id');
    }
}
