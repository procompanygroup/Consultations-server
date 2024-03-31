<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'content',
'type',
'is_active',
             
    ];
 //   protected $appends= ['dept_conv'];
    protected  $hidden=['dept_conv'];
    public function getDeptConvAttribute()
    {
        $conv = "";
        switch($this->type) {
            case('form'):
                $conv = __('general.orders');
               break;
               case('answer'):
                $conv =__('general.answers');
               break;
               case('form,answer'):
                $conv = __('general.orders').' , '.__('general.answers');
               break;
    
            default:
            $conv = $this->type;
        }
        return $conv;
    }
}
