<?php

namespace App\Http\Requests\Web\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class StoreExpertServiceRequest extends FormRequest
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
            'select_expert'=>'required|integer',  
             ];   
       
    }
    public function messages(): array
    {
      
       return[   
          'select_expert.required'=> __('messages.this field is required') , 
          'select_expert.integer'=> __('messages.this field is required') , 
        ];
        
    }
}
