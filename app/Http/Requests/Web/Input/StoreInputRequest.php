<?php

namespace App\Http\Requests\Web\Input;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class StoreInputRequest extends FormRequest
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
          'field_name'=>'required|string|regex:'.$this->alphaexpr,  
         'field_type'=>'required|in:text,bool,list,date,longtext', 
         
         'field_tooltipe'=>'required|string|regex:'.$this->alphaexpr,  
           'field_icon' =>File::types(['svg']),   
           
        //   Rule::notIn(['sprinkles', 'cherries']),//not_in:shipsTo



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
       'field_name.required'=> __('messages.this field is required') ,       
       'field_type.required'=> __('messages.this field is required') ,  
      'field_type.in' => __('messages.this field is required') , 
       'field_tooltipe.required'=> __('messages.this field is required') ,   
   
       
       'field_icon'=>__('messages.file must be svg') ,
       'field_name.regex'=>__('messages.must be alpha') ,
       'field_tooltipe.regex'=>__('messages.must be alpha') ,
     ];
     
 }
 
}
