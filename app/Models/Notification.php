<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\NotificationUser;
class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'type',
        'side',
        'data',
        'read_at',
        'created_at',
        'updated_at',
        'notes',
          
    ];

    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class);
    }
}

