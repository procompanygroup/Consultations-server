<?php

namespace App\Http\Requests\Api\Expert;

use Illuminate\Foundation\Http\FormRequest;

class PullBalanceRequest extends FormRequest
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
        'amount'=>'required|decimal:0,2|gt:0',          
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
   
      'client_id.required'=> 'this field is required',
      'client_id.integer'=>'messages must be integer' ,
      'client_id.not_in'=> 'this field is required and not 0',
      'client_id.in'=> 'Unauthenticated',
      
      'points'=>'this field is required' ,
    ];
    
}
}
