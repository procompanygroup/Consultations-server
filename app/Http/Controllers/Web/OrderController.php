<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Reason;
use Illuminate\Http\Request;

use App\Models\Selectedservice;
use Illuminate\Support\Facades\DB; 
// use File;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;

use App\Http\Requests\Web\Order\UpdateFormStateRequest;
use App\Models\Pointtransfer;
use App\Models\Client;
//use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
// use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\PointTransferController;
class OrderController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
     $list =Selectedservice::with('expert','client','service')->orderByDesc('form_state')->get();//'order_num'
     
      return view('admin.order.show', ['selectedservices' => $list]);     
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.order.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
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
      $object =Selectedservice::with(['expert','client',       
      'valueservices' => function ($q){
        $q->orderByDesc('ispersonal');
    }
     ] )->find($id);
      $reasons=Reason::where('type', 'LIKE', '%'.'form'.'%')->get();
     //return dd($object);
      return view('admin.order.edit', ['selectedservice' => $object,'reasons'=> $reasons]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function agreemethod(Request $request, $id)
    {     
        DB::transaction(function ()use($id) {
         
          $selectedObj= Selectedservice::find($id);
          if(  $selectedObj->form_state=='wait'){
            $now= Carbon::now();
          $pointobj=Pointtransfer::where('selectedservice_id',$id)
          ->where('state','wait')
          ->where('side','from-client')->first(); 
  Selectedservice::find($id)->update([
    'form_state'=>'agree',
    'order_admin_date'=> $now,
    'order_admin_id'=>auth()->user()->id,                  
  ]);
   // change state to agree
   Pointtransfer::find($pointobj->id)->update([
    'state'=>  'agree']              
  );

  $count= $pointobj->count ;

  //add points to cash balance of company
  $comobj=Company::find(1);
  $newblnce= $comobj->point_balance+ $count;
  $newcashblnce= $comobj->cash_balance+$count;
Company::find(1)->update([
  'point_balance'=> $newblnce,
  'cash_balance'=>  $newcashblnce,//
  ]              
);
}
        });     
        return response()->json("ok");       
      
    }
    public function rejectmethod(UpdateFormStateRequest $request, $id)
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
       // $imagemodel = Expert::find($id);
       
        DB::transaction(function ()use( $formdata,$id) {
          $selectedObj= Selectedservice::find($id);
          if(  $selectedObj->form_state=='wait'){
            $now= Carbon::now();
          $pointobj=Pointtransfer::where('selectedservice_id',$id)
          ->where('state','wait')
          ->where('side','from-client')->first();
      
  //reject
  $reason=Reason::find($formdata['form_reject_reason']);
  Selectedservice::find($id)->update([
    'form_state'=> 'reject',
    'form_reject_reason'=>  $reason->content,   
    'order_admin_date'=> $now,
    'order_admin_id'=>auth()->user()->id,              
  ]);

  Pointtransfer::find($pointobj->id)->update([
    'state'=>  'reject']              
  );
 //create return transfer
$returnPoint = new Pointtransfer();
$pntctrlr=new PointTransferController();
$type='p';
$firstLetters=$type.'cl-';
$newpnum= $pntctrlr->GenerateCode($firstLetters);

$returnPoint->client_id =  $selectedObj->client_id;
$returnPoint->expert_id = $selectedObj->expert_id;
$returnPoint->service_id = $selectedObj->service_id;
$returnPoint->count = $pointobj->count;
$returnPoint->status = 1;
$returnPoint->selectedservice_id = $id;
$returnPoint->side = 'to-client';
$returnPoint->state = 'reject-return';
$returnPoint->type =$type;
$returnPoint->source_id = $pointobj->id;
$returnPoint->num =$newpnum;
$returnPoint->save();

//add point to client
$client = Client::find( $selectedObj->client_id);
$client->points_balance = $client->points_balance + $pointobj->count;
$client->save();
}
        });   
          
        return response()->json("ok");
        
     
      }


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    
      return redirect()->route('order.index');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }

}
