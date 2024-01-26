<?php

namespace App\Http\Requests\Web\Expert;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpertRequest extends FormRequest
{
   
protected   $minpass=8;
protected   $maxpass=16;
protected  $minMobileLength=10;
protected $maxMobileLength=10;
protected $maxlength=500;
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
         'first_name'=>'required|string', 
         'last_name'=>'required|string', 
           'user_name'=>'required|string|unique:experts,user_name',    
        // 'name'=>'required|alpha_num:ascii|unique:users,name',        
         'email'=>'required|email|unique:experts,email',      
         'password'=>'required|between:'. $this->minpass.','. $this->maxpass,
         'confirm_password' => 'same:password',
         'mobile'=>'required|unique:experts,mobile|numeric|digits_between:'. $this->minMobileLength.','.$this->maxMobileLength,          
        'gender'=>'required|in:1,2',
      //  'is_active'=>'required',  
        'image'=>'file|image',   
        'birthdate'=>'required|date',
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
      'first_name.required'=> __('messages.this field is required') ,
      'last_name.required'=>__('messages.this field is required') ,   
     'user_name.required'=> __('messages.this field is required') ,
  //   'name.alpha_num'=>'The name format must be alphabet',
     'user_name.unique'=>__('messages.The user_name is already exist'),
    'email.required'=>__('messages.this field is required') ,
     'email.email'=>__('messages.must be email') ,
   'email.unique'=>__('messages.email is already exist') ,
    // 'inputPasswordConfirm' => 'confirm must match passowrd',
//     'first_name.alpha'=>'first name format must be alphabet',
  //   'last_name.alpha'=>'last name format must be alphabet',
     'password.required'=>__('messages.this field is required') ,
     'password.between'=>__('messages.password must be between',['Minpass'=>$this->minpass,'Maxpass'=>$this->maxpass]),
    // 'address.between'=>'address charachters must be les than '.$maxlength,
    'confirm_password.same' => __('messages.confirm_password match') ,
   
     //'city.required'=>'city is required',
     'mobile.numeric'=>__('messages.only numbers') ,
     'mobile.digits_between'=>__('messages.this field must be between',['Minmobile'=> $this->minMobileLength]),
     'mobile.required'=> __('messages.this field is required') ,
     'gender.in'=>__('messages.this field is required') ,
     'gender.required'=>__('messages.this field is required') ,
     'image'=>__('messages.file must be image') ,
     'birthdate.required'=>__('messages.this field is required') ,
     'birthdate.date'=>__('messages.this field must be date') ,
    ];
    
}

}
