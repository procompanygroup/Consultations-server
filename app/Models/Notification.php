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
    protected  $hidden=['side_conv'];
    public function getSideConvAttribute()
    {
        $conv = "";
        switch($this->side) {
            case('client'):
                $conv = __('general.clients');
               break;
               case('expert'):
                $conv =__('general.experts');
               break;
               case('expert,client'):
                $conv = __('general.clients').' , '.__('general.experts');
               break;
               case('client,expert'):
                $conv = __('general.clients').' , '.__('general.experts');
               break;
            default:
            $conv = $this->type;
        }
        return $conv;
    }
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class);
    }
}

