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
use Illuminate\Support\Facades\Auth;
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
      return view('admin.point.add');
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
       
        $newObj = new Point;
        $newObj->count = $formdata['count'];
 $newObj->price = $formdata['price'];
 $newObj->pricebefor = $formdata['pricebefor'];
 $newObj->countbefor = $formdata['countbefor'];
 $newObj->createuser_id =Auth::user()->id;
 $newObj->updateuser_id = Auth::user()->id;
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
      $object = DB::table('points')->find($id);
  
      //
      return view('admin.point.edit', ['point' => $object]);
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
        // $imagemodel = Point::find($id);
        // $oldimage = $imagemodel->image;
        Point::find($id)->update([
            'count' => $formdata['count'],
            'price' => $formdata['price'],
            'pricebefor' => $formdata['pricebefor'],
            'countbefor' => $formdata['countbefor'],
           // 'createuser_id' => Auth::user()->id,
            'updateuser_id' =>Auth::user()->id,
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
