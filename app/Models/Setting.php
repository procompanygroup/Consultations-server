<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'type',
        'notes',
        'updateuser_id',
        'ar_name',
        'sequence',
        'dept',

    ];
}