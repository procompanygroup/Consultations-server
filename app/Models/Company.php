<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'point_balance',
        'point_profit',
        'cash_balance',
        'cash_profit',
        'notes',
        
         
    ];
}
