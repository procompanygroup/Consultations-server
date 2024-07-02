<?php

namespace App\Http\Requests\Api\Mail;

use Illuminate\Foundation\Http\FormRequest;

class GetMailRequest extends FormRequest
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
      //  'email'=>'required|email|unique:clients,email',
       'email'=>'required|email',
      
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
  
    ];
    
}
}
