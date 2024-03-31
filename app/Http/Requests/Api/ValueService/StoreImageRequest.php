<?php

namespace App\Http\Requests\Api\ValueService;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
         'inputservice_id'=>'nullable|integer', //|not_in:0', 
         'record_inputservice_id'=>'nullable|integer', 
         'selectedservice_id'=>'required|integer|not_in:0',        
         'image_1'=>'nullable|file|image',
         'image_2'=>'nullable|file|image',
         'image_3'=>'nullable|file|image',
         'image_4'=>'nullable|file|image',
        // 'record'=>'nullable|file|extensions:mp3',  
      //  'record'=>'nullable|file|mimes:mp3',  
      'record'=>'nullable|file ',
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
       'inputservice_id.integer'=>'must be integer' ,
      // 'inputservice_id.not_in'=>' must be not 0' ,
       'record_inputservice_id.integer'=>'must be integer' ,
      'selectedservice_id.required'=> 'this field is required',
      'selectedservice_id.integer'=>'messages must be integer' ,
      'selectedservice_id.not_in'=> 'this field is required and not 0',
      'image_1'=>'file must be image' ,
      'image_2'=>'file must be image' ,
      'image_3'=>'file must be image' ,
      'image_4'=>'file must be image' ,
       
      'record'=>'file must be file' ,//'record'=>'file must be mp3' ,
    ];
    
}

}
