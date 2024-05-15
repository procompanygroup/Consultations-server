<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
 
use App\Http\Requests\Web\Gift\StoreGiftRequest;

use App\Models\Pointtransfer;
 
use App\Models\Client;

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Web\SettingController;
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
   // $clients=$this->getclients();
    return view('admin.gift.create' );


  }

  public function store(StoreGiftRequest $request)
  {
    $formdata = $request->all();
    // return redirect()->back()->with('success_message', $formdata);
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );

    if ($validator->fails()) {
     
      return response()->json($validator);
    } else {
      $side_id=$formdata["sel_side_val"];
      $amount=$formdata["amount"];
//check allowed
 
 //$newDateTime = Carbon::now()->subDays(5);
 $is_allowed =$this->checkallowedclient($side_id);
if($is_allowed==0){

  return response()->json(["errors"=>
  ["sel_side_val"=>['غير مسموح']]
 // ["sel_side_val"=>[__('messages.amount_bigger')]]
],422);
} else{
  Gift::query()->where('client_id',$side_id)->update([       
    'is_active' =>0,
  ]);
  $newObj = new Gift;
  $newObj->client_id =$side_id;
  $newObj->free_points =$amount;
  $newObj->is_active = 1;
  $newObj->status ='available';
  $newObj->notes = '';  
        $newObj->save();
       return response()->json("ok");
        
  }
//end check allowed

    }
  }
  // public function getbyside(Request $request)
  // {
  //   if (isset ($request->sel_side)) {
  //     $side = $request->sel_side;
  //     if ($side == 'expert') {
  //       return response()->json($this->getexperts());
  //     } else if ($side == 'client') {
  //       return response()->json($this->getclients());
  //     } else {
  //       return response()->json("error",422);
  //     }
  //   } else {
  //     return response()->json("error_notexist",422);
  //   }

  // }


  public function fillclients()
  {
 //  $test=$this->checkallowedclient(12);
 //  return response()->json($test);
  return response()->json($this->allowedclients());
  }
  public function allowedclients()
  {
    $setctrlr=new SettingController();
   $days= $setctrlr->expiredays();
   $nowsub= Carbon::now()->subDays($days);
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Client::where('is_active',1)
    ->whereDoesntHave('gifts', function ($query) use ($nowsub) {
     $query->where('is_active', 1)
      ->whereDate('created_at','>',$nowsub)
     ;})
    //  ->with('gifts')
      ->select(
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

  public function clientbyid($client_id)
  {
    $setctrlr=new SettingController();
   $days= $setctrlr->expiredays();
   $nowsub= Carbon::now()->subDays($days);
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Client::where('is_active',1)
    ->whereHas('gifts', function ($query) use ($nowsub) {
     $query->where('is_active', 1)
      ->whereDate('created_at','>',$nowsub); 
       })
      ->with('gifts', function ($query) use ($nowsub) {
        $query->where('is_active', 1)
         ->whereDate('created_at','>',$nowsub)->select('id','client_id','free_points','created_at','is_active'); 
          })
      ->where('id',$client_id)
 ->select(
      'id',
      'user_name',     
      'is_active'
    )->get();
   
     return $DBList;
  }
  public function checkallowedclient($client_id)
  {  
    $DBList =$this->clientbyid($client_id);
    $is_allowed=0;
    if( $DBList->count()>0){
    }else{
      $is_allowed=1;
        }
    return $is_allowed;
    // return $List;
  }
  // public function getclients()
  // {
  //   $setctrlr=new SettingController();
  //  $days= $setctrlr->expiredays();
  //  $nowsub= Carbon::now()->subDays($days);
  //   //$newDateTime = Carbon::now()->subDays(5);
  //   $DBList = Client::where('is_active',1)->whereDoesntHave('gifts', function ($query) use ($nowsub) {
  //     $query->where('is_active', 1)->whereDate('created_at','>',$nowsub);
  //   })-> select(
  //     'id',
  //     'user_name',     
  //     'is_active'
  //   )->get();
  //   // map
  //   // $List = $DBList->map(function ($item) {

  //   //   return [
  //   //     'id' => $item->id,
  //   //     'name' => $item->user_name,
        
  //   //   ];
  //   // });
  //   //end map
  //   return  $DBList;
  //   // return $List;
  // }
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
