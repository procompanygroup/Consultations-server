<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpertService;
use Illuminate\Support\Facades\DB;
 
use File;
use Illuminate\Support\Facades\Validator;
 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\ExpertService\StoreExpertServiceRequest;
use App\Http\Requests\Web\ExpertService\UpdateExpertServiceRequest;
 
class ExpertsServiceController extends Controller
{
    public $path = 'media/expertservices';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('expertservices')->get();
      return view('admin.expertservice.show', ['expertservices' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.expertservice.add');
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
       
        $newObj = new ExpertService;
        $newObj->expert_id = $formdata['expert_id'];
 $newObj->service_id = $formdata['service_id'];
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
      $object = DB::table('expertservices')->find($id);
  
      //
      return view('admin.expertservice.edit', ['expertservice' => $object]);
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
        // $imagemodel = ExpertService::find($id);
        // $oldimage = $imagemodel->image;
        ExpertService::find($id)->update([
            'expert_id' => $formdata['expert_id'],
            'service_id' => $formdata['service_id'],
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = ExpertService::find($id);
      if (!($object === null)) {  
          //delete object
          ExpertService::find($id)->delete();
        }      
      return redirect()->route('admin.expertservice.show'); 
    }

}

