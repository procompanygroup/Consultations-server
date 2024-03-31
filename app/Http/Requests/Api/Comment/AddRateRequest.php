<?php

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;

class AddRateRequest extends FormRequest
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
         'selectedservice_id'=>'required|not_in:0',        
        'rate'=>'required|not_in:0|decimal:0,2',  
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
   
      'selectedservice_id.required'=> 'this field is required',
      'selectedservice_id.integer'=>'messages must be integer' ,
      'selectedservice_id.not_in'=> 'this field is required and not 0',
 
      'rate'=>'this field is required' ,
    ];
    
}
}
