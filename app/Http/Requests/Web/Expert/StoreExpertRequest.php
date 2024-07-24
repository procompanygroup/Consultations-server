<?php

namespace App\Http\Requests\Web\Expert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreExpertRequest extends FormRequest
{
   
protected   $minpass=8;
protected   $maxpass=16;
protected  $minMobileLength=4;
protected $maxMobileLength=9;
protected $maxlength=500;
protected $alphaexpr='/^[\pL\s\_\-\0-9]+$/u';
protected $alphaAtexpr='/^[\pL\s\_\-\@\.\0-9]+$/u';
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
         'first_name'=>'required|string|regex:'.$this->alphaexpr,  
         'last_name'=>'required|string|regex:'.$this->alphaexpr, 
           'user_name'=>['required','string','regex:'.$this->alphaAtexpr,Rule::unique('experts','user_name')->where('is_active',1)],
         //  |unique:experts,user_name,    
        // 'name'=>'required|alpha_num:ascii|unique:users,name',        
         'email'=>['required','email',Rule::unique('experts','email')->where('is_active',1)],
         //,'unique:experts,email',      
         'password'=>'required|between:'. $this->minpass.','. $this->maxpass,
         'confirm_password' => 'same:password',
       //  'mobile'=>'required|unique:experts,mobile|numeric|digits_between:'. $this->minMobileLength.','.$this->maxMobileLength,   
       'country_num'=>['required','not_in:0',Rule::unique('experts','country_num')->where('country_num', $this->input('country_num'))->where('mobile_num', $this->input('mobile_num') )->where('is_active',1)  ],          
     //  'country_num'=>['required','not_in:0' ],          
       
      // 'mobile_num'=>['required',Rule::unique('experts','mobile_num')->where('country_num',$c_num)->where('mobile_num',$m_num),'digits_between:'. $this->minMobileLength.','.$this->maxMobileLength],          
       'mobile_num'=>['required','numeric','digits_between:'. $this->minMobileLength.','.$this->maxMobileLength,Rule::unique('experts','mobile_num')->where('country_num', $this->input('country_num'))->where('mobile_num', $this->input('mobile_num') )->where('is_active',1)],          
       
        
         'gender'=>'required|in:1,2',

      //  'is_active'=>'required',  
        'image'=>'file|image',   
        'birthdate'=>'required|date',
        'record'=>'nullable|file|extensions:mp3,wav',  // 'record'=>'required|file|mimes:mp3',
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
     'mobile_num.numeric'=>__('messages.only numbers') ,
     'mobile_num.digits_between'=>__('messages.this field must be between in',['Minmobile'=> $this->minMobileLength,'Maxmobile'=> $this->maxMobileLength]),
    
     'mobile_num.required'=> __('messages.this field is required') ,
     'mobile_num.unique'=> __('messages.this field exist') ,
     'gender.in'=>__('messages.this field is required') ,
     'gender.required'=>__('messages.this field is required') ,
     'image'=>__('messages.file must be image') ,
     'birthdate.required'=>__('messages.this field is required') ,
     'birthdate.date'=>__('messages.this field must be date') ,
     'last_name.regex'=>__('messages.must be alpha') ,
     'first_name.regex'=>__('messages.must be alpha') ,
     'user_name.regex'=>__('messages.must be alpha') ,
    
     'country_num.required'=> __('messages.this field is required') ,
     'country_num.not_in'=> __('messages.this field is required') ,
     'country_num.unique'=> '' ,
    ];
    
}

}
