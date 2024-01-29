<?php

namespace App\Http\Requests\Web\Point;

use Illuminate\Foundation\Http\FormRequest;

class StorePointRequest extends FormRequest
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
         'count'=>'required|integer', 
         'price'=>'required|decimal:0,2', 
          
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
      'count.required'=> __('messages.this field is required') ,
      'count.integer'=> __('messages.must be integer') ,
      'price.required'=>__('messages.this field is required') ,  
      'price.decimal'=>__('messages.must be integer') ,   
  
 
    ];
    
}

}
