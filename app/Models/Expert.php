<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Controllers\Api\StorageController;
class Expert extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
'last_name',
        'user_name',
        'password',
        'mobile',
        'email',
        'nationality',
        'birthdate',
        'gender',
        'marital_status',
        'image',
        'points_balance',
        'cash_balance',
        'cash_balance_todate',
        'rates',
        'record',
        'desc',
        'call_cost',
        'created_at',
        'updated_at',
        'token',
        'answer_speed',
        'is_active',
        'country_code',
'country_num',
'mobile_num',
'is_available',
'status',// a b n
'call_balance'

    ];
    public $fullpathimg = "";
    public $birthdateStr = "";
    public $is_favorite = 0;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'record_path',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      
        'password' => 'hashed',
      'answer_speed' => 'integer',
    ];

    protected $appends= ['full_name','status_conv'];
 public function getFullNameAttribute(){     
        return  $this->first_name.' '. $this->last_name ;
 }
 public function getStatusConvAttribute(){
    $conv="";
    if( $this->status==null || $this->status==""){
        $conv=__('general.notavailable');
    }else{
        switch($this->status) {
            case('a'):
                $conv = __('general.available');
               break;
               case('b'):
                $conv =__('general.busy');
               break;
               case('n'):
                $conv = __('general.notavailable');
               break;
    
            default:
            $conv =__('general.notavailable');
        }
    }
            return  $conv;
 }
 

 public function getRecordPathAttribute(){     

          $conv="";
          if(!(is_null($this->record)||$this->record=="")){
            $strgCtrlr = new StorageController();
            $url = $strgCtrlr->ExpertPath('record');
            $conv =  $url.$this->record;   
          } 
      
            return  $conv;


}

public function getImagePathAttribute(){
    $conv="";
    $strgCtrlr = new StorageController(); 
    if(is_null($this->image) ){
        $conv =$strgCtrlr->DefaultPath('image'); 
    }else if($this->image==''){
        $conv =$strgCtrlr->DefaultPath('image'); 
    } else {
        $url = $strgCtrlr->ExpertPath('image');
        $conv =  $url.$this->image;
    }     
   
        return  $conv;
 }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    //


    public function expertsServices(): HasMany
    {
        return $this->hasMany(ExpertService::class);
    }
    public function pointsTransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class);
    }
    public function cashTransfers(): HasMany
    {
        return $this->hasMany(Cashtransfer::class);
    }
    public function expertsFavorites(): HasMany
    {
        return $this->hasMany(Expertfavorite::class);
    }

    public function loginexpertFavorites(): HasMany
    {
        return $this->hasMany(Expertfavorite::class,'login_expert_id');
    }
    public function selectedservices(): HasMany
    {
        return $this->hasMany(Selectedservice::class);
    }
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function clientsexperts(): HasMany
    {
        return $this->hasMany(ClientExpert::class);
    }
    public function notifyclients(): HasMany
    {
        return $this->hasMany(NotifyClient::class);
    }
}
