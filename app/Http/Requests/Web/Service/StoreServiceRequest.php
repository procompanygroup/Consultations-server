<?php

namespace App\Http\Requests\Web\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class StoreServiceRequest extends FormRequest
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
          'name'=>'required|string', 
        //  'desc'=>'string', 
           'icon' =>File::types(['svg']), 
           'image'=>'file|image',  
      
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
       'name.required'=> __('messages.this field is required') ,       
       
       'image'=>__('messages.file must be image') ,
       'icon'=>__('messages.file must be svg') ,
  
     ];
     
 }
 
}
