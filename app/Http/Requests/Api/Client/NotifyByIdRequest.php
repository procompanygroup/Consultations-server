<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;

class NotifyByIdRequest extends FormRequest
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
         'id'=>'required|integer|not_in:0',         
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
   
      'id.required'=> 'this field is required',
      'id.integer'=>'messages must be integer' ,
      'id.not_in'=> 'this field is required and not 0',
    //  'id.in'=> 'Unauthenticated',
       
    ];
    
}
}
