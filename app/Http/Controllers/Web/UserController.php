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
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
  public $path = 'images/users';
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
        return view('admin.user.create' );

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
    public function store( StoreUserRequest $request)
    {
        $formdata=$request->all();
       // return redirect()->back()->with('success_message', $formdata);
        $validator = Validator::make($formdata,
        $request->rules(),
        $request->messages()
     );

     if ($validator->fails()) {
/*
                     return  redirect()->back()->withErrors($validator)
                     ->withInput();
                     */
                    // return response()->withErrors($validator)->json();
                    return response()->json($validator);

     }else{
             $newObj = new User;
             $newObj->name = $formdata['name'];
              $newObj->first_name = $formdata['first_name'];
            $newObj->last_name = $formdata['last_name'];
             $newObj->email = $formdata['email'];
             $newObj->password =bcrypt($formdata['password']);
             $newObj->mobile = $formdata['mobile'];
             $newObj->role = $formdata['role'];
          //   $newObj->is_active = $formdata['is_active'];
             $newObj->createuser_id= Auth::user()->id;
             $newObj->updateuser_id= Auth::user()->id;
             $newObj->is_active = isset($formdata["is_active"]) ? 1 : 0;
           $newObj->save();
          
             if ($request->hasFile('image')) {

              $file= $request->file('image');
                     // $filename= $file->getClientOriginalName();
                     
           $this->storeImage( $file,$newObj->id);
           //  $this->storeImage( $file,2);
          }
               
              return response()->json("ok");
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
      $url =url(Storage::url($this->path)).'/';
        $user=User::find($id);
        if( $user->image !="" ){
          $user->fullpathimg= $url.$user->image;
        }

        //
 return view('admin.user.edit',['user' => $user]);
    }
 
    public function update(UpdateUserRequest $request ,$id )
    {
   //  return $request->all();
     // UpdateUserRequest
      
        //validate
     
        $formdata= $request->all();
        $validator = Validator::make($formdata,
        $request->rules(),
        $request->messages()
     );
     if ($validator->fails()) {     
   
                     return response()->json($validator);

     }else{


     
        if ($request->hasFile('image')) {
         $file= $request->file('image');
                // $filename= $file->getClientOriginalName();                
      $this->storeImage( $file,$id);
        }
      User::find($id)->update([
//'user_name'=>$formdata['user_name'],
'name'=>$formdata['name'],
'first_name'=>$formdata['first_name'],
'last_name'=>$formdata['last_name'],
'email'=>$formdata['email'],
 
//'password' => bcrypt($formdata['password']),
'mobile' => $formdata['mobile'],
'role' => $formdata['role'],
'updateuser_id'=> Auth::user()->id,
'is_active' => isset($formdata["is_active"]) ? 1 : 0,
]);

if(isset($formdata['password'])){
  $password = trim($formdata['password']);
  User::find($id)->update([
    'password' => bcrypt($password),
  ]);
}
  //    return redirect()->back()->with('success_message','user has been Updated!');
      return response()->json("ok");
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
        $oldimagename=$user->image;
        Storage::delete("public/" . $this->path . '/' . $oldimagename);
        if (!($user === null)) {
      User::find($id)->delete();
        }
         return redirect()->route('user.index'); 

    }
    public function trimstr()
    {
       $s=" d d ";
     $s=  trim($s);
     return  response()->json($s);

    }   
     public function storeImage($file, $id)
    {
        $imagemodel = User::find($id);
        $oldimage = $imagemodel->image;
        $oldimagename = basename($oldimage);
        $oldimagepath = $this->path . '/' . $oldimagename;
        //save photo

        if ($file !== null) {
            //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
            $filename = rand(10000, 99999) . $id . ".webp";
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image = $image->toWebp(75);
            if (!File::isDirectory(Storage::url('/' . $this->path))) {
                Storage::makeDirectory('public/' . $this->path);
            }
            $image->save(storage_path('app/public') . '/' . $this->path . '/' . $filename);
         //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
            User::find($id)->update([
                "image" => $filename
            ]);
            Storage::delete("public/" . $this->path . '/' . $oldimagename);
        }
        return 1;
    }
}
