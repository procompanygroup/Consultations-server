<?php

namespace App\Http\Requests\Web\Notifyme;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotifymeRequest extends FormRequest
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
         'body'=>'required|string', 
         'expert_id'=>'required|integer|gt:0 ', 
     
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
      'body.required'=> __('messages.this field is required') ,
     // 'content.string'=> __('messages.this field is required') ,
   
  'expert_id'=>__('messages.this field is required') ,
 
    ];
    
}
}
