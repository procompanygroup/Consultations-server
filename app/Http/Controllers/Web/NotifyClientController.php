<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\NotifyClient;
use App\Models\Expert;
use App\Models\Client;
use App\Models\NotifyClientState;

use App\Http\Requests\Web\Notifyme\StoreNotifymeRequest;
use Illuminate\Support\Facades\Validator;
//use Kutia\Larafirebase\Facades\Larafirebase;
use App\Http\Controllers\Web\NotifyController;
class NotifyClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $oldestday = 30;
    public function index()
    {
        $nowsub = Carbon::now()->subDays($this->oldestday);
    $List = NotifyClient::with('expert')->whereDate('created_at', '>=', $nowsub)->get();
    return view('admin.notifyme.show', ['list' => $List]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $List=$this->allowedexperts();
        return view('admin.notifyme.create', ['experts' => $List]);
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
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotifymeRequest $request)//from panel
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
        $expert_id= $formdata['expert_id'];
      $newObj = new NotifyClient();
      $newObj->title = $formdata['title'];
      $newObj->body = isset($formdata['body']) ? $formdata['body'] : '';
     
      $newObj->expert_id =  $expert_id;
       
      $newObj->save();
     
      //create rows in noti user table 
      $notification_id = $newObj->id;
      //expert
     
      //client
       
        $clientids = Client::whereHas('clientsexperts', function ($query) use($expert_id) {
            $query->where('expert_id', $expert_id)->where('notify',1);         
          })->where('is_active', 1)->select('id')->get();
        $now = Carbon::now();
        $insertList = $clientids->map(function ($notifyuser) use ($notification_id, $now) {
          return [
            'client_id' => $notifyuser->id,
            'notify_client_id' => $notification_id,
            'isread' => 0,
            'created_at' => $now,
            'updated_at' => $now,
              ];
        });

        NotifyClientState::insert($insertList->toArray());
     
      //send firebase notify

    
  
        //   $clienttokenList = User::where('is_active', 1)->whereNotNull('token')->pluck('token')->all();
        $clienttokenList = $this->clienttokenwithid($newObj);

        $this->send_fire_notify_from_panel($newObj, $clienttokenList);
       //$boolres= Str::contains( $type,'form') ;     
      return response()->json("ok");

    }
  }

  public function send_fire_notify_from_panel(NotifyClient $notify, $tokenList)
  {
    //   $strgCtrlr = new StorageController();
    // $defaultimg = $strgCtrlr->DefaultPath('image');
    //   $defaultsvg = $strgCtrlr->DefaultPath('icon');

    $res = "";
    if ($tokenList) {
      $notctrlr=new NotifyController();
     
      foreach ($tokenList as $tokenrow) {
        $data=[ 
          'id' =>strval($tokenrow['id']),
          'notes' => 'notifyme',
        ];
        $res =    $notctrlr->send_to_fcm($tokenrow['token'],$notify->title,$notify->body,$data);
        
        // $tokenarr = [$tokenrow['token']];
        // $res = Larafirebase::withTitle($notify->title)
        //   ->withBody($notify->body)
        //   ->withSound('default')
        //   ->withPriority('high')
        //   ->withAdditionalData([
        //     'id' => $tokenrow['id'],
        //     'notes' => 'notifyme',
        //   ])
        //   ->sendMessage($tokenarr);
 

      }
      return $res;
    } else {
      return 'empty token';
    }
  }
  public function clienttokenwithid(NotifyClient $notify)
  {
    $id = $notify->id;

    $list = NotifyClientState::where('notify_client_id', $id)->
      whereHas('client', function ($query) {
        $query->whereNotNull('token')->whereNot('token', '')->where('is_active', 1);
      })->with('client:id,is_active,token')->select('id', 'notify_client_id', 'client_id')->get();
    $sendlist = $this->mapclienttoken($list);
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
        //
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

    public function send_available_to_clients($expert_id,$type)//from panel
    {
      
     $expert=Expert::find($expert_id);
     $title ='';
     $body ='';
     if($type=='other'){
      $title = __('general.14otherserviceavailable_title',['Expertname' => $expert->full_name]);
      $body = __('general.14otherserviceavailable__body',['Expertname' => $expert->full_name]);
     }else{
      $title = __('general.15callserviceavailable_title',['Expertname' => $expert->full_name]);
      $body = __('general.15callserviceavailable__body',['Expertname' => $expert->full_name]);
     }
     
        $newObj = new NotifyClient();
        $newObj->title = $title ;
        $newObj->body =  $body ;
       
        $newObj->expert_id =  $expert_id;
         
        $newObj->save();
       
        //create rows in noti user table 
        $notification_id = $newObj->id;
        //expert
       
        //client
         
          $clientids = Client::whereHas('clientsexperts', function ($query) use($expert_id) {
              $query->where('expert_id', $expert_id)->where('notify',1);         
            })->where('is_active', 1)->select('id')->get();
          $now = Carbon::now();
          $insertList = $clientids->map(function ($notifyuser) use ($notification_id, $now) {
            return [
              'client_id' => $notifyuser->id,
              'notify_client_id' => $notification_id,
              'isread' => 0,
              'created_at' => $now,
              'updated_at' => $now,
                ];
          });
  
          NotifyClientState::insert($insertList->toArray());
       
        //send firebase notify
  
          //   $clienttokenList = User::where('is_active', 1)->whereNotNull('token')->pluck('token')->all();
          $clienttokenList = $this->clienttokenwithid($newObj);
  
          $this->send_fire_notify_from_panel($newObj, $clienttokenList);
         //$boolres= Str::contains( $type,'form') ;     
        return response()->json("ok");
  
    
    }
  
}
