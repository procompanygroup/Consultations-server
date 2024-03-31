<?php

namespace App\Http\Requests\Web\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpertPercentRequest extends FormRequest
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
         'expert_percent'=>'required|decimal:0,2', 
     
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
      'expert_percent.required'=> __('messages.this field is required') ,
      'expert_percent.decimal'=> __('messages.must be integer') ,
    ];    
}
}
