<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Service\StoreServiceRequest;
use App\Http\Requests\Web\Service\UpdateServiceRequest;
use App\Http\Requests\Web\Input\StoreInputRequest;
use App\Models\Input;
use App\Models\Pointtransfer;
use App\Models\Selectedservice;
use App\Models\ExpertService;
use App\Models\InputService;
use App\Models\Servicefavorite;
use App\Models\Permission;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Web\InputController;
use App\Models\Inputvalue;
/* 
use App\Models\Expertfavorite;
use App\Models\Servicefavorite;
use App\Models\Cashtransfer;
*/
   /*
ExpertService
InputService
Servicefavorite
Permission
          */
class ServiceController extends Controller
{
  public $path = 'images/services';
  public $iconpath = 'images/services/icons';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('services')->whereNot('is_callservice',1)->get();
      return view('admin.service.show', ['services' => $list]);
      //return response()->json($users);
  
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.service.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
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
      /*
      'name',
        'desc',
        'image',
        'createuser_id',
        'updateuser_id',
        'is_active',
        'icon',
      */
      $newObj = new Service;
      $newObj->name = $formdata['name'];
      $newObj->desc = $formdata['desc'];
     
      $newObj->createuser_id = Auth::user()->id;
      $newObj->updateuser_id =Auth::user()->id;
      $newObj->is_active = isset($formdata["is_active"]) ? 1 : 0;
      
      $newObj->save();

      if ($request->hasFile('image')) {
        $file = $request->file('image');
        // $filename= $file->getClientOriginalName();               
        $this->storeImage($file, $newObj->id);
        //  $this->storeImage( $file,2);
      }
      if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        // $filename= $file->getClientOriginalName();               
        $this->storeSvg($file, $newObj->id);
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
    public function edit($id)
    {
      $url =url(Storage::url($this->path)).'/';
      $iconurl =url(Storage::url($this->iconpath)).'/';
      $object = Service::find($id) ;
 
   $personalinput=$object->inputservices()->with('input')->get() ;
   $personal_array=['user_name'=>0,
   'nationality'=>0,
   'gender'=>0,
   'birthdate'=>0,
   'marital_status'=>0,
    ];
    $recimg_array=['record'=>0,
    'image'=>0,
    'image_count'=>0,
     
     ];
   foreach( $personalinput as $inputservice){
  //  return $inputservice['input']['name'];
if( $inputservice['input']['name']=='user_name' && $inputservice['input']['ispersonal']==1){
  $personal_array['user_name']=1;
} 
if( $inputservice['input']['name']=='nationality' && $inputservice['input']['ispersonal']==1){
  $personal_array['nationality']=1;
}
if( $inputservice['input']['name']=='gender' && $inputservice['input']['ispersonal']==1){
  $personal_array['gender']=1;
}
if( $inputservice['input']['name']=='birthdate' && $inputservice['input']['ispersonal']==1){
  $personal_array['birthdate']=1;
}
if( $inputservice['input']['name']=='marital_status' && $inputservice['input']['ispersonal']==1){
  $personal_array['marital_status']=1;
}
/// record image form
if( $inputservice['input']['type']=='record' && $inputservice['input']['ispersonal']==0){
  $recimg_array['record']=1;
}
if( $inputservice['input']['type']=='image' && $inputservice['input']['ispersonal']==0){
  $recimg_array['image']=1;
  $recimg_array['image_count']=$inputservice['input']['image_count'];
}
   }
 //return  $personal_array;
//   $personalinputf= $object->inputservices()->first()->input()->get();
   //   return    $personalinput ;
    //  $object->inputservices->Input;
      if( $object->image !="" ){
        $object->fullpathimg= $url.$object->image;
      }
      if( $object->icon !="" ){
        $object->fullpathsvg= $iconurl.$object->icon;
      }
      //
      return view('admin.service.edit', ['service' => $object,'personal_array'=>$personal_array,'recimg_array'=>$recimg_array]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, $id)
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
     return response()->json($validator);

    } else {
     // $imagemodel = Expert::find($id);
      if ($request->hasFile('image')) {
        $file= $request->file('image');
               // $filename= $file->getClientOriginalName();                
     $this->storeImage( $file,$id);
       }
       if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        // $filename= $file->getClientOriginalName();               
        $this->storeSvg($file,$id);
        //  $this->storeImage( $file,2);
      }
      Service::find($id)->update([
        'name'=>  $formdata['name'],
        'desc'=>  $formdata['desc'],
        'updateuser_id' =>Auth::user()->id,      
      'is_active' => isset($formdata['is_active']) ? 1 : 0
      ]);
     
      return response()->json("ok");
      
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Service::find($id);
      if (!($object === null)) {
 
        //delete check related tables
       
        $item1 = Pointtransfer::where('service_id', $id)->first();       
        $item2 = Selectedservice::where('service_id', $id)->first();
        if (!($item1 === null) || !($item2 === null)) {
           // disable service account
           Service::find($id)->update([
            "is_active" => 0
          ]);
  
        } else {
        
   //delete image
   if (!empty($object->image)) {
    $imgpath = $this->path . '/' . $object->image;
    if (File::exists($imgpath)) {
      File::delete($imgpath);
    }
  }
//delete related rows

  ExpertService::where('service_id', $id)->delete();
  InputService::where('service_id', $id)->delete();

  Permission::where('service_id', $id)->delete();
  //delete object
  Service::find($id)->delete();
        }
      }
      return redirect()->route('service.index');
      //   return  $this->index();
      // 
   
      //   return redirect()->route('users.index');
  
    }
    public function storeImage($file, $id)
    {
      $imagemodel = Service::find($id);
      $oldimage = $imagemodel->image;
      $oldimagename = basename($oldimage);
      $oldimagepath = $this->path . '/' . $oldimagename;
      //save photo
  
      if ($file !== null) {
        //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
        $filename = rand(10000, 99999) . $id . ".webp";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image = $image->toWebp(75);
        if (!File::isDirectory(Storage::url('/' . $this->path))) {
          Storage::makeDirectory('public/' . $this->path);
        }
        $image->save(storage_path('app/public') . '/' . $this->path . '/' . $filename);
        //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
        Service::find($id)->update([
          "image" => $filename
        ]);
        Storage::delete("public/" . $this->path . '/' . $oldimagename);
      }
      return 1;
    }
    public function storeSvg($file, $id)
    {
      $imagemodel = Service::find($id);
      $oldimage = $imagemodel->icon;
      $oldimagename = basename($oldimage);
      $oldimagepath = $this->iconpath . '/' . $oldimagename;
      //save photo
  
      if ($file !== null) {
        $filename= rand(10000, 99999). $id .".".$file->getClientOriginalExtension();
   
     //   $manager = new ImageManager(new Driver());
     //   $image = $manager->read($file);
        
        if (!File::isDirectory(Storage::url('/' . $this->iconpath))) {
          Storage::makeDirectory('public/' . $this->iconpath);
        }
        $path =$file->storeAs(
           $this->iconpath , $filename,'public'
      );

       // $image->save(storage_path('app/public') . '/' . $this->iconpath . '/' . $filename);
        //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
        Service::find($id)->update([
          "icon" => $filename
        ]);
        Storage::delete("public/" . $this->iconpath . '/' . $oldimagename);
      }
      return 1;
    }

    public function savepersonal(Request $request, $id)
    {
      
    $formdata = $request->all();
    // isset($formdata['user_name'])
 $this->savepersonalrow('user_name',isset($formdata['user_name']), $id);
 $this->savepersonalrow('nationality',isset($formdata['nationality']), $id);
 $this->savepersonalrow('gender',isset($formdata['gender']), $id);
 $this->savepersonalrow('birthdate',isset($formdata['birthdate']), $id);
 $this->savepersonalrow('marital_status',isset($formdata['marital_status']), $id);
 
 /*
     DB::transaction(function ( ) use( $formdata ,$id){
    $input=Input::where('name','user_name')->where('ispersonal',1)->first();

   if(isset($formdata['user_name']) ){
   // return response()->json($formdata['user_name']);
    $inputservice = InputService::updateOrCreate(
      ['service_id' => $id, 'input_id' => $input->id] 
  );
   }else{
   // return response()->json("no");
    $deleted = InputService::where('service_id', $id)->where('input_id', $input->id)->delete();
   }
  
  });
     */
      return response()->json("ok");
      
    
    }
    public function saveimgrecord(Request $request, $id)
    {
      
    $formdata = $request->all();
    /*
    // isset($formdata['user_name'])
 $this->savepersonalrow('user_name',isset($formdata['user_name']), $id);
 $this->savepersonalrow('nationality',isset($formdata['nationality']), $id);
 */
    // DB::transaction(function ( ) use( $formdata ,$id){
    $this->saverecordcheck(isset($formdata['record']), $id);
    $imgcount=0;
if(isset($formdata['image_count'])){
$imgcount=$formdata['image_count'];
}
    $this->saveimgcheck(isset($formdata['image']), $id, $imgcount);

     
 // });
    
      return response()->json("ok");
      
    
    }
    public function saverecordcheck( $formValue, $service_id)
    {   
    // DB::transaction(function ( ) use( $formdata ,$id){
    
      $recinputservices = InputService::where('service_id',$service_id)->whereHas('input', function ( $query) {
        $query->where('type', 'record');
    })->get();    

   if($formValue ){
//record selected

if($recinputservices->isEmpty()){
  $input=new Input();
  $input->type='record';
  $input->name='record';
  $input->ispersonal=0;
  $input->tooltipe="";
  $input->icon="";
  $input->save();
  $inputservice = new InputService();
  $inputservice->service_id=$service_id;
  $inputservice->input_id= $input->id;
  $inputservice->save();
 
}

   }else{
    //record not selected 
   if( !$recinputservices->isEmpty()){

    $deleted =InputService::find($recinputservices->first()->id)->delete();
    $deleted =Input::find($recinputservices->first()->input_id)->delete();
   }
  
   }
   return 1;
  
    
    }
    public function saveimgcheck($formValue, $service_id,$imgcount)
    {
      
   
    /*
    // isset($formdata['user_name'])
 $this->savepersonalrow('user_name',isset($formdata['user_name']), $id);
 $this->savepersonalrow('nationality',isset($formdata['nationality']), $id);
 */
    // DB::transaction(function ( ) use( $formdata ,$id){
     
  //image 
   
  $imginputservices = InputService::where('service_id',$service_id)->whereHas('input', function ( $query) {
    $query->where('type', 'image');
})->get();    

if($formValue){
//image selected

if($imginputservices->isEmpty()){
//create new
$input=new Input();
$input->type='image';
$input->name='image'; 
$input->image_count=$imgcount;

$input->ispersonal=0;
$input->tooltipe="";
$input->icon="";
$input->save(); 

$inputservice = new InputService();
$inputservice->service_id=$service_id;
$inputservice->input_id= $input->id;
$inputservice->save();

}else{
 //update old new
  Input::find( $imginputservices->first()->input_id)->update([
    'image_count'=>  $imgcount,      
  ]);
}

}else{
//image not selected 
if( !$imginputservices->isEmpty()){
  $deleted =InputService::find($imginputservices->first()->id)->delete();
$deleted =Input::find($imginputservices->first()->input_id)->delete();

}

}
 // });
    
      return response()->json("ok");
      
    
    }
    public function savepersonalrow($fieldname,$formValue, $service_id)
    {   
    // 
     DB::transaction(function ( ) use( $fieldname,$formValue , $service_id){
    $input=Input::where('name',$fieldname)->where('ispersonal',1)->first();

   if($formValue){
   
    $inputservice = InputService::updateOrCreate(
      ['service_id' =>$service_id, 'input_id' => $input->id] 
  );
   }else{
   
    $deleted = InputService::where('service_id',$service_id)->where('input_id', $input->id)->delete();
   }
  
  });
     
      return 1;
      
    
    }

    public function savefield(StoreInputRequest $request, $id)
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

    } else
     {
      DB::transaction(function ()use($formdata,$request,$id) {     
   $inpctrlr=new   InputController();
     // $imagemodel = Expert::find($id);php artisan make:request Admin/Category/StoreCategory TransRequest
/*
  'name',
'type',
'tooltipe',
'icon',
'ispersonal',
'is_active',
        'image_count' , 
*/
//save input
     $newObj = new Input;
     $newObj->name = $formdata['field_name'];
     $newObj->type = $formdata['field_type'];
     $newObj->tooltipe = $formdata['field_tooltipe'];
     $newObj->ispersonal =0;
     $newObj->is_active = 1;
     $newObj->image_count=0;   
     $newObj->save();  

     if ($request->hasFile('field_icon')) {
       $file = $request->file('field_icon');                    
      $inpctrlr->storeSvg($file, $newObj->id);       
     }
         //save options
         if($formdata['field_type']=='list'){     
          foreach($formdata['list_option'] as $option){
            if(!is_null($option)){
              $inputvalue=new Inputvalue();
              $inputvalue->value= $option;
              $inputvalue->input_id=$newObj->id;
              $inputvalue->is_active=1;
              $inputvalue->save();
            }      
               } 
       }
       //end save options
     //end save input
     //save inputs_services
$inputservice=new InputService();
$inputservice->service_id=$id;
$inputservice->input_id=$newObj->id;
$inputservice->save();
     //end save inputs_services 
       
  // return response()->json(  $x);

});
return response()->json("ok");
    }//end else
    }
    public function showinputs($id)
    {
      $inpctrlr=new   InputController();
    
      $iconurlinput =url(Storage::url($inpctrlr->iconpath)).'/';
/*
      $object = Service::find($id) ;
 
   $personalinput=$object->inputservices()->with('input')->get() ;
   $personal_array=['user_name'=>0,
   'nationality'=>0,
   'gender'=>0,
   'birthdate'=>0,
   'marital_status'=>0,
    ];
    $recimg_array=['record'=>0,
    'image'=>0,
    'image_count'=>0,
     
     ];
 
 //return  $personal_array;
//   $personalinputf= $object->inputservices()->first()->input()->get();
   //   return    $personalinput ;
    //  $object->inputservices->Input;
      if( $object->image !="" ){
        $object->fullpathimg= $url.$object->image;
      }
      if( $object->icon !="" ){
        $object->fullpathsvg= $iconurl.$object->icon;
      }
      */
      //
      $object = Service::find($id) ;
 
  // $personalinput=$object->inputservices()->with('input')->get() ;
   
 
   $fieldinputs = Service::find($id)->inputservices->load([
        'input'=>function($q)use($iconurlinput){
        $q->where('ispersonal',0)->whereNotIn('type', ['record','image'])
        ->select('id','name',
        'type',
        'tooltipe',
       // 'icon',       
DB::raw("(CASE 
WHEN icon = '' THEN ''                     
ELSE CONCAT('$iconurlinput',icon)
END) AS icon"),
        'image_count',
        'ispersonal');
            }  ,
            'input.inputvalues'=>function($q){
                $q->select('id', 'value','input_id');
                    }  
]
);
 
//return response()->json($fieldinputs);
     return view('admin.input.inputservice', ['fieldinputs'=>$fieldinputs]);
    }

}
