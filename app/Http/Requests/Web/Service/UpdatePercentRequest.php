<?php

namespace App\Http\Requests\Web\Service;

use Illuminate\Foundation\Http\FormRequest;
 
class UpdatePercentRequest extends FormRequest
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
            'expert_cost'=>'required|decimal:0,2|gt:0', 
          //  'desc'=>'string', 
              
        
             ];   
       
    }
    public function messages(): array
    {
      
       return[   
          'expert_cost.required'=> __('messages.this field is required') ,       
          'expert_cost.decimal'=>__('messages.must be integer') , 
         
     
        ];
        
    }
}
