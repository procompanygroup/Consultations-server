<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Permission\StorePermissionRequest;
use App\Http\Requests\Web\Permission\UpdatePermissionRequest;

use Illuminate\Support\Facades\Auth;
class PermissionController extends Controller
{
    public $path = 'media/permissions';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('permissions')->get();
      return view('admin.permission.show', ['permissions' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.permission.add');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $formdata = $request->all();
      $validator = Validator::make(
        $formdata,
        $request->rules(),
        $request->messages()
      );
  
      if ($validator->fails()) {
  
        return redirect()->back()->withErrors($validator)
          ->withInput();
  
      } else {
       
        $newObj = new Permission;
        $newObj->user_id = $formdata['user_id'];
        $newObj->service_id = $formdata['service_id'];
        $newObj->allowcomment = $formdata['allowcomment'];
        $newObj->allowanswer = $formdata['allowanswer'];
        $newObj->allowsend = $formdata['allowsend'];
       
        $newObj->save();
        
  
        return redirect()->back()->with('success_message', 'user has been Added!');
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
    public function edit(string $id)
    {
      $object = DB::table('permissions')->find($id);
  
      //
      return view('admin.permission.edit', ['permission' => $object]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      $formdata = $request->all();
      //validate      
      $validator = Validator::make(
        $formdata,
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
        // $imagemodel = Permission::find($id);
        // $oldimage = $imagemodel->image;
        Permission::find($id)->update([
            'user_id' => $formdata['user_id'],
            'service_id' => $formdata['service_id'],
            'allowcomment' => $formdata['allowcomment'],
            'allowanswer' => $formdata['allowanswer'],
            'allowsend' => $formdata['allowsend'],
            
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Permission::find($id); 
      if (!($object === null)) {
  //delete object
  Permission::find($id)->delete();
      }
      return redirect()->route('admin.permission.show');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}
