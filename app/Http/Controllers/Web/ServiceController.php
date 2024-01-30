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

use App\Models\Pointtransfer;
use App\Models\Selectedservice;
use App\Models\ExpertService;
use App\Models\InputService;
use App\Models\Servicefavorite;
use App\Models\Permission;
use Illuminate\Support\Facades\Storage;
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
      $list = DB::table('services')->get();
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
    public function edit(string $id)
    {
      $url =url(Storage::url($this->path)).'/';
      $iconurl =url(Storage::url($this->iconpath)).'/';
      $object = Service::find($id);
      if( $object->image !="" ){
        $object->fullpathimg= $url.$object->image;
      }
      if( $object->icon !="" ){
        $object->fullpathsvg= $iconurl.$object->icon;
      }
      //
      return view('admin.service.edit', ['service' => $object]);
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
      return redirect()->back()->withErrors($validator)
        ->withInput();

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
}
