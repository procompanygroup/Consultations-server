<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
 
use Illuminate\Support\Facades\DB;
use App\Models\Selectedservice;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Selectedservice\StoreSelectedRequest;
use App\Http\Requests\Web\Selectedservice\UpdateSelectedRequest;
use App\Models\ValueService;
use App\Models\Pointtransfer;
class SelectedServiceController extends Controller
{
    public $path = 'media/selectedservices';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('selectedservices')->get();
      return view('admin.selectedservice.show', ['selectedservices' => $list]);
      //return response()->json($users);
  
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.selectedservice.add');
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
       
        $newObj = new Selectedservice;
        $newObj->client_id = $formdata['client_id'];
 $newObj->expert_id = $formdata['expert_id'];
 $newObj->service_id = $formdata['service_id'];
 $newObj->points = $formdata['points'];
 $newObj->rate = $formdata['rate'];
 $newObj->answer = $formdata['answer'];
 $newObj->answer2 = $formdata['answer2'];
 $newObj->comment = $formdata['comment'];
 $newObj->iscommentconfirmd = $formdata['iscommentconfirmd'];
 $newObj->issendconfirmd = $formdata['issendconfirmd'];
 $newObj->isanswerconfirmd = $formdata['isanswerconfirmd'];
 
 $newObj->status = $formdata['status'];
 $newObj->comment_rate = $formdata['comment_rate'];

       
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
      $object = DB::table('selectedservices')->find($id);
  
      //
      return view('admin.selectedservice.edit', ['selectedservice' => $object]);
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
        // $imagemodel = Selectedservice::find($id);
        // $oldimage = $imagemodel->image;
        Selectedservice::find($id)->update([
            'client_id' => $formdata['client_id'],
            'expert_id' => $formdata['expert_id'],
            'service_id' => $formdata['service_id'],
            'points' => $formdata['points'],
            'rate' => $formdata['rate'],
            'answer' => $formdata['answer'],
            'answer2' => $formdata['answer2'],
            'comment' => $formdata['comment'],
            'iscommentconfirmd' => $formdata['iscommentconfirmd'],
            'issendconfirmd' => $formdata['issendconfirmd'],
            'isanswerconfirmd' => $formdata['isanswerconfirmd'],
      
            'status' => $formdata['status'],
            'comment_rate' => $formdata['comment_rate'],
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Selectedservice::find($id);
      if (!($object === null)) { 
        ValueService::where('selectedservice_id', $id)->delete();
       Pointtransfer::where('selectedservice_id', $id)->delete();
          //delete object
          Selectedservice::find($id)->delete();
        }      
      return redirect()->route('admin.selectedservice.show'); 
    }

}
