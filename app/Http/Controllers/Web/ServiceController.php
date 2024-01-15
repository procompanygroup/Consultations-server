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
    public $path = 'media/services';
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
      return view('admin.service.add');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $formdata = $request->all();
      $validator = Validator::make(
        $formdata,
        $request->rules(),
        $request->messages()
      );
  
      if ($validator->fails()) {
  
        return redirect()->back()->withErrors($validator)
          ->withInput();
  
      } else {
       
        $newObj = new Service;
 
        $newObj->name = $formdata['name'];
        $newObj->desc = $formdata['desc'];
      //  $newObj->image = $formdata['image'];
        $newObj->createuser_id =  Auth::user()->id;
        $newObj->updateuser_id = Auth::user()->id;
        $newObj->is_active = $formdata['is_active'];
  
        $newObj->save();
        //save image
      //  $this->path = 'media/services';
        $separator = '/';
        if ($request->hasFile('image')) {
          // $imagemodel->save();
          $image_tmp = $request->file('image');
          if ($image_tmp->isValid()) {
            $folderpath = $this->path . $separator;
            //Get image Extension
            $extension = $image_tmp->getClientOriginalExtension();
            //Generate new Image Name
  
            $now = Carbon::now();
            $imageName = rand(10000, 99999) . $newObj->id . '.' . $extension;
  
            if (!File::isDirectory($folderpath)) {
              File::makeDirectory($folderpath, 0777, true, true);
            }
            $imagePath = $folderpath . $imageName;
            //Upload the Image
            $manager = new ImageManager(new Driver());
  
            // read image from filesystem
            $image = $manager->read($image_tmp);
            //$image= $image->toWebp(75);
            $image->save($imagePath);
            //$fullpath= url($imagePath);
  
            Service::find($newObj->id)->update([
              "image" => $imageName
            ]);
  
            // if(File::exists($oldimagepath )){
            //   File::delete($oldimagepath );
            // }
          }
        }
  
        return redirect()->back()->with('success_message', 'user has been Added!');
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
      $object = DB::table('services')->find($id);
  
      //
      return view('admin.service.edit', ['service' => $object]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
        $imagemodel = Service::find($id);
        $oldimage = $imagemodel->image;
        Service::find($id)->update([
            'name' => $formdata['name'],
            'desc' => $formdata['desc'],
          //  'image' => $formdata['image'],
          
            'updateuser_id' =>Auth::user()->id,
            'is_active' => $formdata['is_active'],
            
        ]);
        //save image
  
        $separator = '/';
        if ($request->hasFile('image')) {
          // $imagemodel->save();
          $image_tmp = $request->file('image');
          if ($image_tmp->isValid()) {
            $folderpath = $this->path . $separator;
            //Get image Extension
            $extension = $image_tmp->getClientOriginalExtension();
            //Generate new Image Name
            $now = Carbon::now();
            $imageName = rand(10000, 99999) . $id . '.' . $extension;
            if (!File::isDirectory($folderpath)) {
              File::makeDirectory($folderpath, 0777, true, true);
            }
            $imagePath = $folderpath . $imageName;
            //Upload the Image
            $manager = new ImageManager(new Driver());
            // read image from filesystem
            $image = $manager->read($image_tmp);
            //$image= $image->toWebp(75);
            $image->save($imagePath);
            Service::find($id)->update([
              "image" => $imageName
            ]);
  
            //  delete old image
            $oldimagepath = $this->path . $separator . $oldimage;
            if (File::exists($oldimagepath)) {
              File::delete($oldimagepath);
            }
            return redirect()->back()->with('success_message', 'user has been Updated!');
          }
        }
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
  Servicefavorite::where('service_id', $id)->delete();
  Permission::where('service_id', $id)->delete();
  //delete object
  Service::find($id)->delete();
        }
      }
      return redirect()->route('admin.service.show');
      //   return  $this->index();
      // 
   
      //   return redirect()->route('users.index');
  
    }
}
