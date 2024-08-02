<?php

namespace App\Http\Requests\Web\Expert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
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
         'status'=>'required|in:a,b,n', 
         
       ];   
    
    }
    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array<string, string>
 */
public function messages(): array
{
  
   return[   
      'status.required'=> __('messages.this field is required') ,
      
    ];
    
}

}
