<?php

namespace App\Http\Requests\Api\Expertfavorite;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpertRequest extends FormRequest
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
         'login_expert_id'=>'required|integer|not_in:0',
         'expert_id'=>'required|integer|not_in:0',
         'is_favorite'=>'required',
         
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
     // 'inputservice_id.required'=>'this field is required' ,
       'client_id'=>'this field is required and not 0' ,
       'expert_id'=>'this field is required and not 0' ,
       'is_favorite'=>'this field is required' ,
     
    ];
    
}

}
