<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\NotificationUser;
use App\Http\Controllers\Api\StorageController;
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
        'selectedservice_id',
        'pointtransfer_id',
    ];
    protected  $hidden=['side_conv','path_conv','type_conv'];
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
    public function getTypeConvAttribute()
    {
        $conv = "";
        switch($this->type) {
            case('text'):
                $conv = __('general.type_text');
               break;
               case('image'):
                $conv =__('general.type_image');
               break;
               case('video'):
                $conv = __('general.type_video') ;
               break;
                
            default:
            $conv = $this->type;
        }
        return $conv;
    }    public function getPathConvAttribute()
    {
        $conv = "";
        switch($this->type) {
            case('image'):              
                $strgCtrlr = new StorageController();
                $url = $strgCtrlr->NotifyPath($this->type);
                $conv =  $url.$this->data;            
               break;
               case('video'):
                $strgCtrlr = new StorageController();
                $url = $strgCtrlr->NotifyPath($this->type);
                $conv =  $url.$this->data; 
               break;             
            default:
            $conv ='';
        }
        return $conv;
    }
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class);
    }

    public function selectedservice(): BelongsTo
    {
        return $this->belongsTo(Selectedservice::class, 'selectedservice_id')->withDefault();
    }
}

