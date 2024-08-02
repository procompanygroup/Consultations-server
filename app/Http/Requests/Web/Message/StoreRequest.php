<?php

namespace App\Http\Requests\Web\Message;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;
class StoreRequest extends FormRequest
{
   
 
protected $maxlength=500; 
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return true;
    }//$country_num,$mobile_num
    public function rules(): array
    {    
      
       return[
       //  'id'=>'required|integer|gt:0', 
       //  'user_id'=>'required|integer|in:'.auth()->user()->id , 
           'message'=> 'required|string|max:1000',
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
      'message.required'=> __('messages.this field is required') ,
  
    ];
    
}

}
