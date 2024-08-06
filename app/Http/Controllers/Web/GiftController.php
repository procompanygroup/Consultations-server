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
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PointTransferController;
use App\Http\Requests\Api\Client\GiftRequest;

class GiftController extends Controller
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $List = $this->filltableclients();
    return view(
      'admin.gift.show'
      ,
      ['List' => $List]
    );
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
    /*
    $list = Pointtransfer::with( 'cashtransfers', 'selectedservices')
     ->where('side','to-expert')->get();      
    */
    // $clients=$this->getclients();
    return view('admin.giftexpert.create');


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


      $is_allowed = $this->checkallowedclient($side_id);
      if ($is_allowed == 0) {

        return response()->json([
          "errors" =>
            ["sel_side_val" => ['غير مسموح']]
          // ["sel_side_val"=>[__('messages.amount_bigger')]]
        ], 422);
      } else {
        DB::transaction(function () use ($side_id, $amount) {

          Gift::query()->where('client_id', $side_id)->update([
            'is_active' => 0,
            'status' => 'expired',
          ]);
          $newObj = new Gift;
          $newObj->client_id = $side_id;
          $newObj->free_points = $amount;
          $newObj->orginal_points = $amount;
          $newObj->is_active = 1;
          $newObj->status = 'available';
          $newObj->notes = '';
          $newObj->save();

          //
//add gift point transfer for client
//$pointrow = Point::find($point_id);
          $pointtransfer = new Pointtransfer();
          $pntctrlr = new PointTransferController();
          $type = 'p';
          $firstLetters = $type . 'clg-';
          $newpnum = $pntctrlr->GenerateCode($firstLetters);
          //$pointtransfer->point_id = isset ($formdata["point_id"]) ? $formdata['point_id'] : null;

          $pointtransfer->client_id = $side_id;
          //  $pointtransfer->expert_id = $expertService->expert_id;
// $pointtransfer->service_id = $expertService->service_id;
          $pointtransfer->count = $amount;
          $pointtransfer->status = 1;
          // $pointtransfer->selectedservice_id = $newObj->id;
          $pointtransfer->side = 'to-client';
          $pointtransfer->state = 'points-gift';
          $pointtransfer->type = $type;
          $pointtransfer->num = $newpnum;
          $pointtransfer->gift_id = $newObj->id;
          $pointtransfer->save();
          //10
          $notctrlr = new NotificationController();
          $pointsval = $amount;
          $title = __('general.10addgift_title');
          $body = __('general.10addgift_body', ['Points' => $pointsval]);
          $notctrlr->sendautonotify($title, $body, 'auto', 'text', '', 'finance', $side_id, 0, 0, $pointtransfer->id);

        });
        //send auto notification

        return response()->json("ok");

      }
      //end check allowed

    }
  }



  public function fillclients()
  {
    // $test=$this->checkavailablepoints(10);
    //   return response()->json($test['giftmodel']->id);
    return response()->json($this->allowedclients());
  }
  public function allowedclients()
  {
    $setctrlr = new SettingController();
    $days = $setctrlr->expiredays();
    $nowsub = Carbon::now()->subDays($days);
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Client::where('is_active', 1)
      ->whereDoesntHave('gifts', function ($query) use ($nowsub) {
        $query->where('is_active', 1)
          ->whereDate('created_at', '>', $nowsub)
        ;
      })
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
    $setctrlr = new SettingController();
    $days = $setctrlr->expiredays();
    $nowsub = Carbon::now()->subDays($days);
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Client::where('is_active', 1)
      ->whereHas('gifts', function ($query) use ($nowsub) {
        $query->where('is_active', 1)
          ->whereDate('created_at', '>', $nowsub);
      })
      ->with('gifts', function ($query) use ($nowsub) {
        $query->where('is_active', 1)
          ->whereDate('created_at', '>', $nowsub)->select('id', 'client_id', 'free_points', 'created_at', 'is_active', 'orginal_points');
      })
      ->where('id', $client_id)
      ->select(
        'id',
        'user_name',
        'is_active'
      )->get();

    return $DBList;
  }
  public function checkallowedclient($client_id)
  {
    $DBList = $this->clientbyid($client_id);
    $is_allowed = 0;
    if ($DBList->count() > 0) {
    } else {
      $is_allowed = 1;
    }
    return $is_allowed;
    // return $List;
  }
  public function checkavailablepoints($client_id)
  {
    $DBList = $this->clientbyid($client_id);

    $res =
      [
        'points' => 0,
        'giftmodel' => new Gift(),
      ];
    if ($DBList->count() > 0) {

      $pointsrow = $DBList->first()->gifts->first();
      $res =
        [
          'points' => $pointsrow->free_points,
          'giftmodel' => $pointsrow,
        ];
    }
    return $res;
    // return $List;
  }

  public function filltableclients()
  {
    $setctrlr = new SettingController();
    $days = $setctrlr->expiredays();
    $nowsub = Carbon::now()->subDays($days);
    //$newDateTime = Carbon::now()->subDays(5);
    $DBList = Gift::with([
      'client' => function ($query) {
        $query->where('is_active', 1)
          ->select('id', 'user_name', 'mobile', 'points_balance', 'is_active', );
      }
    ])->select(
        'id',
        'client_id',
        'free_points',
        'is_active',
        'status',
        'notes',
        'orginal_points',
        'created_at',
      )->get();
    $setctrlr = new SettingController();
    $days = $setctrlr->expiredays();
    // $nowsub= Carbon::now()->subDays($days);
    $nowsub = Carbon::now()->subDays($days)->toDateString();
    // map
    $List = $DBList->map(function ($item) use ($nowsub) {
      $create_date = $item->created_at->format('Y-m-d');
      $status = '';
      if ($item->is_active == 0) {
        $status = 'منتهية';
      } else {
        if (Carbon::parse($create_date)->greaterThan($nowsub)) {
          $status = 'متاحة';
        } else {
          $status = 'منتهية';
        }
      }
      return [
        'id' => $item->id,
        'client_id' => $item->client_id,
        'user_name' => $item->client->user_name,
        'orginal_points' => $item->orginal_points,
        'created_at' => $create_date,
        'status' => $status,
        //  'is_active'=>$item->is_active,
        //   'now'=>$nowsub,
      ];
    });
    //end map

    return $List;
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
