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
use App\Models\Expert;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PointTransferController;
use App\Http\Requests\Api\Client\GiftRequest;

class GiftExpertController extends Controller
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
   $pointtrans=Pointtransfer::with('expert')->where( 'expert_id','>',0)->where('side','to-expert')
   ->where('side','to-expert')->where('state','expert-points-gift')->where('type','p')->get();
    return view('admin.giftexpert.show',['List' => $pointtrans]);
    //return response()->json($users);
  }
  public function pulls()
  {
    $DBList = Pointtransfer::with('client', 'expert')

      ->where(function ($query) {
        $query->where('client_id', '>', 0)
          ->where('state', 'pull')
          ->where('side', 'to-client');
      })
      ->orWhere(function ($query) {
        $query->where('expert_id', '>', 0)
          ->where('side', 'to-expert')
          ->Where('state', 'balance');
      })->get();
    $List = $DBList->map(function ($item) {
      $name = '';
      $side = '';

      if ($item->client_id > 0) {
        $side = __('general.client select');

        $name = $item->client->user_name;
      } else if ($item->expert_id > 0) {
        $side = __('general.expert select');
        $name = $item->expert->full_name;
      }
      return [
        'id' => $item->id,
        'num' => $item->num,
        'side' => $side,
        'name' => $name,
        'count' => $item->count,
        'created_at' => $item->created_at
      ];
    });

    return view('admin.operation.pulls', ['transfers' => $List]);


  }
  public function create()
  {   
    $List=$this->allowedexperts();
    return view('admin.giftexpert.create',  ['List' => $List]);
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
      $side_id = $formdata["sel_side_val"];
      $amount = $formdata["amount"];
      //check allowed 
      DB::transaction(function () use ($side_id, $amount) {

          //
//add gift point transfer for client
//$pointrow = Point::find($point_id);
          $pointtransfer = new Pointtransfer();
          $pntctrlr = new PointTransferController();
          $type = 'p';
          $firstLetters = $type . 'exg-';
          $newpnum = $pntctrlr->GenerateCode($firstLetters);
          //$pointtransfer->point_id = isset ($formdata["point_id"]) ? $formdata['point_id'] : null;

          $pointtransfer->expert_id = $side_id;
          //  $pointtransfer->expert_id = $expertService->expert_id;
// $pointtransfer->service_id = $expertService->service_id;
          $pointtransfer->count = $amount;
          $pointtransfer->status = 1;
          // $pointtransfer->selectedservice_id = $newObj->id;
          $pointtransfer->side = 'to-expert';
          $pointtransfer->state = 'expert-points-gift';
          $pointtransfer->type = $type;
          $pointtransfer->num = $newpnum;
          $pointtransfer->save();
          
          $expert= Expert::find($side_id);
          $expert->points_balance+=$amount;
          $expert->cash_balance+=$amount;
       //   $expert->cash_balance_todate+=$amount;
          $expert->save();
         
        //  10
          $notctrlr = new NotificationController();
          $pointsval = $amount;
          $title = __('general.10addgift_title');
          $body = __('general.10addgift_body', ['Points' => $pointsval]);
          $notctrlr->sendautonotify($title, $body, 'auto', 'text', '','finance-gift',0,  $side_id, 0, $pointtransfer->id);

        });
        //send auto notification

        return response()->json("ok");

      
      //end check allowed

    }
  }


 
  
  public function allowedexperts()
  {
   
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Expert::where('is_active', 1)
      ->select(
        'id',
        'user_name',
        'first_name',
        'last_name',
        'is_active'
      )->get();
    // map
  
    //end map

    return $DBList;
  }

  

  

  //api
  public function getgift()
  {
    $request = request();
    $formdata = $request->all();
    $storrequest = new GiftRequest();
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator->errors());
    } else {
      $client_id = $formdata['client_id'];
      $giftArr = $this->checkavailablepoints($client_id);
      $giftamount = $giftArr['points'];
      return response()->json($giftamount);
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
