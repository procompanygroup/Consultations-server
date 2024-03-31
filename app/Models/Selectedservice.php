<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
//use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB; 
class Selectedservice extends Model
{
    use HasFactory;
    protected $fillable = [

        'client_id',
        'expert_id',
        'service_id',
        'points',
        'rate',
        'order_num',
        'form_state',
        'form_reject_reason',
        'order_date',
'order_admin_date',
'order_admin_id',
        'comment',
        'comment_date',
        'comment_state', 
        'comment_reject_reason',
        'comment_admin_date',
        'comment_rate',
        'status',       
        'expert_cost',
        'cost_type',
        'expert_cost_value',     
        'company_profit',
        'company_profit_percent',
        'comment_user_id',
        'rate_date',
'comment_rate_date',
'comment_rate_admin_id',
'answer_speed',
    ];  
    //$appends
 protected  $hidden= ['form_state_conv' ,'answer_state_conv' ,'comment_state_conv'];
 protected  $appends= ['title','answer_state'];
 protected $casts = [
    'rate' => 'integer',    
];
 public function getFormStateConvAttribute(){
    $conv="";
    switch($this->form_state) {
        case('wait'):
            $conv = __('general.wait');
           break;
           case('agree'):
            $conv =__('general.order')." ".__('general.status.agree');
           break;
           case('reject'):
            $conv = __('general.order')." ".__('general.status.reject');
           break;

        default:
        $conv = $this->form_state;
    }
        return  $conv;
 }

 public function getAnswerStateAttribute(){
    $conv="";
 
    if($this->answers->isEmpty()){
        $conv='no_answer';
    }else
    {
      //  $answer=  DB::table('answers')->where('selectedservice_id',$this->id)->latest() ;
       $answer= $this->answers->sortBy('created_at')->last()->answer_state ;
         if( $answer =='reject'){
        $conv='reject';
    }else if ($answer =='agree'){
        $conv='agree';
    }else if($answer=='wait'){
        $conv='wait';
    }
}
     
        return  $conv;
 }
 public function getTitleAttribute(){
    $conv="";

    if($this->answer_state=='no_answer' ){
        if(!is_null($this->client()->first())){
            $conv=__('general.order_for_client',['Name'=>$this->client()->first()->user_name]);
        }
       
    }       
    else {
        if(!is_null($this->client()->first())){
        $conv=__('general.answer_for_client',['Name'=>$this->client()->first()->user_name]);
    }
    } 
     
        return  $conv;
 }

 public function getAnswerStateConvAttribute(){
    $conv="";
 
    if($this->answer_state=='no_answer' ){
        $conv=__('general.status.no_answer');
    }       
    else if( $this->answer_state=='reject'){
        $conv=__('general.the answer')." ".__('general.status.reject');
    }else if ($this->answer_state=='agree'){
        $conv=__('general.the answer')." ".__('general.status.agree');
    }else if($this->answer_state=='wait'){
        $conv=__('general.wait');;
    } 
     
        return  $conv;
 }
 public function getCommentStateConvAttribute(){
    $conv="";
    switch($this->comment_state) {
        case('wait'):
            $conv = __('general.wait');
           break;
           case('agree'):
            $conv =__('general.comment')." ".__('general.status.agree');
           break;
           case('reject'):
            $conv = __('general.comment')." ".__('general.status.reject');
           break;

        default:
        $conv = $this->comment_state;
    }
        return  $conv;
 }


 

    /* deleted
        // 'answer',
          //  'answer2',
       //  'iscommentconfirmd',
           // 'issendconfirmd',
            //'isanswerconfirmd',
    */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }

    public function valueServices(): HasMany
    {
        return $this->hasMany(ValueService::class);
    }
    public function pointtransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class,'selectedservice_id');
    }
    public function answers(): HasMany
    {
         
        return $this->hasMany(Answer::class);
    }
    public function cashTransfers(): HasMany
    {
        return $this->hasMany(Cashtransfer::class,'selectedservice_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'comment_user_id')->withDefault();
    }
}
