<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
       $maxlength=500;
       $minMobileLength=10;
       $maxMobileLength=15;
       return[
         'id'=>'required', 
              'user_name'=>'required', 
        //   'user_name'=>'required|alpha_num:ascii|unique:clients,user_name',    
        // 'name'=>'required|alpha_num:ascii|unique:users,name',        
         //'email'=>'required|email|unique:users,email',
         'email'=>'required',
       //  'first_name'=>'nullable|alpha',    
         //'last_name'=>'nullable|alpha',
       //  'password'=>'required',
       //  'inputPasswordConfirm' => 'same:password',
      //   'address'=>'nullable|between:0,'.$maxlength,
      'gender'=>'required|numeric',
     
         'nationality'=>'required',
       //  'city'=>'required|alpha_num',
    //     'mobile'=>'nullable|unique:clients,mobile|digits_between:'. $minMobileLength.','.$maxMobileLength,          
     
        // 'role'=>'required',   
         //  'country_num'=>['required','not_in:0',Rule::unique('experts','country_num')->where('country_num', $this->input('country_num'))->where('mobile_num', $this->input('mobile_num') )->where('is_active',1)->ignore($this->id)  ],          
  //  'mobile_num'=>['required','numeric','digits_between:'. $this->minMobileLength.','.$this->maxMobileLength,Rule::unique('experts','mobile_num')->where('country_num', $this->input('country_num'))->where('mobile_num', $this->input('mobile_num') )->where('is_active',1)->ignore($this->id)],          
        
       ];   
    
    }
    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array<string, string>
 */
public function messages(): array
{
   $maxlength=500;
   $minMobileLength=9;
   $maxMobileLength=9;
   return[     
     'user_name.required'=>'The name is required',
     'id.required'=>'id is required',
      
     'user_name.unique'=>'The name is already exist',
 
     'email.email'=>'Valid Email  is required',
 
 
     //'password.required'=>'password is required',
  
    
     'nationality.required'=>'country is required',
     'gender.required'=>'gender is required',
     'gender.numeric'=>'gender must contain only numbers',
     
  //   'mobile.numeric'=>'mobile must contain only numbers',
    // 'mobile.digits_between'=>'mobile number must be between '. $minMobileLength.' and '.$maxMobileLength,
 
    ];
    
}
}
