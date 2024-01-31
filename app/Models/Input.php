<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Input extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'name',
'type',
'tooltipe',
'icon',
'ispersonal',
'is_active',
        'image_count' ,    
    ];
    public function inputvalues(): HasMany
    {
        return $this->hasMany(Inputvalue::class);
    }
    public function inputServices(): HasMany
    {
        return $this->hasMany(InputService::class);
    }

}
