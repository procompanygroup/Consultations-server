<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Point\StorePointRequest;
use App\Http\Requests\Web\Point\UpdatePointRequest;
use App\Models\Pointtransfer;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class PointController extends Controller
{
  public $path = 'images/points';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('points')->get();
      return view('admin.point.show', ['points' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.point.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointRequest $request)
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
        $newObj = new Point;
        $newObj->count = $formdata['count'];
        $newObj->price = $formdata['price'];
        $newObj->pricebefor =  $formdata['price'];
        $newObj->countbefor =  $formdata['count'];     
        $newObj->is_active = isset($formdata["is_active"]) ? 1 : 0;
        //$newObj->token = $formdata['token'];
        $newObj->save();
  /*
        if ($request->hasFile('image')) {
          $file = $request->file('image');
          // $filename= $file->getClientOriginalName();               
          $this->storeImage($file, $newObj->id);
          //  $this->storeImage( $file,2);
        }
  */
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
    public function edit(string $id)
    {
    //  $url =url(Storage::url($this->path)).'/';
      $object = Point::find($id);
       /*
      if( $object->image !="" ){
        $object->fullpathimg= $url.$object->image;
      }
      */
      
      return view('admin.point.edit', ['point' => $object]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointRequest $request, $id)
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
       // $imagemodel = Expert::find($id);
       /*
        if ($request->hasFile('image')) {
          $file= $request->file('image');
                 // $filename= $file->getClientOriginalName();                
       $this->storeImage( $file,$id);
         }
         */ 
        Point::find($id)->update([
          'count'=>  $formdata['count'],
          'price'=>  $formdata['price'],
          'pricebefor' => $formdata['price'],    
          'countbefor' => $formdata['count'],            
        'is_active' => isset($formdata['is_active']) ? 1 : 0         
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
      $object = Point::find($id); 
      if (!($object === null)) {
  
       
        $item1 = Pointtransfer::where('point_id', $id)->first();
        
        if (!($item1 === null) ) {
           // disable expert account
           Point::find($id)->update([
            "is_active" => 0
          ]);
        } else { 
  //delete object
  Point::find($id)->delete();
  
        }
      }
      return redirect()->route('admin.point.show');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}
