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
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $oldestday=30;
    public function clients()
    {
      $list = Client::where('is_active',1)->get();
      return view('admin.message.clients', ['clients' => $list]);
      //return response()->json($users);
  
    }
    public function experts()
    {
      $list = Expert::where('is_active',1)->get();
      return view('admin.message.experts', ['experts' => $list]);
      //return response()->json($users);
  
    }
    
    public function client($id)
    {
      $nowsub = Carbon::now()->subDays($this->oldestday);
      $now = Carbon::now();
      $item = Client::where('id',$id)->where('is_active',1)->
      with([
        'messages' => function ($q)use( $nowsub) {
          
            $q->whereDate('created_at', '>=', $nowsub)->orderBy('created_at');
        }])
      ->first();
      $strgCtrlr=new StorageController();
      $manage_img=$strgCtrlr->DefaultPath('icon');
      
      return view('admin.message.client', ['client' => $item,'manage_img'=>$manage_img]);
  
  
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
    public function storetoclient(StoreRequest $request,$id)
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
        $newObj->client_id =$id;
       // $newObj->expert_id = $formdata['expert_id'];
        $newObj->is_active = 1;
        $newObj->user_id =auth()->user()->id;
        $newObj->status = 'a'; //admin      
        $newObj->save(); 
         $arr=[
          'cdate'=> $newObj->created_at->format('d/m/Y'),
        'ctime'=> $newObj->created_at->format('H:m'),
          'content'=> $newObj->content,
          'res'=>'ok'
         ];

        return response()->json($arr);
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
