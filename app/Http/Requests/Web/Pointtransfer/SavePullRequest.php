<?php

namespace App\Http\Requests\Web\Pointtransfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class SavePullRequest extends FormRequest
{
   
   //protected $alphaexpr='/^[\pL\s\_\-\0-9]+$/u';
    

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
         // 'field_name'=>'required|string|regex:'.$this->alphaexpr,  
         'sel_side'=>'required|in:expert,client', 
         
         'sel_side_val'=>'required|integer|not_in:0', 
         'amount'=>'required|decimal:0,2|not_in:0|gt:0', 
        
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
      'sel_side'=> __('messages.this field is required') ,       
       'sel_side_val'=> __('messages.this field is required') ,  
      'amount.required' => __('messages.this field is required') , 
      'amount.not_in' => __('messages.this field is required') , 
      'amount.decimal' =>  __('messages.must be integer') ,
      'amount.gt' =>  __('messages.must be integer') ,
     ];
     
 }
 
}
