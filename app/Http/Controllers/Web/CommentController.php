<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Reason;
use Illuminate\Http\Request;
use App\Models\ValueService;
use App\Models\Selectedservice;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

use App\Http\Requests\Web\Order\UpdateCommentStateRequest;
use App\Models\Pointtransfer;
use App\Models\Client;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\StorageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Web\Order\UpdateCommentRateRequest;
use  App\Http\Controllers\Api\NotificationController;

class CommentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public $oldestday = 30;
  public function index()
  {
    $nowsub = Carbon::now()->subDays($this->oldestday);
    // $list =Selectedservice::with('expert','client','service')->orderByDesc('comment_state')->get();
    //  return  $list;
    $list = Selectedservice::with([
      'expert',
      'client',
      'service',
      'answers'
      /*
      'answers' => function ($q){
          $q->latest()->first();
      }
      */
    ])->whereNotNull('comment')->whereNot('comment', '')   
    ->whereDate('created_at', '>=', $nowsub)->
    orderByDesc('comment_state')->get()->where('answer_state', 'agree');

    //   return  $list;
    return view('admin.comment.show', ['selectedservices' => $list]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.comment.create');
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
    $object = Selectedservice::with([
      'expert',
      'client',
      'valueservices' => function ($q) {
        $q->orderByDesc('ispersonal');
      },
      'answers' => function ($q) {
        $q->orderByDesc('created_at');
      }
    ])->find($id);
    $strgCtrlr = new StorageController();
    $sharp= $strgCtrlr->DefaultPath('sharp');
    $usericon= $strgCtrlr->DefaultPath('user');
    $reasons = Reason::where('type', 'comment')->get();
    //return dd($object);
    return view('admin.comment.edit', ['selectedservice' => $object, 'reasons' => $reasons,'sharpicon'=>$sharp,'usericon'=>$usericon]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function agreemethod(Request $request, $id)
  {

    DB::transaction(function () use ($id) {
      $selectedObj = Selectedservice::find($id);
      if ($selectedObj->comment_state == 'wait') {
        $now = Carbon::now();
        Selectedservice::find($id)->update([
          'comment_state' => 'agree',
          'comment_user_id' => Auth::user()->id,
          'comment_admin_date' => $now,
        ]);
      }
    });

    //  //send auto notification 8
$notctrlr=new NotificationController();
$selectedObj= Selectedservice::with('service:id,name','expert:id,first_name,last_name','client:id,user_name')->find($id);
 $Servicename=$selectedObj->service->name;
 $Clientname=$selectedObj->client->user_name;       
   
$title= __('general.8commentcome_title');
$body= __('general.8commentcome_body',['Servicename'=> $Servicename,'Clientname'=>$Clientname]);     
$notctrlr->sendautonotify($title, $body,'auto','order','','comment',0,$selectedObj->expert_id,$id,0);   

    return response()->json("ok");

  }
  public function rejectmethod(UpdateCommentStateRequest $request, $id)
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

      DB::transaction(function () use ($formdata, $id) {
        $selectedObj = Selectedservice::find($id);
        if ($selectedObj->comment_state == 'wait') {
          //reject
          $now = Carbon::now();
          $reason = Reason::find($formdata['comment_reject_reason']);
          Selectedservice::find($id)->update([
            'comment_state' => 'reject',
            'comment_reject_reason' => $reason->content,
            'comment_user_id' => Auth::user()->id,
            'comment_admin_date' => $now,
          ]);
        }
      });
     //send auto notification 9
     $notctrlr=new NotificationController();
     $selectedObj= Selectedservice::find($id);
                      
     $Reason=$selectedObj->comment_reject_reason;     
     $title= __('general.9commentreject_title');
     $body= __('general.9commentreject_body',['Reason'=> $Reason]);     
  $notctrlr->sendautonotify($title, $body,'auto','text','','order-comment-reject',$selectedObj->client_id,0,$id,0);         

      return response()->json("ok");
    }
  }
  public function ratemethod(UpdateCommentRateRequest $request, $id)
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

      DB::transaction(function () use ($formdata, $id) {
        $selectedObj = Selectedservice::find($id);
        if ($selectedObj->comment_state == 'agree' && $selectedObj->comment_rate == 0) {
        
          $now = Carbon::now();
          Selectedservice::find($id)->update([
            'comment_rate' => $formdata['comment_rate'],
            'comment_rate_admin_id' => Auth::user()->id,
            'comment_rate_date' => $now,
          ]);
 
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

    return redirect()->route('comment.index');
    // return  $this->index();
    //   return redirect()->route('users.index');

  }

}
