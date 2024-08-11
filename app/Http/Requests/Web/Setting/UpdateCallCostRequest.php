<?php

namespace App\Http\Requests\Web\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCallCostRequest extends FormRequest
{
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
         'call_cost'=>'required|decimal:0,2|gt:0', 
     
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
      'call_cost.required'=> __('messages.this field is required') ,
      'call_cost.decimal'=> __('messages.must be integer') ,
      'call_cost.gt'=> __('messages.must be integer') ,
    ];    
}
}
