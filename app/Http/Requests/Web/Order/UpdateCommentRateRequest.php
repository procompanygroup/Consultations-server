<?php

namespace App\Http\Requests\Web\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRateRequest extends FormRequest
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
         'comment_rate'=>'required|integer|in:1,2,3,4,5', //exclude_if
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
      
      'comment_rate.required'=>  __('messages.this field is required') ,
      'comment_rate.integer'=>  __('messages.this field is required') ,   
      'comment_rate.in'=>  __('messages.this field is required') ,     
 
    ];
    
}
}
