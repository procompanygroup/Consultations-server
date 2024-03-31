<?php

namespace App\Http\Requests\Web\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class UpdateServiceRequest extends FormRequest
{

    protected $alphaexpr='/^[\pL\s\_\-\0-9]+$/u'; 
     
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
            'name'=>'required|string|regex:'.$this->alphaexpr, 
          //  'desc'=>'string', 
             'icon' =>File::types(['svg']), 
             'image'=>'file|image',  
        
             ];   
       
    }
    public function messages(): array
    {
      
       return[   
          'name.required'=> __('messages.this field is required') ,       
          
          'image'=>__('messages.file must be image') ,
          'icon'=>__('messages.file must be svg') ,
          'name.regex'=>__('messages.must be alpha') ,
     
        ];
        
    }
}
