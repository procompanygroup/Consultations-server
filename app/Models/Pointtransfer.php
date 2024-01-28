<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Pointtransfer extends Model
{
    use HasFactory;
    
    protected $table = 'pointstransfers';
    protected $fillable = [
        'point_id',
'client_id',
'expert_id',
'service_id',
'count',
'status',
'selectedservice_id',
'side',
    ];


    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }
    public function selectedservices(): BelongsTo
    {
        return $this->belongsTo(Selectedservice::class)->withDefault();
    }
    public function point(): BelongsTo
    {
        return $this->belongsTo(Point::class)->withDefault();
    }
    public function cashTransfers(): HasMany
    {
        return $this->hasMany(Cashtransfer::class,'pointtransfer_id');
    }

}
