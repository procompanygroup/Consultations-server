<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Expert;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Api\StorageController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Web\Message\StoreRequest;
use App\Http\Requests\Web\Message\StoreApiRequest;
use App\Http\Requests\Web\Message\MessagesRequest;

class MessageController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public $oldestday = 30;
  public function clients()
  {
    $list = Client::where('is_active', 1)->get();
    return view('admin.message.clients', ['clients' => $list]);
    //return response()->json($users);

  }
  public function experts()
  {
    $list = Expert::where('is_active', 1)->get();
    return view('admin.message.experts', ['experts' => $list]);
    //return response()->json($users);

  }

  public function client($id)
  {
    $client=$this->msgsbyclient_id($id);
 
    $strgCtrlr = new StorageController();
    $manage_img = $strgCtrlr->DefaultPath('icon');

    return view('admin.message.client', ['client' =>$client, 'manage_img' => $manage_img]);
  }


  //api
  public function clientsendmsg()
  {
    $request = request();
    $formdata = $request->all();

    $storrequest = new StoreApiRequest();
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
    } else {

      $newObj = new Message();
      $newObj->content = $formdata['message'];
      $newObj->client_id = $formdata['id'];
      // $newObj->expert_id = $formdata['expert_id'];
      $newObj->is_active = 1;
      //   $newObj->user_id =auth()->user()->id;
      $newObj->status = 'c'; //client      
      $newObj->save();
      $arr = [
        'id'=> $newObj->id,
        'cdate' => $newObj->created_at->format('d/m/Y'),
        'ctime' => $newObj->created_at->format('H:m'),
        'content' => $newObj->content,
        'res' => 'ok'
      ];

      return response()->json($arr);

    }
  }

  public function storetoclient(StoreRequest $request, $id)
  {//StoreExpertRequest

    $formdata = $request->all();
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);
    } else {
      $newObj = new Message();
      $newObj->content = $formdata['message'];
      $newObj->client_id = $id;
      // $newObj->expert_id = $formdata['expert_id'];
      $newObj->is_active = 1;
      $newObj->user_id = auth()->user()->id;
      $newObj->status = 'a'; //admin      
      $newObj->save();
      $arr = [
        'id'=> $newObj->id,
        'cdate' => $newObj->created_at->format('d/m/Y'),
        'ctime' => $newObj->created_at->format('H:m'),
        'content' => $newObj->content,
        'res' => 'ok'
      ];

      return response()->json($arr);
    }

  }

  //api
  public function clientgetmsg()
  {
    $request = request();
    $formdata = $request->all();
    $storrequest = new MessagesRequest();
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
    } else {
      $id = $formdata['id'];
      $client=$this->msgsbyclient_id($id);
      //map
      $List = $this->mapclientmsg($client);
      return response()->json($List);
    }
  }
  public function msgsbyclient_id($id){
    $nowsub = Carbon::now()->subDays($this->oldestday);
    $client = Client::where('id', $id)->where('is_active', 1)->
      with([
        'messages' => function ($q) use ($nowsub) {
          $q->whereDate('created_at', '>=', $nowsub)->orderBy('created_at');
        }
      ])->first();
      return  $client;
  }
  
  public function mapclientmsg($client)
  {
    $strgCtrlr = new StorageController();
    $manage_img = $strgCtrlr->DefaultPath('icon');
    $List = $client->messages->map(function ($message) use ($client, $manage_img) {
      $arr = [];
      if ($message->user_id) {
        $arr = [
          'id' => $message->id,
          'client_id' => $message->client_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          'sender_name' => __('general.manage'),
          'sender_image' => $manage_img,
        ];
      } else {
        $arr = [
          'id' => $message->id,
          'client_id' => $message->client_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          'sender_name' => $client->user_name,
          'sender_image' => $client->image_path,
        ];
      }
      return $arr;
    });
    return $List;

  }
  public function clientlastmsgs(Request $request){
    $formdata = $request->all();
   $msg_id= $formdata['msg_id'];
   $client_id= $formdata['client_id'];   
   $messages=Message::where('client_id',$client_id)->where('id','>',$msg_id)->whereNull('user_id')->
     select( 'id','content',
     'client_id',
     'expert_id',
    // 'is_active',
     'user_id',
     'status',
     'created_at')->orderBy('created_at')->get();
     $List= $this->mapclienttoadmin($messages);
     return response()->json([
      'res'=>'ok',
      'messages'=>$List
     ] );   
       
  }

  public function mapclienttoadmin($messages)
  {    // $strgCtrlr = new StorageController();
    // $manage_img = $strgCtrlr->DefaultPath('icon');
    $List =$messages->map(function ($message) {     
      return [
          'id' => $message->id,
          'client_id' => $message->client_id,
          'expert_id' => $message->expert_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          // 'sender_name' => $client->user_name,
          // 'sender_image' => $client->image_path,
        ];       
    });
    return $List;

  }


  /// expert /////////
  public function expert($id)
  {
    $expert=$this->msgsbyexpert_id($id);
 
    $strgCtrlr = new StorageController();
    $manage_img = $strgCtrlr->DefaultPath('icon');

    return view('admin.message.expert', ['expert' =>$expert, 'manage_img' => $manage_img]);


  }
  public function msgsbyexpert_id($id){
    $nowsub = Carbon::now()->subDays($this->oldestday);
    $expert = Expert::where('id', $id)->where('is_active', 1)->
      with([
        'messages' => function ($q) use ($nowsub) {
          $q->whereDate('created_at', '>=', $nowsub)->orderBy('created_at');
        }
      ])->first();
      return  $expert;
  }

  
  //api
  public function expertsendmsg()
  {
    $request = request();
    $formdata = $request->all();

    $storrequest = new StoreApiRequest();
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
    } else {

      $newObj = new Message();
      $newObj->content = $formdata['message'];
      $newObj->expert_id = $formdata['id'];
   
      $newObj->is_active = 1;
      //   $newObj->user_id =auth()->user()->id;
      $newObj->status = 'e'; //expert      
      $newObj->save();
      $arr = [
        'id'=> $newObj->id,
        'cdate' => $newObj->created_at->format('d/m/Y'),
        'ctime' => $newObj->created_at->format('H:m'),
        'content' => $newObj->content,
        'res' => 'ok'
      ];

      return response()->json($arr);

    }
  }

  public function storetoexpert(StoreRequest $request, $id)
  {//StoreExpertRequest

    $formdata = $request->all();
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);
    } else {
      $newObj = new Message();
      $newObj->content = $formdata['message'];
      $newObj->expert_id = $id;
    
      $newObj->is_active = 1;
      $newObj->user_id = auth()->user()->id;
      $newObj->status = 'a'; //admin      
      $newObj->save();
      $arr = [
        'id'=> $newObj->id,
        'cdate' => $newObj->created_at->format('d/m/Y'),
        'ctime' => $newObj->created_at->format('H:m'),
        'content' => $newObj->content,
        'res' => 'ok'
      ];

      return response()->json($arr);
    }

  }

  //api
  public function expertgetmsg()
  {
    $request = request();
    $formdata = $request->all();
    $storrequest = new MessagesRequest();
    $validator = Validator::make(
      $formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {

      return response()->json($validator->errors());
    } else {
      $id = $formdata['id'];
      $expert=$this->msgsbyexpert_id($id);
      //map
      $List = $this->mapclientmsg($expert);
      return response()->json($List);
    }
  }
 
  
  public function mapexpertmsg($expert)
  {
    $strgCtrlr = new StorageController();
    $manage_img = $strgCtrlr->DefaultPath('icon');
    $List = $expert->messages->map(function ($message) use ($expert, $manage_img) {
      $arr = [];
      if ($message->user_id) {
        $arr = [
          'id' => $message->id,
          'expert_id' => $message->expert_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          'sender_name' => __('general.manage'),
          'sender_image' => $manage_img,
        ];
      } else {
        $arr = [
          'id' => $message->id,
          'expert_id' => $message->expert_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          'sender_name' => $expert->full_name,
          'sender_image' => $expert->image_path,
        ];
      }
      return $arr;
    });
    return $List;

  }
  public function expertlastmsgs(Request $request){
    $formdata = $request->all();
   $msg_id= $formdata['msg_id'];
   $expert_id= $formdata['expert_id'];   
   $messages=Message::where('expert_id',$expert_id)->where('id','>',$msg_id)->whereNull('user_id')->
     select( 'id','content',
     'client_id',
     'expert_id',
    // 'is_active',
     'user_id',
     'status',
     'created_at')->orderBy('created_at')->get();
     $List= $this->mapexperttoadmin($messages);
     return response()->json([
      'res'=>'ok',
      'messages'=>$List
     ] );   
       
  }

  public function mapexperttoadmin($messages)
  {    // $strgCtrlr = new StorageController();
    // $manage_img = $strgCtrlr->DefaultPath('icon');
    $List =$messages->map(function ($message) {     
      return [
          'id' => $message->id,
          'client_id' => $message->client_id,
          'expert_id' => $message->expert_id,
          'create_date' => $message->created_at->format('d/m/Y'),
          'create_time' => $message->created_at->format('H:m'),
          'content' => $message->content,
          'status' => $message->status,
          // 'sender_name' => $client->user_name,
          // 'sender_image' => $client->image_path,
        ];       
    });
    return $List;

  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

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
}
