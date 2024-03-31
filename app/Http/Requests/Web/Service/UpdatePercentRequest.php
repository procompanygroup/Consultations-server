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
            'expert_percent'=>'required|decimal:0,2', 
          //  'desc'=>'string', 
              
        
             ];   
       
    }
    public function messages(): array
    {
      
       return[   
          'expert_percent.required'=> __('messages.this field is required') ,       
          'expert_percent.decimal'=>__('messages.must be integer') , 
         
     
        ];
        
    }
}
