<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Cashtransfer;
use Illuminate\Support\Facades\DB; 
use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Cashtransfer\StoreCashRequest;
use App\Http\Requests\Web\Cashtransfer\UpdateCashRequest;
 
class CashTransferController extends Controller
{
    public $path = 'media/cashtransfers';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('cashtransfers')->get();
      return view('admin.cashtransfer.show', ['cashtransfers' => $list]);
      //return response()->json($users);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.cashtransfer.add');
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
       
        $newObj = new Cashtransfer;
        $newObj->cash = $formdata['cash'];
        $newObj->cashtype = $formdata['cashtype'];
        $newObj->fromtype = $formdata['fromtype'];
        $newObj->totype = $formdata['totype'];
        $newObj->status = $formdata['status'];
        $newObj->client_id = $formdata['client_id'];
        $newObj->expert_id = $formdata['expert_id'];
        $newObj->pointtransfer_id = $formdata['pointtransfer_id'];
       
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
      $object = DB::table('cashtransfers')->find($id);
  
      //
      return view('admin.cashtransfer.edit', ['cashtransfer' => $object]);
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
        // $imagemodel = Cashtransfer::find($id);
        // $oldimage = $imagemodel->image;
        Cashtransfer::find($id)->update([
            'cash' => $formdata['cash'],
            'cashtype' => $formdata['cashtype'],
            'fromtype' => $formdata['fromtype'],
            'totype' => $formdata['totype'],
            'status' => $formdata['status'],
            'client_id' => $formdata['client_id'],
            'expert_id' => $formdata['expert_id'],
            'pointtransfer_id' => $formdata['pointtransfer_id'],
            
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Cashtransfer::find($id); 
      if (!($object === null)) {
       
        $item1 = Cashtransfer::where('pointtransfer_id', $id)->first();
        
        if (!($item1 === null) ) {
           // disable expert account
           /*
           Cashtransfer::find($id)->update([
            "is_active" => 0
          ]);
          */
        } else { 
  //delete object
  Cashtransfer::find($id)->delete();
  
        }
      }
      return redirect()->route('admin.point.show');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}
