<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Reason;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Reason\StoreReasonRequest;
use App\Http\Requests\Web\Reason\UpdateReasonRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ReasonController extends Controller
{
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Reason::orderBy('type')->get();
        return view('admin.reason.show', ['reasons' => $list]);
        //return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reason.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReasonRequest $request)//
    {
      $formdata = $request->all();
   
      // return redirect()->back()->with('success_message', $formdata);
      $validator = Validator::make(
        $formdata,
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
      } else {
        $newObj = new Reason;
        $newObj->content = $formdata['content'];   
       $type= implode(",", $formdata['deptype']);      
        $newObj->type =  $type;       
        $newObj->is_active = 1;
      
        $newObj->save();
    //$boolres= Str::contains( $type,'form') ;
     
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
        $object = Reason::find($id);
        //
        return view('admin.reason.edit', ['reason' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReasonRequest $request, $id)
    {
      $formdata = $request->all();
      //validate
      $validator = Validator::make(
        $formdata,
        $request->rules(),
        $request->messages()
      );
      if ($validator->fails()) {
       
    return response()->json($validator);
  
      } else {
        $type= implode(",", $formdata['deptype']);  
        Reason::find($id)->update([
          'content'=>  $formdata['content'],
          'type'=>  $type,              
        ]);
      
        //save image
        return response()->json("ok");
        
      }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $object = Reason::find($id);
        if (!($object === null)) {
            //delete object
            Reason::find($id)->delete();
        }
        return redirect()->route('reason.index');
        // return  $this->index();
        //   return redirect()->route('users.index');

    }

}
