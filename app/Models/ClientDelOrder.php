<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ClientDelOrder extends Model
{
    use HasFactory;
    protected $table = 'clients_del_orders';
    protected $fillable = [
        'client_id',
        'email',
        'mobile',
        'state',
        'reason',
        'notes',
    ];
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
}
