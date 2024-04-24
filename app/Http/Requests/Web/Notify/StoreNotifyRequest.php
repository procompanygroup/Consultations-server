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
         'type'=> 'required|in:text,image,video', 
      //  'image'=> 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
      //  'image'=>'required|file|mimes:jpg,bmp,png,jpeg,gif,svg',
        'image'=>($this->input('type')=='image'?'required|mimes:jpg,bmp,png,jpeg,gif,svg,webp':
      ($this->input('type')=='video'? 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime':'nullable')),
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
  'type'=>__('messages.this field is required') ,
  //'type.in'=>__('messages.this field is required') ,
  'image.required'=>__('messages.this field is required') ,
  'image.mimes'=>__('messages.file must be image') ,
  'image.mimetypes'=>__('messages.file must be video') ,
 'image.uploaded'=>__('messages.file size is too larg') ,
    ];
    
}
}
