<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrdersRequest extends FormRequest
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
      'expert_id.integer'=> 'must be integer',
      'expert_id.not_in'=> 'this field is required',     
      'expert_id.in'=> 'Unauthenticated',
      
    ];
    
}
}
