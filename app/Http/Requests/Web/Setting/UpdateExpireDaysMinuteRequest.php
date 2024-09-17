<?php

namespace App\Http\Requests\Web\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpireDaysMinuteRequest extends FormRequest
{
   protected   $minval=1;
protected   $maxval=360;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {     
       return[         
         'expire_days_minute'=>'required|integer|between:'. $this->minval.','. $this->maxval,
       ];   
    
    }
    /**
 * Get the error messages for the defined validation rules. 'decimal:2'

 *
 * @return array<string, string>
 */
public function messages(): array
{ 
   return[   
      'expire_days_minute.required'=> __('messages.this field is required') ,
      'expire_days_minute.integer'=> __('messages.must be integer') ,
      'expire_days_minute.between'=>__('messages.this field must be between in',['Minmobile'=> $this->minval,'Maxmobile'=> $this->maxval]),
    
    ];    
}
}
