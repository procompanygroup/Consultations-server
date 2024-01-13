<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Point extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'count',
        'price',
        'pricebefor',
        'countbefor',
        'createuser_id',
        'updateuser_id',
         
             
    ];
    public function pointsTransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class);
    }
}
