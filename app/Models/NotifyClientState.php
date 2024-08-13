<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NotifyClientState extends Model
{
    use HasFactory;
    protected $table = 'notify_client_states';
    protected $fillable = [
'client_id',
'notify_client_id',
'isread',
'read_at',


    ];
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }

    public function notifyclient(): BelongsTo
    {
        return $this->belongsTo(NotifyClient::class,'notify_client_id')->withDefault();
    }

}
