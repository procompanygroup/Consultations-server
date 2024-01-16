<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expertfavorite;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Expertfavorite\StoreExpertfavoriteRequest;
use App\Http\Requests\Web\Expertfavorite\UpdateExpertfavoriteRequest;
use App\Models\Pointtransfer;
class ExpertFavoriteController extends Controller
{
    public $path = 'media/expertsfavorites';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('expertsfavorites')->get();
      return view('admin.expertfavorite.show', ['expertsfavorites' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.expertfavorite.add');
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
       
        $newObj = new Expertfavorite;
        $newObj->client_id = $formdata['client_id'];
        $newObj->expert_id = $formdata['expert_id'];
       

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
      $object = DB::table('expertsfavorites')->find($id);
  
      //
      return view('admin.expertfavorite.edit', ['expertfavorite' => $object]);
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
        // $imagemodel = Expertfavorite::find($id);
        // $oldimage = $imagemodel->image;
        Expertfavorite::find($id)->update([
            'client_id' => $formdata['client_id'],
            'expert_id' => $formdata['expert_id'],
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Expertfavorite::find($id); 
      if (!($object === null)) {
         
         Expertfavorite::find($id)->delete();
      }
      return redirect()->route('admin.expertfavorite.show');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}

