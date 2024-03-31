<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Notification;
use App\Models\Client;
use App\Models\Expert;
use App\Models\User;
class NotificationUser extends Model
{
    use HasFactory;
    protected $table = 'notifications_users';
    protected $fillable = [
        'notification_id',
'client_id',
'expert_id',
'user_id',
'isread',
'read_at',
'state',
'notes',

         
    ];
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class)->withDefault();
    }

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
}
