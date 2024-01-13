<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Servicefavorite extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'client_id',
'service_id',

             
    ];
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }

}
