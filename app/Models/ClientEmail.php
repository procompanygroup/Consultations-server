<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{

    use HasFactory;
    protected $table = 'clients_emails';
    protected $fillable = [
        'is_confirm',
        'email',
        'code',
        'notes',
        ];
}
