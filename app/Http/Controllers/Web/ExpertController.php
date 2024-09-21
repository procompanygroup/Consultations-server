<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Expert;
use App\Models\ExpertService;
use App\Models\Pointtransfer;
use App\Models\CashTransfer;
use App\Models\ExpertFavorite;
use App\Models\SelectedService;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Expert\StoreExpertRequest;
use App\Http\Requests\Web\Expert\UpdateExpertRequest;
use App\Http\Requests\Web\Expert\UpdateStatusRequest;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Web\NotifyClientController;
use App\Http\Controllers\Api\StatisticController;
class ExpertController extends Controller
{
 // public $path = 'images/experts'; 
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $list = Expert::get();
    
    return view('admin.expert.show', ['experts' => $list]);
    //return response()->json($users);

  }
  public function showstatus()
  {
    $list =Expert::get();
    
    return view('admin.expert.showstatus', ['experts' => $list]);
    //return response()->json($users);

  }
  public function statusbyid($id)
  {
    $expert =Expert::select('id','status')->find($id);   
     return response()->json( $expert);

  }

  public function updatestatus(UpdateStatusRequest $request, $id)
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
           Expert::find($id)->update([      
        'status'=>  $formdata['status'],
            ]);  
           if($formdata['status']=='a'){
//send notification 
 $notifyctrlr=new NotifyClientController();
 $notifyctrlr->send_available_to_clients($id,'other');
           }      
      //save image
      return redirect()->to(url('admin/expertstatus'));    
    }
  }
   
  public function showbalance()
  {
    $list = Expert::get();
    return view('admin.balance.expert', ['experts' => $list]);
     

  }
  public function showoperations($id)
  {
    $list = Pointtransfer::with( 'cashtransfers', 'selectedservices')
    ->where('expert_id',$id)->where('side','to-expert')->get();      
    $object = Expert::find($id); 
 return view('admin.operation.expert', ['transfers' => $list,'expert' => $object]);
 

  }
  

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.expert.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreExpertRequest $request)
  {//StoreExpertRequest
     
    $formdata = $request->all();
 /*
    $cnum ="";
    if (isset($formdata["country_num"])) {
      $cnum = $formdata["country_num"];
    }
    $mnum ="";
    if (isset($formdata["mobile_num"])) {
      $mnum = $formdata["mobile_num"];
    }
    */
   // $request->request->add(["mobile"=> $cnum.$mnum]);
    $formdata = $request->all();
   // return response()->json($formdata['mobile']);
   
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );

    if ($validator->fails()) {
   //   return response()->json($validator->witherr);
      return  response() ->json($validator,500);
    //  ->withInput();
    
    } else {
      $cnum = $formdata["country_num"];
      $mnum = $formdata["mobile_num"];
      $newObj = new Expert;
      $newObj->first_name = $formdata['first_name'];
      $newObj->last_name = $formdata['last_name'];
      $newObj->user_name = $formdata['user_name'];
      $newObj->password = bcrypt($formdata['password']);
    //  $newObj->mobile = $formdata['mobile'];
    $newObj->country_num = $cnum;
    $newObj->mobile_num = $mnum;
    $newObj->mobile = $cnum. $mnum;
      $newObj->email = $formdata['email'];
      //$newObj->nationality = $formdata['nationality'];

      $newObj->birthdate = Carbon::createFromFormat('m/d/Y', $formdata['birthdate'])->format('Y-m-d');

      $newObj->gender = (int) $formdata['gender'];
      //$newObj->marital_status = $formdata['marital_status'];
//$newObj->image = $formdata['image'];
      $newObj->points_balance = 0;
      $newObj->cash_balance = 0;
      $newObj->cash_balance_todate = 0;
      $newObj->rates = 0;
      //$newObj->record = $formdata['record'];
      $newObj->desc = $formdata['desc'];
      $newObj->call_cost = 0;
      $newObj->answer_speed = 0;
      $newObj->is_active = isset($formdata["is_active"]) ? 1 : 0;
      $newObj->is_available = 3;
      $newObj->status = 'n';
      

      //$newObj->token = $formdata['token'];
         
   //   $newObj->createuser_id = Auth::user()->id;
    //  $newObj->updateuser_id =Auth::user()->id;
      
      $newObj->save();

      if ($request->hasFile('image')) {
        $file = $request->file('image');
        // $filename= $file->getClientOriginalName();               
        $this->storeImage($file, $newObj->id);
        //  $this->storeImage( $file,2);
      }
      if ($request->hasFile('record')) {
        $file = $request->file('record');
        // $filename= $file->getClientOriginalName();               
        $this->storeExpertRecord($file, $newObj->id);
        //  $this->storeImage( $file,2);
      }

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
    $strgCtrlr=new StorageController();
    $url=$strgCtrlr->ExpertPath('image');
   // $recurl=$strgCtrlr->ExpertPath('record');
   // $url =url(Storage::url($this->path)).'/';
    $object = Expert::find($id);
    $object->birthdateStr= (string)Carbon::create($object->birthdate)->format('m/d/Y');
    if( $object->image !="" ){
      $object->fullpathimg= $url.$object->image;
    }
    //
     //return  dd ($object);
    return view('admin.expert.edit', ['expert' => $object]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateExpertRequest $request, $id)
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
     // $imagemodel = Expert::find($id);
      if ($request->hasFile('image')) {
        $file= $request->file('image');
               // $filename= $file->getClientOriginalName();                
     $this->storeImage( $file,$id);
       }
       if ($request->hasFile('record')) {
        $file = $request->file('record');
                   
        $this->storeExpertRecord($file,$id);
      
      }
       $cnum = $formdata["country_num"];
       $mnum = $formdata["mobile_num"];
      Expert::find($id)->update([
        'first_name'=>  strip_tags( $formdata['first_name']) ,
        'last_name'=>  $formdata['last_name'],
        'user_name' => $formdata['user_name'],
      //  'password' => $formdata['password'],
        'mobile' => $cnum. $mnum,
        'country_num'=>$cnum,
   'mobile_num'=>$mnum ,
        'email' => $formdata['email'],
       // 'nationality' => $formdata['nationality'],
        'birthdate' =>Carbon::createFromFormat('m/d/Y', $formdata['birthdate'])->format('Y-m-d'),
        'gender' =>(int) $formdata['gender'],
       
     //   'marital_status' => $formdata['marital_status'],
        //   'image' => $formdata['image'],
        //    'points_balance' => $formdata['points_balance'],
        //   'cash_balance' => $formdata['cash_balance'],
        //  'cash_balance_todate' => $formdata['cash_balance_todate'],
        //  'rates' => $formdata['rates'],
     //   'record' => $formdata['record'],
        'desc' => $formdata['desc'],
      'is_active' => isset($formdata['is_active'])?1:0,
      //  'call_cost' => $formdata['call_cost'],
        //   'token' => $formdata['token'],

      ]);
      if(isset($formdata['password'])){
        $password = trim($formdata['password']);
        Expert::find($id)->update([
          'password' => bcrypt($password),
        ]);
      }
      //save image
      return response()->json("ok");
    
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $object = Expert::find($id);



    if (!($object === null)) {

      //delete check related tables
      //   $item1= ExpertService::where('expert_id',$id)->first();
      //   $item1= Expertfavorite::where('expert_id',$id)->first();
      $item1 = Pointtransfer::where('expert_id', $id)->first();
      $item2 = Cashtransfer::where('expert_id', $id)->first();
      $item3 = Selectedservice::where('expert_id', $id)->first();
      if (!($item1 === null) || !($item2 === null) || !($item3 === null)) {
        // disable expert account
        Expert::find($id)->update([
          "is_active" => 0
        ]);
      } else {

        //delete related rows
        ExpertService::where('expert_id', $id)->delete();
        Expertfavorite::where('expert_id', $id)->delete();

        //delete image
        $strgCtrlr=new StorageController();
        $path=$strgCtrlr->path['experts'];
        $oldimagename=$object->image;
        Storage::delete("public/" . $path . '/' . $oldimagename);
        //delete object
        Expert::find($id)->delete();

      }
    }
    return redirect()->route('expert.index');
    // return  $this->index();
    //   return redirect()->route('users.index');

  }

  public function storeImage($file, $id)
  {
    $imagemodel = Expert::find($id);
    $oldimage = $imagemodel->image;
    $oldimagename = basename($oldimage);
    $strgCtrlr=new StorageController();
    $path=$strgCtrlr->path['experts'];
    $oldimagepath = $path . '/' . $oldimagename;
    //save photo

    if ($file !== null) {
      //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
      $filename = rand(10000, 99999) . $id . ".webp";
      $manager = new ImageManager(new Driver());
      $image = $manager->read($file);
      $image = $image->toWebp(75);
      if (!File::isDirectory(Storage::url('/' .  $path))) {
        Storage::makeDirectory('public/' .  $path);
      }
      $image->save(storage_path('app/public') . '/' .  $path . '/' . $filename);
      //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
      Expert::find($id)->update([
        "image" => $filename
      ]);
      Storage::delete("public/" .  $path . '/' . $oldimagename);
    }
    return 1;
  }

  public function delrecord($id)
  {
 
   if (isset($id))
     {
      $this->deleteExpertRecord( $id);
      return response()->json("ok");
     }  else{
     return response()->json([
        "errors" =>  ["record" => [__('messages.faild')]]          
      ], 422); 
     }
   
    
    
  }

  public function deleteExpertRecord( $id)
  {
      $model = Expert::find($id);
      $oldfile = $model->record;
      $oldfilename = basename($oldfile);
      $strgCtrlr = new StorageController();
      $recpath = $strgCtrlr->recordpath['experts'];   
                  Expert::find($id)->update([
              "record" =>""
          ]);
          Storage::delete("public/" . $recpath . '/' . $oldfilename);     
      return 1;
  }
  public function storeExpertRecord($file, $id)
  {
      $model = Expert::find($id);
      $oldfile = $model->record;
      $oldfilename = basename($oldfile);
      $strgCtrlr = new StorageController();
      $recpath = $strgCtrlr->recordpath['experts'];
      if ($file !== null) {
          $filename = rand(10000, 99999) . $id . "." . $file->getClientOriginalExtension();
          if (!File::isDirectory(Storage::url('/' . $recpath))) {
              Storage::makeDirectory('public/' . $recpath);
          }
          $path = $file->storeAs(
              $recpath,
              $filename,
              'public'
          );

          Expert::find($id)->update([
              "record" => $filename
          ]);
          Storage::delete("public/" . $recpath . '/' . $oldfilename);
      }
      return 1;
  }

  public function statistics()
  {
    $List =Expert::get();  
     
   // $sts_list= $stsctrlr->all_expert_statistics();

      return view('admin.expert.statistics', ['sts_list' => $List]);
  }
  public function statistics_expert($id)
  {
    $expert =Expert::find($id);  
    if($expert){
      $stsctrlr=new StatisticController();
      $sts_list= $stsctrlr->expert_statistics($id);
          return view('admin.expert.statistics-expert', ['expert'=> $expert,'sts_list' =>$sts_list]);
    }else{
      return response("not Found",401);
    }

  }
}
