<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use App\Models\InputService;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\InputService\StoreInputServiceRequest;
use App\Http\Requests\Web\InputService\UpdateInputServiceRequest;
class InputServiceController extends Controller
{
    public $path = 'media/inputs_services';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('inputs_services')->get();
      return view('admin.inputservice.show', ['inputservices' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.inputservice.add');
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
       
        $newObj = new InputService;
        $newObj->service_id = $formdata['service_id'];
        $newObj->input_id = $formdata['input_id'];
       
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
      $object = DB::table('inputs_services')->find($id);
  
      //
      return view('admin.inputservice.edit', ['inputservice' => $object]);
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
        // $imagemodel = InputService::find($id);
        // $oldimage = $imagemodel->image;
        InputService::find($id)->update([
            'service_id' => $formdata['service_id'],
            'input_id' => $formdata['input_id'],
            
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = InputService::find($id);
      if (!($object === null)) {  
          //delete object
          InputService::find($id)->delete();
        }      
      return redirect()->route('admin.inputservice.show'); 
    }

}
