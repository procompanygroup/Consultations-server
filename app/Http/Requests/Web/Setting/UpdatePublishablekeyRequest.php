<?php

namespace App\Http\Requests\Web\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublishablekeyRequest extends FormRequest
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
         'publishable_key'=>'required', 
     
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
      'publishable_key.required'=> __('messages.this field is required') ,
      
    ];    
}
}
