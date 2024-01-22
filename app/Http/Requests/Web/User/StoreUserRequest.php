<?php

namespace App\Http\Requests\Web\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
protected   $minpass=4;
protected   $maxpass=16;
protected  $minMobileLength=10;
protected $maxMobileLength=15;
protected $maxlength=500;
    public function rules(): array
    {
       
      
       return[
         'first_name'=>'required', 
         'last_name'=>'required', 
           'name'=>'required|unique:users,name',    
        // 'name'=>'required|alpha_num:ascii|unique:users,name',        
         'email'=>'required|email|unique:users,email',      
         'password'=>'required|between:'. $this->minpass.','. $this->maxpass,
         'confirm_password' => 'same:password',
         'mobile'=>'nullable|numeric|digits_between:'. $this->minMobileLength.','.$this->maxMobileLength,          
        'role'=>'required|in:admin,super',
      //  'is_active'=>'required',  
        'image'=>'file|image',   
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
      'first_name.required'=>'required',
      'last_name.required'=>'required',   
     'name.required'=> __('messages.user_name is required'),
  //   'name.alpha_num'=>'The name format must be alphabet',
     'name.unique'=>__('messages.The user_name is already exist'),
    'email.required'=>'Email is required',
     'email.email'=>'Valid Email  is required',
   'email.unique'=>'The Email is already exist',
    // 'inputPasswordConfirm' => 'confirm must match passowrd',
//     'first_name.alpha'=>'first name format must be alphabet',
  //   'last_name.alpha'=>'last name format must be alphabet',
     'password.required'=>'password is required',
     'password.between'=>'password must be between '. $this->minpass.' and '. $this->maxpass,
    // 'address.between'=>'address charachters must be les than '.$maxlength,
    
   
     //'city.required'=>'city is required',
     'mobile.numeric'=>'mobile must contain only numbers',
     'mobile.digits_between'=>'mobile number must be between '. $this->minMobileLength.' and '.$this->maxMobileLength,
  
     'role.required'=>'role is required',
    ];
    
}

}
