<?php

namespace App\Http\Requests\Web\Notify;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotifyRequest extends FormRequest
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
         'title'=>'required|string', 
         'body'=>'nullable|string', 
         'side'=>'required ', 
     
      //  'is_active'=>'required',  
          
       ];   
    
    }
    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array<string, string>
 */
public function messages(): array
{
  
   return[   
      'title.required'=> __('messages.this field is required') ,
     // 'content.string'=> __('messages.this field is required') ,
      'side.required'=>__('messages.this field is required') ,   
  'side.in'=>__('messages.this field is required') ,
      
 
    ];
    
}
}
