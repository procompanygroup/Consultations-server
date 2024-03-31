<?php

namespace App\Http\Requests\Web\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentStateRequest extends FormRequest
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
       //  'form_state'=>'required|in:agree,reject', 
         'comment_reject_reason'=>'required|integer', //exclude_if
        // 'form_reject_reason'=>'exclude_unless:form_state,reject|required|integer', //exclude_if
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
      
      'comment_reject_reason.required'=>  __('messages.this field is required') ,
      'comment_reject_reason.integer'=>  __('messages.this field is required') ,     
 
    ];
    
}
}
