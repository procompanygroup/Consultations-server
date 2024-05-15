<?php

namespace App\Http\Requests\Web\Gift;

use Illuminate\Foundation\Http\FormRequest;

class StoreGiftRequest extends FormRequest
{
   protected   $minval=1;
protected   $maxval=360;
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
      
        'sel_side_val'=>'required|integer|not_in:0', 
        'amount'=>'required|integer|not_in:0|gt:0', 
       
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
          
      'sel_side_val'=> __('messages.this field is required') ,  
     'amount.required' => __('messages.this field is required') , 
     'amount.not_in' => __('messages.this field is required') , 
     'amount.integer' =>  __('messages.must be integer') ,
     'amount.gt' =>  __('messages.must be integer') ,
    ];
    
}
}