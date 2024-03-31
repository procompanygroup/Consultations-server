<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Cashtransfer extends Model
{
    use HasFactory;
    protected $fillable = [        
        'cash',
        'cashtype',
        'fromtype',
        'totype',
        'status',
        'client_id',
        'expert_id',
        'pointtransfer_id',
           'selectedservice_id',   
           'cash_num',       
    ];
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }
    public function pointtransfers(): BelongsTo
    {
        return $this->belongsTo(Pointtransfer::class,'pointtransfer_id')->withDefault();
    }
    public function selectedservices(): BelongsTo
    {
        return $this->belongsTo(Selectedservice::class,'selectedservice_id')->withDefault();
    }
}
