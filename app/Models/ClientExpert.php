<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientExpert extends Model
{
    use HasFactory;
    protected $table = 'clients_experts';
    protected $fillable = [
        'client_id',
        'expert_id',
        'notify',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }

}
