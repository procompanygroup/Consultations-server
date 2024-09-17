<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftMinute extends Model
{
    use HasFactory;
    protected $table = 'gifts_minutes';
    protected $fillable = [
        'client_id',
        'free_minutes',
        'is_active',
        'status',
        'notes',  
        'orginal_minutes', 
 
    ];
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function pointtransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class,'gift_minute_id');
    }
  
}
