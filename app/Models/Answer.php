<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Controllers\Api\StorageController;
class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'record',
        'content',
        'answer_reject_reason',
        'answer_state',
        'selectedservice_id',
        'updateuser_id',
        'answer_admin_date',
'answer_date',

           
    ];
   // protected $appends= [];
    protected  $hidden= ['answer_state_conv'];
       protected $appends= ['record_path'];
    public function getRecordPathAttribute(){
        $conv="";
        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->AnswerPath('record');
        $conv =  $url.$this->record;    
            return  $conv;
     }

     public function getAnswerStateConvAttribute(){
        $conv="";
        switch($this->answer_state) {
            case('wait'):
                $conv = __('general.status.wait');
               break;
               case('agree'):
                $conv=__('general.the answer')." ".__('general.status.agree');
               break;
               case('reject'):
                $conv=__('general.the answer')." ".__('general.status.reject');
               break;
    
            default:
            $conv = $this->form_state;
        }
            return  $conv;
     }
    public function selectedservices(): BelongsTo
    {
        return $this->belongsTo(Selectedservice::class)->withDefault();
    }
}
