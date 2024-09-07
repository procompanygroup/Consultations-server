<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationUser;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Models\User;
use App\Models\Expert;
use App\Models\Client;
use App\Http\Controllers\Api\StorageController;
use App\Http\Requests\Web\Notify\StoreNotifyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\Api\Client\NotifyListRequest;
use App\Http\Requests\Api\Client\SetToReadRequest;
use App\Http\Requests\Api\Client\NotifyByIdRequest;

//use Notification;
use App\Models\Notification;

class NotificationController extends Controller
{
  public $oldestday = 30;

  public function saveToken(Request $request)
  {
    //  print_r($request->all());
    auth()->user()->update(['token' => $request->token]);
    return response()->json(['Token Saved!']);
  }
  public function sendNotification(Request $request)
  {
    $strgCtrlr = new StorageController();
    $defaultimg = $strgCtrlr->DefaultPath('image');
    $defaultsvg = $strgCtrlr->DefaultPath('icon');

    $tokenList = User::whereNotNull('token')->pluck('token')->all();
    return Larafirebase::withTitle($request->title)
      ->withBody($request->body)
      ->withImage($defaultimg)
      ->withIcon($defaultsvg)
      ->withSound('default')
      ->withClickAction('https://www.google.com')
      ->withPriority('high')
      ->withAdditionalData([
        'color' => '#000000',
        'badge' => 0,
        'username' => "Ahmad",
        'image' => $defaultimg,
      ])
      //  ->sendNotification($tokenList);
      ->sendMessage($tokenList);

  }
  public function sendbytoken(Request $request)
  {
  
  }

  // public function sendbytoken(Request $request)
  // {
  //   $strgCtrlr = new StorageController();
  //   $defaultimg = $strgCtrlr->DefaultPath('image');
  //   $defaultsvg = $strgCtrlr->DefaultPath('icon');
  //   $formdata = $request->all();
  //   $token = "";
  //   if (isset($formdata['input_token'])) {
  //     $token = $formdata['input_token'];

  //     $tokenList = [$token];

  //     //   return    Larafirebase::withTitle($request->title)
  //     //     ->withBody($request->body)
  //     //  //   ->withImage($defaultimg)
  //     //   //  ->withIcon($defaultsvg)
  //     //     ->withSound('default')
  //     //   //  ->withClickAction('https://www.google.com')
  //     //     ->withPriority('high')
  //     //     ->withAdditionalData([
  //     //       'id' =>19,
  //     //      // 'image' => $defaultimg,
  //     //     ])
  //     //     ->sendMessage($tokenList);
  //     //     ->sendNotification($tokenList);
  //     return Larafirebase::withTitle($request->title)
  //       ->withBody($request->body)
  //       //   ->withImage($defaultimg)
  //       //  ->withIcon($defaultsvg)
  //       ->withSound('default')
  //       //  ->withClickAction('https://www.google.com')
  //       ->withPriority('high')
  //       // ->withAdditionalData([        //  'id' => "19",
  //       // 'image' => $defaultimg,
  //       //  ])
  //       ->sendMessage($tokenList);
  //     //  ->sendNotification($tokenList);
  //   } else {
  //     return 'empty token';
  //   }


  //   //  ->sendNotification($tokenList);
  // }


  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $nowsub = Carbon::now()->subDays($this->oldestday);
    $List = Notification::
       where(function ($query) {
        $query->where('side', 'LIKE', '%' . 'client' . '%')
            ->orWhere('side', 'LIKE', '%' . 'expert' . '%');
    })->whereDate('created_at', '>=', $nowsub)->get();
    return view('admin.notify.show', ['list' => $List]);
  }
  public function testnotify()
  {
    return view('admin.notify.test');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.notify.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreNotifyRequest $request)//from panel
  {
    $formdata = $request->all();
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);
    } else {
      $newObj = new Notification;
      $newObj->title = $formdata['title'];
      $newObj->body = isset($formdata['body']) ? $formdata['body'] : '';
      $side = implode(",", $formdata['side']);
      $newObj->side = $side;
      $newObj->type = $formdata['type'];
      $newObj->selectedservice_id = 0;
      $newObj->pointtransfer_id = 0;
      //   $newObj->is_active = 1;      
      $newObj->save();
      if ($request->hasFile('image')) {
        $file = $request->file('image');
        $this->storeImage($file, $newObj->id, $formdata['type']);
      }
      //create rows in noti user table 
      $notification_id = $newObj->id;
      //expert
      if (Str::contains($side, 'expert')) {
        $expertids = Expert::where('is_active', 1)->select('id')->get();
        $now = Carbon::now();
        $insertList = $expertids->map(function ($notifyuser) use ($notification_id, $now) {
          return [
            'expert_id' => $notifyuser->id,
            'notification_id' => $notification_id,
            'isread' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'state' => 'sent',
          ];
        });
        NotificationUser::insert($insertList->toArray());
      }
      //client
      if (Str::contains($side, 'client')) {
        $clientids = Client::where('is_active', 1)->select('id')->get();
        $now = Carbon::now();
        $insertList = $clientids->map(function ($notifyuser) use ($notification_id, $now) {
          return [
            'client_id' => $notifyuser->id,
            'notification_id' => $notification_id,
            'isread' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'state' => 'sent',
          ];
        });

        NotificationUser::insert($insertList->toArray());
      }
      //send firebase notify

      if (Str::contains($side, 'expert')) {
        //  $experttokenList = Expert::where('is_active', 1)->whereNotNull('token')->pluck('token')->all();

        //   $list= $this->clienttokenwithid( $notify);
        $experttokenList = $this->experttokenwithid($newObj);
        $this->send_fire_notify_from_panel($newObj, $experttokenList);
      }
      if (Str::contains($side, 'client')) {
        //   $clienttokenList = User::where('is_active', 1)->whereNotNull('token')->pluck('token')->all();
        $clienttokenList = $this->clienttokenwithid($newObj);

        $this->send_fire_notify_from_panel($newObj, $clienttokenList);
      }    //$boolres= Str::contains( $type,'form') ;     
      return response()->json("ok");

    }
  }

  /**
   * Display the specified resource.
   */
  public function show()
  {
  }
  public function clienttokenwithid(Notification $notify)
  {
    $id = $notify->id;

    $list = NotificationUser::where('notification_id', $id)->
      whereHas('client', function ($query) {
        $query->whereNotNull('token')->whereNot('token', '')->where('is_active', 1);
      })->with('client:id,is_active,token')->select('id', 'notification_id', 'client_id', 'expert_id')->get();
    $sendlist = $this->mapclienttoken($list);
    return $sendlist;
  }
  public function experttokenwithid(Notification $notify)
  {
    $id = $notify->id;
    $list = NotificationUser::where('notification_id', $id)->
      whereHas('expert', function ($query) use ($id) {
        $query->whereNotNull('token')->whereNot('token', '')->where('is_active', 1);
      })->with('expert:id,is_active,token')->select('id', 'notification_id', 'client_id', 'expert_id', )->get();
    $sendlist = $this->mapexperttoken($list);
    return $sendlist;
  }
  public function mapclienttoken($NotificationUserList)
  {
    $list = $NotificationUserList->map(function ($notifyuser) {

      return [
        'id' => $notifyuser->id,
        'token' => $notifyuser->client->token,
      ];
    });
    return $list;
  }
  public function mapexperttoken($NotificationUserList)
  {
    $list = $NotificationUserList->map(function ($notifyuser) {

      return [
        'id' => $notifyuser->id,
        'token' => $notifyuser->expert->token,
      ];
    });
    return $list;
  }
  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $item = Notification::find($id);
    return view('admin.notify.edit', ['item' => $item]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
  public function storeImage($file, $id, $type)
  {
    $imagemodel = Notification::find($id);
    $strgCtrlr = new StorageController();
    if ($type == 'image') {
      $path = $strgCtrlr->path['notify'];
    } else {
      //vedio
      $path = $strgCtrlr->videopath['notify'];
    }

    $oldimage = $imagemodel->data;
    $oldimagename = basename($oldimage);
    //  $oldimagepath = $path . '/' . $oldimagename;
    //save photo

    if ($file !== null) {
      //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
      $ext = $file->getClientOriginalExtension();
      //  $filename =  $imagemodel->code . $id . ".webp";
      $filename = rand(10000, 99999) . $id . '.' . $ext;
      /*
      $manager = new ImageManager(new Driver());
      $image = $manager->read($file);
      $image = $image->toWebp(75);
      */
      Storage::delete("public/" . $path . '/' . $oldimagename);
      /*
              if (!File::isDirectory(Storage::url('/' .$path))) {
                Storage::makeDirectory('public/' . $path);
              }
              */
      //  $image->save(storage_path('app/public') . '/' . $path . '/' . $filename);
      $path = $file->storeAs($path, $filename, 'public');
      //   $url = url('storage/app/public' . '/' . $path . '/' . $filename);
      Notification::find($id)->update([
        "data" => $filename,
        "type" => $type,
      ]);
      //  Storage::delete("public/" .$path . '/' . $oldimagename);
    }
    return 1;
  }

  public function sendautonotify(
    $title,
    $body,
    $side,
    $type,
    $data,
    $notes,
    $client_id,
    $expert_id,
    $selectedservice_id,
    $pointtransfer_id

  ) {
    $newObj = new Notification;
    $newObj->title = $title;
    $newObj->body = $body;
    $newObj->side = $side;
    $newObj->type = $type;
    $newObj->data = '';
    $newObj->notes = $notes;
    $newObj->selectedservice_id = $selectedservice_id;
    $newObj->pointtransfer_id = $pointtransfer_id;
    $newObj->save();

    //create rows in noti user table 
    $notification_id = $newObj->id;

    $notifyuser = new NotificationUser();

    $now = Carbon::now();
    $notifyuser->client_id = $client_id;
    $notifyuser->expert_id = $expert_id;
    $notifyuser->notification_id = $notification_id;
    $notifyuser->isread = 0;
    $notifyuser->state = 'sent';
    $notifyuser->notes = '';
    $notifyuser->created_at = $now;
    $notifyuser->updated_at = $now;
    $notifyuser->save();
    //send firebase notify
    $res = $this->sendfirenotify($newObj, $notifyuser);

    return ("1");

  }
  public function sendfirenotify(Notification $notify, NotificationUser $notifyuser)
  {
    //auto
    //  $strgCtrlr = new StorageController();
    //$defaultimg = $strgCtrlr->DefaultPath('image');
    //$defaultsvg = $strgCtrlr->DefaultPath('icon');
    //$token = "";
    if ($notifyuser->expert_id > 0) {
      $expert = Expert::find($notifyuser->expert_id);
      if ($expert) {
        if ($expert->is_active == 1 && (!is_null($expert->token) && $expert->token != '')) {
          $tokenList = [$expert->token];

          $res = Larafirebase::withTitle($notify->title)
            ->withBody($notify->body)
            // ->withImage($defaultimg)
            //  ->withIcon($defaultsvg)
            ->withSound('default')
            // ->withClickAction('https://www.google.com')
            ->withPriority('high')
            ->withAdditionalData([
              // 'date'=>$notifyuser->created_at,
              'id' => $notifyuser->id,
              // 'image' => $defaultimg,
            ])
            ->sendMessage($tokenList);
          return $res;
          //   return Larafirebase::withTitle($notify->title)
          //   ->withBody($notify->body)
          //  // ->withImage($defaultimg)
          // //  ->withIcon($defaultsvg)
          //   ->withSound('default')
          //   // ->withClickAction('https://www.google.com')
          //   ->withPriority('high')
          //   ->withAdditionalData([
          //     // 'date'=>$notifyuser->created_at,
          //     'id'=> $notifyuser->id,
          //    // 'image' => $defaultimg,
          //   ])
          //   ->sendNotification($tokenList);

        } else {
          return 'empty token';
        }
      } else {
        return 'empty token';
      }
    } else if ($notifyuser->client_id > 0) {
      $client = Client::find($notifyuser->client_id);
      if ($client) {
        if ($client->is_active == 1 && (!is_null($client->token) && $client->token != '')) {

          $tokenList = [$client->token];
          $res = Larafirebase::withTitle($notify->title)
            ->withBody($notify->body)
            // ->withImage($defaultimg)
            // ->withIcon($defaultsvg)
            ->withSound('default')
            // ->withClickAction('https://www.google.com')
            ->withPriority('high')
            ->withAdditionalData([
              // 'date'=>$notifyuser->created_at,
              'id' => $notifyuser->id,
              //  'image' => $defaultimg,
            ])
            ->sendMessage($tokenList);
          return $res;
          // return Larafirebase::withTitle($notify->title)
          //   ->withBody($notify->body)
          //  // ->withImage($defaultimg)
          //  // ->withIcon($defaultsvg)
          //   ->withSound('default')
          //   // ->withClickAction('https://www.google.com')
          //   ->withPriority('high')
          //   ->withAdditionalData([
          //     // 'date'=>$notifyuser->created_at,
          //     'id'=> $notifyuser->id,
          //   //  'image' => $defaultimg,
          //   ])
          //   ->sendNotification($tokenList);

        } else {
          return 'empty token';
        }
      } else {
        return 'empty token';
      }
    } else {
      return 'empty';
    }
  }
  public function send_fire_notify_from_panel(Notification $notify, $tokenList)
  {
    //   $strgCtrlr = new StorageController();
    // $defaultimg = $strgCtrlr->DefaultPath('image');
    //   $defaultsvg = $strgCtrlr->DefaultPath('icon');

    $res = "";
    if ($tokenList) {
      foreach ($tokenList as $tokenrow) {
        $tokenarr = [$tokenrow['token']];
        $res = Larafirebase::withTitle($notify->title)
          ->withBody($notify->body)
          ->withSound('default')
          ->withPriority('high')
          ->withAdditionalData([
            'id' => $tokenrow['id'],
          ])
          ->sendMessage($tokenarr);

        // $res=Larafirebase::withTitle($notify->title)
        // ->withBody($notify->body)    
        // ->withSound('default')     
        // ->withPriority('high')
        // ->withAdditionalData([
        //  'id'=> $tokenrow['id'],         
        // ])
        // ->sendNotification($tokenarr);

      }
      return $res;
    } else {
      return 'empty token';
    }
  }

  //get

  public function getclientnotifylist()
  {
    $authuser = auth()->user();
    $request = request();

    $formdata = $request->all();
    //client_id
//points
    $storrequest = new NotifyListRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
      //   return redirect()->back()->withErrors($validator)->withInput();

    } else {
      $client_id = $formdata['id'];
      $nowsub = Carbon::now()->subDays($this->oldestday);
      $Dblist = Notification::wherehas('notificationUsers', function ($query) use ($client_id) {
        $query->where('client_id', $client_id);
      })->whereDate('created_at', '>=', $nowsub)
      ->with(
          [
            'notificationUsers' => function ($q) use ($client_id) {
              $q->where('client_id', $client_id)
                ->select('id', 'notification_id', 'client_id', 'expert_id', 'isread', 'read_at', 'created_at');
            }
          ]
        )->select(
          'id',
          'title',
          'body',
          'type',
          'side',
          'data',
          'read_at',
          'created_at',
          'notes',
          'selectedservice_id',
        )->orderByDesc('created_at')->get();
      $list = $this->mapnotifylist($Dblist);
      return response()->json($list);
    }
  }

  public function getnotifybyid()
  {
    //client
    $request = request();
    $formdata = $request->all();
    //client_id
//points
    $storrequest = new NotifyByIdRequest();//php artisan make:request Api/Expertfavorite/StoreRequest
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
      //   return redirect()->back()->withErrors($validator)->withInput();

    } else {
      $notify_users_id = $formdata['id'];

      $Dblist = Notification::wherehas('notificationUsers', function ($query) use ($notify_users_id) {
        $query->where('id', $notify_users_id);
      })->with(
          [
            'notificationUsers' => function ($q) use ($notify_users_id) {
              $q->where('id', $notify_users_id)
                ->select('id', 'notification_id', 'client_id', 'expert_id', 'isread', 'read_at', 'created_at');
            }
          ]
        )->select(
          'id',
          'title',
          'body',
          'type',
          'side',
          'data',
          'read_at',
          'created_at',
          'notes',
          'selectedservice_id',
        )->orderByDesc('created_at')->get();
      $list = $this->mapnotifylist($Dblist)->first();
      return response()->json($list);
    }
  }
  public function mapnotifylist($Dblist)
  {
    $list = $Dblist->map(function ($notify) {
      $readat = $notify->notificationUsers->first()->read_at;
      return [
        'id' => $notify->notificationUsers->first()->id,
        'notification_id' => $notify->id,
        'title' => $notify->title,
        'body' => $notify->body,
        'type' => $notify->type,
        'side' => $notify->side,
        'selectedservice_id' => $notify->selectedservice_id,
        'client_id' => $notify->notificationUsers->first()->client_id,
        'isread' => $notify->notificationUsers->first()->isread,
        'read_at' => is_null($readat) ? '' : $readat,
        'created_at' => $notify->notificationUsers->first()->created_at,
        'path' => $notify->path_conv,
        'data'=>json_decode($notify->data),
      ];
    });
    return $list;
  }

  public function getexpertnotifylist()
  {

    $authuser = auth()->user();
    $request = request();

    $formdata = $request->all();
    //client_id
//points
    $storrequest = new NotifyListRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
      //   return redirect()->back()->withErrors($validator)->withInput();

    } else {

      $expert_id = $formdata['id'];
   $nowsub = Carbon::now()->subDays($this->oldestday);
      $Dblist = Notification::wherehas('notificationUsers', function ($query) use ($expert_id) {
        $query->where('expert_id', $expert_id);
      })->with(
          [
            'notificationUsers' => function ($q) use ($expert_id) {
              $q->where('expert_id', $expert_id)
                ->select('id', 'notification_id', 'client_id', 'expert_id', 'isread', 'read_at', 'created_at');
            }
          ]
        ) ->whereDate('created_at', '>=', $nowsub)
        ->select(
          'id',
          'title',
          'body',
          'type',
          'side',
          'data',
          'read_at',
          'created_at',
          'notes',
          'selectedservice_id',
        )->orderByDesc('created_at')->get();
      $list = $this->mapnotifylist($Dblist);
      return response()->json($list);


    }
  }

  public function getexpertnotifybyid()
  {

    $request = request();

    $formdata = $request->all();
    //client_id
//points
    $storrequest = new NotifyByIdRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
      //   return redirect()->back()->withErrors($validator)->withInput();

    } else {
      $notify_users_id = $formdata['id'];

      $Dblist = Notification::wherehas('notificationUsers', function ($query) use ($notify_users_id) {
        $query->where('id', $notify_users_id);
      })->with(
          [
            'notificationUsers' => function ($q) use ($notify_users_id) {
              $q->where('id', $notify_users_id)
                ->select('id', 'notification_id', 'client_id', 'expert_id', 'isread', 'read_at', 'created_at');
            }
          ]
        )->select(
          'id',
          'title',
          'body',
          'type',
          'side',
          'data',
          'read_at',
          'created_at',
          'notes',
          'selectedservice_id',
        )->orderByDesc('created_at')->get();
      $list = $this->mapnotifylist($Dblist)->first();
      return response()->json($list);
    }
  }
  public function mapexpertnotifylist($Dblist)
  {
    $list = $Dblist->map(function ($notify) {
      $readat = $notify->notificationUsers->first()->read_at;
      return [
        'id' => $notify->notificationUsers->first()->id,
        'notification_id' => $notify->id,
        'title' => $notify->title,
        'body' => $notify->body,
        'type' => $notify->type,
        'order_type' => $notify->notes,
        'side' => $notify->side,
        'selectedservice_id' => $notify->selectedservice_id,
        'client_id' => $notify->notificationUsers->first()->client_id,
        'expert_id' => $notify->notificationUsers->first()->expert_id,
        'isread' => $notify->notificationUsers->first()->isread,
        'read_at' => is_null($readat) ? '' : $readat,
        'created_at' => $notify->notificationUsers->first()->created_at,
        'path' => $notify->path_conv,
      ];
    });
    return $list;
  }
  public function settoread()
  {
    $request = request();
    $formdata = $request->all();
    $storrequest = new SetToReadRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator->errors());
    } else {

      $Notifyuser = NotificationUser::find($formdata['id']);
      if (auth()->user()->id == $Notifyuser->client_id) {
        $Notifyuser->isread = 1;
        $Notifyuser->read_at = Carbon::now();
        $Notifyuser->save();
        return response()->json("ok");
      } else {
        return response()->json(['error' => 'Unauthenticated'], 401);
      }
    }
  }
  public function settoreadexpert()
  {
    $request = request();
    $formdata = $request->all();
    $storrequest = new SetToReadRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator->errors());
    } else {

      $Notifyuser = NotificationUser::find($formdata['id']);
      if (auth()->user()->id == $Notifyuser->expert_id) {
        $Notifyuser->isread = 1;
        $Notifyuser->read_at = Carbon::now();
        $Notifyuser->save();
        return response()->json("ok");
      } else {
        return response()->json(['error' => 'Unauthenticated'], 401);
      }
    }
  }
  public function send_autocall_notify(
    $title,
    $body,
    $side,
    $type,
    $data,
    $notes,
    $client_id,
    $expert_id,
    $selectedservice_id,
    $pointtransfer_id,
    $calldata,
  ) {
    $newObj = new Notification;
    $newObj->title = $title;
    $newObj->body = $body;
    $newObj->side = $side;
    $newObj->type = $type;
    $newObj->data = '';
    $newObj->notes = $notes;
    $newObj->selectedservice_id = $selectedservice_id;
    $newObj->pointtransfer_id = $pointtransfer_id;
 
    $newObj->save();

    //create rows in noti user table 
    $notification_id = $newObj->id;

    $notifyuser = new NotificationUser();

    $now = Carbon::now();
    $notifyuser->client_id = $client_id;
    $notifyuser->expert_id = $expert_id;
    $notifyuser->notification_id = $notification_id;
    $notifyuser->isread = 0;
    $notifyuser->state = 'sent';
    $notifyuser->notes = '';
    $notifyuser->created_at = $now;
    $notifyuser->updated_at = $now;
    $notifyuser->save();
    //save call data array
    $calldata['id']=$notifyuser->id;
    $newObj->data=json_encode($calldata); 
    $newObj->save();
    //send firebase notify
    $res = $this->sendfirecall($newObj, $notifyuser, $calldata);

    return ("1");

  }
  public function sendfirecall(Notification $notify, NotificationUser $notifyuser, $data)
  {
    //auto
    //  $strgCtrlr = new StorageController();
    //$defaultimg = $strgCtrlr->DefaultPath('image');
    //$defaultsvg = $strgCtrlr->DefaultPath('icon');
    //$token = "";
    if ($notifyuser->expert_id > 0) {
      $expert = Expert::find($notifyuser->expert_id);
      if ($expert) {
        if ($expert->is_active == 1 && (!is_null($expert->token) && $expert->token != '')) {
          $tokenList = [$expert->token];
          $data['id'] = $notifyuser->id;
          $res = Larafirebase::withTitle($notify->title)
            ->withBody($notify->body)
            // ->withImage($defaultimg)
            //  ->withIcon($defaultsvg)
            ->withSound('default')
            // ->withClickAction('https://www.google.com')
            ->withPriority('high')
            ->withAdditionalData($data)
            ->sendMessage($tokenList);
          return $res;
          //   return Larafirebase::withTitle($notify->title)
          //   ->withBody($notify->body)
          //  // ->withImage($defaultimg)
          // //  ->withIcon($defaultsvg)
          //   ->withSound('default')
          //   // ->withClickAction('https://www.google.com')
          //   ->withPriority('high')
          //   ->withAdditionalData($data)
          //   ->sendNotification($tokenList);

        } else {
          return 'empty token';
        }
      } else {
        return 'empty token';
      }
    } else {
      return 'empty';
    }
  }
}
