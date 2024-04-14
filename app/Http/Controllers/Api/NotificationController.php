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
//use Notification;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function saveToken(Request $request)
    {
   //  print_r($request->all());
     auth()->user()->update(['token'=>$request->token]);
   return response()->json(['Token Saved!']);
    }
    public function sendNotification(Request $request)
    {
      $strgCtrlr=new StorageController();
      $defaultimg=$strgCtrlr->DefaultPath('image');
      $defaultsvg=$strgCtrlr->DefaultPath('icon');
      
      $tokenList=User::whereNotNull('token')->pluck('token')->all();
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
          'username'=>"Ahmad",
          'image'=>$defaultimg,
      ])
    ->  sendMessage($tokenList);
    //  ->sendNotification($tokenList);
    }
    public function sendbytoken(Request $request)
    {
      $strgCtrlr=new StorageController();
      $defaultimg=$strgCtrlr->DefaultPath('image');
      $defaultsvg=$strgCtrlr->DefaultPath('icon');
      $formdata = $request->all();
      $token="";
      if(isset($formdata['input_token'])){
        $token=$formdata['input_token'];

        $tokenList =[$token];
        
        return Larafirebase::withTitle($request->title)
        ->withBody($request->body)
        ->withImage($defaultimg)
        ->withIcon($defaultsvg)
        ->withSound('default')
        ->withClickAction('https://www.google.com')
        ->withPriority('high')        
        ->withAdditionalData([         
            'username'=>"Ahmad",
            'image'=>$defaultimg,
        ])
      ->  sendMessage($tokenList);
      }else{
        return 'empty token'  ;
      }
     

    //  ->sendNotification($tokenList);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
$List=Notification::where('side', 'LIKE', '%'.'client'.'%')->orWhere('side', 'LIKE', '%'.'expert'.'%')->get();
        return view('admin.notify.show', ['list' => $List] );
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
      return view('admin.notify.create'  );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotifyRequest $request)//StoreNotifyRequest
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
        $newObj = new Notification;
        $newObj->title = $formdata['title'];   
        $newObj->body =isset($formdata['body'])?$formdata['body']:'';   
       $side= implode(",", $formdata['side']);      
        $newObj->side =  $side;    
        $newObj->type = 'text';  

     //   $newObj->is_active = 1;
      
        $newObj->save();
        if ($request->hasFile('image')) {
          $file= $request->file('image');
                              
       $this->storeImage( $file, $newObj->id);
         }

         //create rows in noti user table 
         $notification_id=$newObj->id;
         //expert
if(Str::contains($side,'expert')){
 
$expertids=Expert::where('is_active',1)->select('id')->get();
 
$now= Carbon::now();

 $insertList = $expertids->map(function ($notifyuser) use($notification_id,$now) {
   return [
     'expert_id' => $notifyuser->id,
     'notification_id'=>$notification_id,
     'isread'=>0,
     'created_at'=>$now,
     'updated_at'=>$now, 
      'state'=>'sent', 
   ];
 });
 NotificationUser::insert($insertList->toArray()); 

}
//client
if(Str::contains($side,'client')){

  $clientids=Client::where('is_active',1)->select('id')->get();
   
  $now= Carbon::now();  
   $insertList = $clientids->map(function ($notifyuser) use($notification_id,$now) {
     return [
       'client_id' => $notifyuser->id,
       'notification_id'=>$notification_id,
       'isread'=>0,
       'created_at'=>$now,
       'updated_at'=>$now,
  //'expert_id',
  //'user_id',
  
  //'read_at',
  'state'=>'sent',
  //'notes',
     ];
   });
   NotificationUser::insert($insertList->toArray()); 
}
    //$boolres= Str::contains( $type,'form') ;
     
        return response()->json("ok");
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
    public function storeImage($file, $id)
    {
      $imagemodel = Notification::find($id);
      $strgCtrlr = new StorageController();
      $path = $strgCtrlr->videopath['notify'];
      $oldimage = $imagemodel->data;
      $oldimagename = basename($oldimage);
    //  $oldimagepath = $path . '/' . $oldimagename;
      //save photo
  
      if ($file !== null) {
        //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
        $ext=$file->getClientOriginalExtension();
     //  $filename =  $imagemodel->code . $id . ".webp";
        $filename =  rand(10000, 99999) . $id .'.'.$ext;
        /*
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image = $image->toWebp(75);
        */
        Storage::delete("public/" .$path . '/' . $oldimagename);
/*
        if (!File::isDirectory(Storage::url('/' .$path))) {
          Storage::makeDirectory('public/' . $path);
        }
        */
      //  $image->save(storage_path('app/public') . '/' . $path . '/' . $filename);
        $path = $file->storeAs($path ,$filename,'public');
        //   $url = url('storage/app/public' . '/' . $path . '/' . $filename);
        Notification::find($id)->update([
          "data" => $filename,
          "type" => 'video',
        ]);
      //  Storage::delete("public/" .$path . '/' . $oldimagename);
      }
      return 1;
    }
}
