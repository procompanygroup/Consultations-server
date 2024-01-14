<?php

namespace App\Http\Requests\Web\Expert;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpertRequest extends FormRequest
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
       $maxlength=500;
       $minMobileLength=10;
       $maxMobileLength=15;
       return[
          
           'user_name'=>'required|alpha_num:ascii|unique:users,name',    
        // 'name'=>'required|alpha_num:ascii|unique:users,name',        
         'email'=>'required|email|unique:users,email',
       //  'first_name'=>'nullable|alpha',    
         //'last_name'=>'nullable|alpha',
         'password'=>'required',
         'mobile'=>'nullable|numeric|digits_between:'. $minMobileLength.','.$maxMobileLength,          
        
        'role'=>'required',      
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
   /*
 'email',
        'nationality',
        'birthdate',
        'gender',
        'marital_status',
        'image',
        'points_balance',
        'cash_balance',
        'cash_balance_todate',
        'rates',
        'record',
        'desc',
        'call_cost',
   */
   return[     
     'user_name.required'=> __('messages.user_name is required'),
  //   'name.alpha_num'=>'The name format must be alphabet',
     'user_name.unique'=>__('messages.The user_name is already exist'),
  //   'email.required'=>'Email is required',
     'email.email'=>'Valid Email  is required',
   //  'email.unique'=>'The Email is already exist',
    // 'inputPasswordConfirm' => 'confirm must match passowrd',
//     'first_name.alpha'=>'first name format must be alphabet',
  //   'last_name.alpha'=>'last name format must be alphabet',
     'password.required'=>'password is required',
  
    // 'address.between'=>'address charachters must be les than '.$maxlength,
    
   
     //'city.required'=>'city is required',
     'mobile.numeric'=>'mobile must contain only numbers',
     'mobile.digits_between'=>'mobile number must be between '. $minMobileLength.' and '.$maxMobileLength,
   
    // 'phone.numeric'=>'phone must contain only numbers',
     //'phone.digits_between'=>'phone  number must be between '. $minMobileLength.' and '.$maxMobileLength,
     'role.required'=>'role is required',
    ];
    
}

}
