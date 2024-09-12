<?php

namespace App\Http\Requests\Api\Expert;

use Illuminate\Foundation\Http\FormRequest;

class ChangeNotifyStatusRequest extends FormRequest
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
         'expert_id'=>'required|integer|not_in:0|in:'.auth()->user()->id,        
    
       
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
   
      'expert_id.required'=> 'this field is required',
      'expert_id.integer'=>'messages must be integer' ,
      'expert_id.not_in'=> 'this field is required and not 0',
      'expert_id.in'=> 'Unauthenticated',
      
      'token'=>'this field is required' ,
    ];
    
}
}
