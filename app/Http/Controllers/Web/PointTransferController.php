<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pointtransfer;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Pointtransfer\StorePointtransferRequest;
use App\Http\Requests\Web\Pointtransfer\UpdatePointtransferRequest;
use App\Http\Requests\Web\Pointtransfer\SavePullRequest;
use App\Models\Cashtransfer;
use App\Models\Client;
use App\Models\Expert;
use App\Http\Controllers\Api\ExpertController;
use App\Http\Controllers\Api\ClientController;

class PointTransferController extends Controller
{
  public $path = 'media/pointstransfers';
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $list = DB::table('pointstransfers')->get();
    return view('admin.pointtransfer.show', ['pointstransfers' => $list]);
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
  public function createpull()
  {
    /*
    $list = Pointtransfer::with( 'cashtransfers', 'selectedservices')
     ->where('side','to-expert')->get();      
    */
    return view('admin.operation.create');


  }

  public function savepull(SavePullRequest $request)
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
      if($formdata["sel_side"]=='expert'){
        $side =  Expert::find($side_id);
        $sidebalance=$side->cash_balance;
        if($amount> $sidebalance){
          return response()->json(["errors"=>
          ["amount"=>[__('messages.amount_bigger')]]
        ],422);
        }else{
       $expctrlr=new ExpertController();
       $expctrlr->expertpullbalance( $side , $amount);
        }
         
      }else if($formdata["sel_side"]=='client'){
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

  public function getexperts()
  {
    $DBList = Expert::select(
      'id',
      'first_name',
      'last_name',
      'cash_balance',
       'cash_balance_todate'
    )->get();
    // map
    $List = $DBList->map(function ($item) {

      return [
        'id' => $item->id,
        'name' => $item->full_name,
        'balance' => $item->cash_balance,
        'cash_balance_todate' => $item->cash_balance_todate,
      ];
    });
    //end map


    return $List;
  }
  public function getclients()
  {
    $DBList = Client::select(
      'id',
      'user_name',
      'points_balance'
    )->get();
    // map
    $List = $DBList->map(function ($item) {

      return [
        'id' => $item->id,
        'name' => $item->user_name,
        'balance' => $item->points_balance,
      ];
    });
    //end map
    return $List;
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.pointtransfer.add');
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

      $newObj = new Pointtransfer;
      $newObj->point_id = $formdata['point_id'];
      $newObj->client_id = $formdata['client_id'];
      $newObj->expert_id = $formdata['expert_id'];
      $newObj->service_id = $formdata['service_id'];
      $newObj->count = $formdata['count'];
      $newObj->status = $formdata['status'];
      $newObj->selectedservice_id = $formdata['selectedservice_id'];



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
    $object = DB::table('pointstransfers')->find($id);

    //
    return view('admin.pointtransfer.edit', ['pointtransfer' => $object]);
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
      // $imagemodel = Pointtransfer::find($id);
      // $oldimage = $imagemodel->image;
      Pointtransfer::find($id)->update([
        'point_id' => $formdata['point_id'],
        'client_id' => $formdata['client_id'],
        'expert_id' => $formdata['expert_id'],
        'service_id' => $formdata['service_id'],
        'count' => $formdata['count'],
        'status' => $formdata['status'],
        'selectedservice_id' => $formdata['selectedservice_id'],

      ]);

    }
    return redirect()->back()->with('success_message', 'user has been Updated!');
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $object = Pointtransfer::find($id);
    if (!($object === null)) {

      $item1 = Cashtransfer::where('pointtransfer_id', $id)->first();

      if (!($item1 === null)) {
        // disable expert account
        /*
        Pointtransfer::find($id)->update([
         "is_active" => 0
       ]);
       */
      } else {
        //delete object
        Pointtransfer::find($id)->delete();

      }
    }
    return redirect()->route('admin.point.show');
    // return  $this->index();
    //   return redirect()->route('users.index');

  }

}
