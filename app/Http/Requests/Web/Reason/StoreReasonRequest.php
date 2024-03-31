<?php

namespace App\Http\Requests\Web\Reason;

use Illuminate\Foundation\Http\FormRequest;

class StoreReasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       
      
       return[
         'content'=>'required|string', 
         'deptype'=>'required ', 
     
      //  'is_active'=>'required',  
          
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
      'content.required'=> __('messages.this field is required') ,
      'content.string'=> __('messages.this field is required') ,
      'deptype.required'=>__('messages.this field is required') ,   
  'deptype.in'=>__('messages.this field is required') ,
      
 
    ];
    
}
}
