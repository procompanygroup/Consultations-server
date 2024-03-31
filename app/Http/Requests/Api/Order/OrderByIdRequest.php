<?php

namespace App\Http\Requests\Api\order;

use Illuminate\Foundation\Http\FormRequest;

class OrderByIdRequest extends FormRequest
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
         'selectedservice_id'=>'required|integer|not_in:0',        
       
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
      'selectedservice_id.integer'=> 'must be integer',
      'selectedservice_id.not_in'=> 'this field is required',     
  
      
    ];
    
}
}
