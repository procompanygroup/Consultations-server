<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
  
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      
        'password' => 'hashed',
    ];

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
    public function selectedservices(): HasMany
    {
        return $this->hasMany(Selectedservice::class);
    }
}
