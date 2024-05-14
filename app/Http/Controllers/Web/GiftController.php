<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Pointtransfer\StorePointtransferRequest;
use App\Http\Requests\Web\Pointtransfer\UpdatePointtransferRequest;
use App\Http\Requests\Web\Pointtransfer\SavePullRequest;
use App\Models\Pointtransfer;
use App\Models\Cashtransfer;
use App\Models\Client;

use App\Http\Controllers\Api\ClientController;

class GiftController extends Controller
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
//    $list = DB::table('pointstransfers')->get();
    return view('admin.gift.show'
 //    ,['pointstransfers' => $list]
    );
    //return response()->json($users);
  }
  public function pulls()
  {
    $DBList = Pointtransfer::with( 'client','expert')
       
      ->where(function ($query) {
        $query->where('client_id','>',0)
        ->where('state','pull')
              ->where('side','to-client');
    })
      ->orWhere(function ($query) {
        $query->where('expert_id','>',0)
        ->where('side','to-expert')
              ->Where('state','balance');
    })->get();
    $List = $DBList->map(function ($item) {
$name='';
$side='';

if($item->client_id>0){
  $side=__('general.client select');

  $name=$item->client->user_name ;
}else if($item->expert_id>0){
  $side=__('general.expert select');
  $name=$item->expert->full_name ;
}
      return [
        'id' => $item->id,
        'num' => $item->num,
        'side'=> $side,
        'name' =>$name,
        'count' => $item->count,
        'created_at'=>$item->created_at
      ];
    });

    return view('admin.operation.pulls', ['transfers' => $List]);


  }
  public function create()
  {
    /*
    $list = Pointtransfer::with( 'cashtransfers', 'selectedservices')
     ->where('side','to-expert')->get();      
    */
    $clients=$this->getclients();
    return view('admin.gift.create',['clients'=>$clients]);


  }

  public function store(SavePullRequest $request)
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
      $side_id=$formdata["sel_side_val"];
      $amount=$formdata["amount"];
      if($formdata["sel_side"]=='client'){
//client
$side =  Client::find($side_id);
$sidebalance=$side->points_balance;
if($amount> $sidebalance){
  return response()->json(["errors"=>
  ["amount"=>[__('messages.amount_bigger')]]
],422);
}else{
$clintctrlr=new ClientController();
$clintctrlr->clientpullbalance( $side , $amount);
}
      }
 
      return response()->json("ok");
    }



  }
  public function getbyside(Request $request)
  {
    if (isset ($request->sel_side)) {
      $side = $request->sel_side;
      if ($side == 'expert') {
        return response()->json($this->getexperts());
      } else if ($side == 'client') {
        return response()->json($this->getclients());
      } else {
        return response()->json("error",422);
      }
    } else {
      return response()->json("error_notexist",422);
    }

  }


  public function fillclients()
  {
   
    return response()->json($this->getclients());
  }
  public function getclients()
  {
    $DBList = Client::where('is_active',1)->select(
      'id',
      'user_name',
     
      'is_active'
    )->get();
    // map
    $List = $DBList->map(function ($item) {

      return [
        'id' => $item->id,
        'name' => $item->user_name,
        
      ];
    });
    //end map
    return $List;
  }
  /**
   * Show the form for creating a new resource.
   */
 

  /**
   * Store a newly created resource in storage.
   */
  

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
   
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
     
  }

}
