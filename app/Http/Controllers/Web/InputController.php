<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\DB;
use App\Models\Input;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Input\StoreInputRequest;
use App\Http\Requests\Web\Input\UpdateInputRequest;
use App\Models\Inputvalue;
use App\Models\InputService;

use Illuminate\Support\Facades\Storage;
class InputController extends Controller
{
  public $path = 'images/inputs';
  public $iconpath = 'images/inputs/icons';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $list = DB::table('inputs')->get();
      return view('admin.input.show', ['inputs' => $list]);
      //return response()->json($users);
  
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.input.add');
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
       
        $newObj = new Input;
 
        $newObj->name = $formdata['name'];
        $newObj->type = $formdata['type'];
        $newObj->tooltipe = $formdata['tooltipe'];
        $newObj->icon = $formdata['icon'];
    //    $newObj->ispersonal = $formdata['ispersonal'];
        $newObj->is_active = $formdata['is_active'];
       
        $newObj->save();
        //save image
      //  $this->path = 'media/inputs';
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
  
            Input::find($newObj->id)->update([
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
      $object = DB::table('inputs')->find($id);
  
      //
      return view('admin.input.edit', ['input' => $object]);
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
        $imagemodel = Input::find($id);
        $oldimage = $imagemodel->image;
        Input::find($id)->update([
            'name' => $formdata['name'],
            'type' => $formdata['type'],
            'tooltipe' => $formdata['tooltipe'],
            'icon' => $formdata['icon'],
          //  'ispersonal' => $formdata['ispersonal'],
            'is_active' => $formdata['is_active'],
            
            
        ]);
      
      }
      return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
     // return response()->json($id);
     $object = Input::find($id);
      if (!($object === null)) {
         //delete image
         $oldiconname=$object->icon;
         Storage::delete("public/" . $this->iconpath . '/' . $oldiconname);

        InputService::where('input_id', $id)->delete();
        Inputvalue::where('input_id', $id)->delete();
        Input::find($id)->delete();

 /*
        //delete check related tables
       
       // $item1 =  Inputvalue::where('input_id', $id)->first();       
        $item2 = InputService::where('input_id', $id)->first();
        if (
          !($item1 === null) || !($item2 === null)) {
          // disable input account
          Input::find($id)->update([
            "is_active" => 0
          ]);
        } else {        
  //delete related rows
    
          Inputvalue::where('input_id', $id)->delete();
          InputService::where('input_id', $id)->delete();
       
          //delete object
          Input::find($id)->delete();
        }
        */
      }
      return response()->json("ok");
 
  
    }
    public function storeSvg($file, $id)
    {
      $imagemodel = Input::find($id);
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
        Input::find($id)->update([
          "icon" => $filename
        ]);
        Storage::delete("public/" . $this->iconpath . '/' . $oldimagename);
      }
      return 1;
    }
}
