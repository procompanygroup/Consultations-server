<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Routing\Router;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use Image;

use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Web\User\StoreUserRequest;
use App\Http\Requests\Web\User\UpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
  

    $users = DB::table('users')->get();
      return view('admin.user.show',['users' => $users]); 
    //return response()->json($users);
   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.add' ); 
        
    }
/*
    public function check()
    {
      if(  Auth::check())
      $res="yes";
    $user= Auth::user()->role;
        return    $res;
    }
*/
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $formdata=$request->all();  
        $validator = Validator::make($formdata,
        $request->rules(),
        $request->messages()
     );
     
     if ($validator->fails()) {
     
                     return  redirect()->back()->withErrors($validator)
                     ->withInput();
                    
     }else{
             $user = new User;
             $user->name = $formdata['user_name'];
            //  $user->first_name = $formdata['first_name'];
            //  $user->last_name = $formdata['last_name'];
             $user->email = $formdata['email'];
             $user->password =bcrypt($formdata['password']);          
             $user->mobile = $formdata['mobile'];      
             $user->role = $formdata['role'];            
             $user->createuser_id= Auth::user()->id;
             $user->updateuser_id= Auth::user()->id;
             $user->save();
            
              return redirect()->back()->with('success_message','user has been Added!');
         } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user= DB::table('users')->find($id);

        //
 return view('admin.user.edit',['user' => $user]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request,$id)
    {
        $formdata=$request->all();
        //validate
        
        $validator = Validator::make($formdata,
        $request->rules(),
        $request->messages()
     );
     if ($validator->fails()) {
       /*
         return redirect('/cpanel/users/add')
         ->withErrors($validator)
                     ->withInput();
                     */
                     return  redirect()->back()->withErrors($validator)
                     ->withInput();
                    
     }else{

        /*
   $user->name = $formdata['user_name'];
            //  $user->first_name = $formdata['first_name'];
            //  $user->last_name = $formdata['last_name'];
             $user->email = $formdata['email'];
             $user->password =bcrypt($formdata['password']);          
             $user->mobile = $formdata['mobile'];      
             $user->role = $formdata['role'];            
             $user->createuser_id= Auth::user()->id;
             $user->updateuser_id= Auth::user()->id;
        */
            
 
      User::find($id)->update([
'user_name'=>$formdata['user_name'], 
'email' => $formdata['email'],
'password' => bcrypt($formdata['password']), 
'mobile' => $formdata['mobile'], 
'role' => $formdata['role'],
'updateuser_id'=> Auth::user()->id,
 
]);
     
      return redirect()->back()->with('success_message','user has been Updated!');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //delete foriegn key
        User::where('createuser_id',$id)->update( [
            'createuser_id'=>null,

        ]);
        User::where('updateuser_id',$id)->update( [
            'updateuser_id'=>null,
        ]);
      //delete user
        $user= User::find($id);
              
        if (!($user === null)) {
      User::find($id)->delete();
        }
         return redirect()->route('admin.user.show');
     
    }
}
