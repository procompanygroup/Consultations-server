<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use Image;

use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector;
//use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Api\User\StoreUserRequest;

class UserController extends Controller
{
  public function index()
  {
    //

    $users = DB::table('users')->get();
    // return view('admin.user.showusers',['users' => $users]);
    return response()->json($users);
  }
  public function getLoginUser()
  {
    //
    $user = auth()->user();
    return response()->json([
      'userName' => $user->userName,
      'email' => $user->email,
      'mobile' => $user->mobile,
      'nationality' => $user->nationality,
      'gender' => $user->gender,
      'maritalStatus' => $user->maritalStatus,
      'image' => $user->image,

    ]);

  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
    // return view('admin.user.adduser');
    return view('admin.user.adduser');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreUserRequest $request)
  {
    //try{
    //  try{
    // $x=5/0;
    // validate
    $formdata = $request->all();
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
      return redirect()->back()->withErrors($validator)
        ->withInput();

    } else {
      //  $this->validate($request,$rules,$customMessages);

      //email not repeated
      /*
      $userdb = DB::table('users')->where('email', $formdata['email'])
      ->orWhere('name', $formdata['name'])->first();
if(is_null($userdb)){
*/
      $user = new User;
      $user->name = $formdata['name'];
      $user->first_name = $formdata['first_name'];
      $user->last_name = $formdata['last_name'];
      $user->email = $formdata['email'];
      $user->password = bcrypt($formdata['password']);
      $user->address = $formdata['address'];
      $user->country = $formdata['country'];
      $user->city = $formdata['city'];
      $user->mobile = $formdata['mobile'];
      $user->phone = $formdata['phone'];
      $user->role = $formdata['role'];
      $user->status = 0;
      // $user->image ="image.jpg";
      $user->save();
      //save image
      if ($request->hasFile('image')) {
        $image_tmp = $request->file('image');
        if ($image_tmp->isValid()) {
          //Get image Extension
          $extension = $image_tmp->getClientOriginalExtension();
          //Generate new Image Name
          //Hash::make($request->password),
          $imageName = rand(10000, 99999) . $user->id . '.' . $extension;
          $path = 'admin\images\users';
          if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
          }
          $imagePath = $path . '\\' . $imageName;
          //Upload the Image
     //     Image::make($image_tmp)->save($imagePath);
          $user->image = $imageName;
          $user->save();
        }
      }
      //  $user->id;
      return redirect()->back()->with('success_message', 'user has been Added!');
    }
    /*
    } catch (\Exception  $e) {
         //laravel error
        return $e->getMessage();

     // return 'error';
    }

 } catch (\Error  $e) {
         //php error
        return $e->getMessage();
     // return 'error';
    }
*/
  }
  public function addUser(User $newUser)
  {
      $newUser->save();
      return $newUser;
  }
  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($userid)
  {
    $user = DB::table('users')->find($userid);

    //
    return view('admin.user.edituser', ['user' => $user]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StoreUserRequest $request, $userid)
  {
    $formdata = $request->all();
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
      return redirect()->back()->withErrors($validator)
        ->withInput();

    } else {

      $current_photo ="";// DB::table('users')->find($userid)->image;
      //update image
      if ($request->hasFile('image')) {
        $image_tmp = $request->file('image');
        if ($image_tmp->isValid()) {
          //Get image Extension
          $extension = $image_tmp->getClientOriginalExtension();
          //Generate new Image Name
          //Hash::make($request->password),
          // return    $current_photo."not empty";
          if (empty($current_photo)) {
            //  return    $current_photo;
            //first time
            $imageName = rand(10000, 99999) . $userid . '.' . $extension;
          } else {
            //same old name
            $imageName = $current_photo;
          }

          $path = 'admin\images\users';
          if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
          }
          $imagePath = $path . '\\' . $imageName;
          //Upload the Image
         // Image::make($image_tmp)->save($imagePath);

        }
      } else {

        $imageName = $current_photo;
      }

      User::find($userid)->update([
        'name' => $formdata['name'],
        'first_name' => $formdata['first_name'],
        'last_name' => $formdata['last_name'],
        'email' => $formdata['email'],
        'address' => $formdata['address'],
        'country' => $formdata['country'],
        'city' => $formdata['city'],
        'mobile' => $formdata['mobile'],
        'phone' => $formdata['phone'],
        'role' => $formdata['role'],
        'image' => $imageName,
      ]);

      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($userid)
  {
    $user = User::find($userid);
    //delete image

    if (!empty($user->image)) {
      $imgpath = 'admin\images\users\\' . $user->image;
      if (File::exists($imgpath)) {
        File::delete($imgpath);
      }
    }
    if (!($user === null)) {
      User::find($userid)->delete();
    }
    return redirect()->route('cpanel.users.view');
    // return  $this->index();
    //   return redirect()->route('users.index');
  }
}
