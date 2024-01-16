<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use App\Models\ValueService;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\ValueService\StoreValueServiceRequest;
use App\Http\Requests\Web\ValueService\UpdateValueServiceRequest;
class ValueServiceController extends Controller
{
    public $path = 'media/values_services';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('values_services')->get();
      return view('admin.valueservice.show', ['valueservices' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.valueservice.add');
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
       
        $newObj = new ValueService;
        $newObj->value = $formdata['value'];
        $newObj->selectedservice_id = $formdata['selectedservice_id'];
        $newObj->inputservice_id = $formdata['inputservice_id'];
       
       
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
      $object = DB::table('values_services')->find($id);
  
      //
      return view('admin.valueservice.edit', ['valueservice' => $object]);
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
        // $imagemodel = ValueService::find($id);
        // $oldimage = $imagemodel->image;
        ValueService::find($id)->update([
            'value' => $formdata['value'],
            'selectedservice_id' => $formdata['selectedservice_id'],
            'inputservice_id' => $formdata['inputservice_id'],
            
            
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = ValueService::find($id);
      if (!($object === null)) {  
          //delete object
          ValueService::find($id)->delete();
        }      
      return redirect()->route('admin.valueservice.show'); 
    }

}

