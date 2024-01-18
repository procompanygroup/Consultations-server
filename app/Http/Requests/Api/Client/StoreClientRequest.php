<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
         'mobile'=>'nullable|unique:clients,mobile|digits_between:'. $minMobileLength.','.$maxMobileLength,          
      //   'phone'=>'nullable|numeric|digits_between:'. $minMobileLength.','.$maxMobileLength,
        // 'role'=>'required',      
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
   $minMobileLength=10;
   $maxMobileLength=15;
   return[     
     'user_name.required'=>'The name is required',
  //   'name.alpha_num'=>'The name format must be alphabet',
     'user_name.unique'=>'The name is already exist',
  //   'email.required'=>'Email is required',
     'email.email'=>'Valid Email  is required',
   //  'email.unique'=>'The Email is already exist',
 
     'password.required'=>'password is required',
  
    // 'address.between'=>'address charachters must be les than '.$maxlength,
     'nationality.required'=>'country is required',
     'gender.required'=>'gender is required',
     'gender.numeric'=>'gender must contain only numbers',
     //'city.required'=>'city is required',
     'mobile.numeric'=>'mobile must contain only numbers',
     'mobile.digits_between'=>'mobile number must be between '. $minMobileLength.' and '.$maxMobileLength,
   
    // 'phone.numeric'=>'phone must contain only numbers',
     //'phone.digits_between'=>'phone  number must be between '. $minMobileLength.' and '.$maxMobileLength,
     //'role.required'=>'role is required',
    ];
    
}
}
