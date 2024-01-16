<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicefavorite;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Servicefavorite\StoreServicefavoriteRequest;
use App\Http\Requests\Web\Servicefavorite\UpdateServicefavoriteRequest;
use App\Models\Pointtransfer;
class ServiceFavoriteController extends Controller
{
    public $path = 'media/servicesfavorites';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('servicesfavorites')->get();
      return view('admin.servicefavorite.show', ['servicesfavorites' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.servicefavorite.add');
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
       
        $newObj = new Servicefavorite;
        $newObj->client_id = $formdata['client_id'];
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
      $object = DB::table('servicesfavorites')->find($id);
  
      //
      return view('admin.servicefavorite.edit', ['servicefavorite' => $object]);
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
        // $imagemodel = Servicefavorite::find($id);
        // $oldimage = $imagemodel->image;
        Servicefavorite::find($id)->update([
            'client_id' => $formdata['client_id'],
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
      $object = Servicefavorite::find($id); 
      if (!($object === null)) {
         
         Servicefavorite::find($id)->delete();
      }
      return redirect()->route('admin.servicefavorite.show');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}
