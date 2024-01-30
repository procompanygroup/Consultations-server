<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'name',
        'desc',
        'image',
        'createuser_id',
        'updateuser_id',
        'is_active',
        'icon',
             
    ];

    public $fullpathimg = "";
    public $fullpathsvg = "";
    public function selectedservices(): HasMany
    {
        return $this->hasMany(Selectedservice::class);
    }
    public function expertservices(): HasMany
    {
        return $this->hasMany(ExpertService::class);
    }
    public function inputservices(): HasMany
    {
        return $this->hasMany(InputService::class);
    }
    public function pointtransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class);
    }
 
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
    
}
