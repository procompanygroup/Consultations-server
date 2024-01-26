<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Expertfavorite extends Model
{
    use HasFactory;
    
    protected $table = 'expertsfavorites';
    protected $fillable = [
        'client_id',
        'expert_id',
           
             
    ];
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
}
