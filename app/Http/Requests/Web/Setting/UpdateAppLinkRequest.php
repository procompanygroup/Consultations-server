<?php

namespace App\Http\Requests\Web\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {     
       return[
         'gplay_link'=>'nullable|string', 
         'appstor_link'=>'nullable|string',
         // 'x_link'=>'required|string',
         // 'facebook_link'=>'required|string',
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
      'gplay_link.required'=> __('messages.this field is required') ,
      'appstor_link.decimal'=> __('messages.must be integer') ,
    
    ];    
}
}
