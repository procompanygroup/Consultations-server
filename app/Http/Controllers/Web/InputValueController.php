<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\DB;
use App\Models\Inputvalue;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Inputvalue\StoreInputRequest;
use App\Http\Requests\Web\Inputvalue\UpdateInputRequest;
 
 
class InputValueController extends Controller
{
    public $path = 'media/inputvalues';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('inputvalues')->get();
      return view('admin.inputvalue.show', ['inputvalues' => $list]);
      //return response()->json($users);
  
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.inputvalue.add');
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
       
        $newObj = new Inputvalue;
        $newObj->value = $formdata['value'];
        $newObj->input_id = $formdata['input_id'];
        $newObj->is_active = $formdata['is_active'];       
       
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
      $object = DB::table('inputvalues')->find($id);
  
      //
      return view('admin.inputvalue.edit', ['inputvalue' => $object]);
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
        // $imagemodel = Inputvalue::find($id);
        // $oldimage = $imagemodel->image;
        Inputvalue::find($id)->update([
            'value' => $formdata['value'],
            'input_id' => $formdata['input_id'],
            'is_active' => $formdata['is_active'],
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Inputvalue::find($id);
      if (!($object === null)) {  
          //delete object
          Inputvalue::find($id)->delete();
        }      
      return redirect()->route('admin.inputvalue.show'); 
    }

}
