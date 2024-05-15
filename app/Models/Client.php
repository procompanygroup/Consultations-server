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
use Illuminate\Support\Str;
class Client extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'user_name',
       'password',
        'mobile',
       'email',
       'nationality',
        'birthdate',
        'gender',
       'marital_status',
        'image',
       'token',
       'points_balance',
       'is_active',
       'country_code',
'country_num',
'mobile_num',
 

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'birthdate_conv',
     'gender_conv',
     'marital_status_conv',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      
        'password' => 'hashed',
    ];
 protected $appends= ['image_path'];
    public function getImagePathAttribute(){
        $conv="";
        $strgCtrlr = new StorageController(); 
        if(is_null($this->image) ){
            $conv =$strgCtrlr->DefaultPath('image'); 
        }else if($this->image==''){
            $conv =$strgCtrlr->DefaultPath('image'); 
        } else {
            $url = $strgCtrlr->ClientPath('image');
            $conv =  $url.$this->image;
        }     
       
            return  $conv;
     }

  
public function getGenderConvAttribute(){
    $conv = "";
    
        if ($this->gender == 1) {
            $conv = __('general.male');
        } else {
            $conv = __('general.female');
        }

         return  $conv;
  }
  public function getMaritalStatusConvAttribute(){
     $conv="";
   
          $lrval = Str::lower($this->marital_status);
          $conv = __('general.' . $lrval);    
         return  $conv;
  }
  public function getBirthdateConvAttribute(){
    $conv="";
  
         $lrval = Str::lower($this->value);
         $conv = __('general.' . $lrval);    
        return  $conv;
 }
  public function getValueConvAttribute()
  {
      $conv = "";
      if ($this->ispersonal == 1 && $this->name == 'gender') {
          if ($this->value == 1) {
              $conv = __('general.male');
          } else {
              $conv = __('general.female');
          }

      } else if ($this->ispersonal == 0 && $this->type == 'bool') {
          if ($this->value == 1) {
              $conv = __('general.yes');
          } else {
              $conv = __('general.no');
          }
      } else if ($this->ispersonal == 1 && $this->name == 'marital_status') {
          $lrval = Str::lower($this->value);
          $conv = __('general.' . $lrval);
      } else {
          $conv = $this->value;
      }


      return $conv;
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
    

    public function selectedservices(): HasMany
    {
        return $this->hasMany(Selectedservice::class);
    }
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class);
    }
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }
}
