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
    public function edit($id)
    {
      $object = Input::with('inputvalues')->find($id);
      //->with('inputvalues')->get();
   // $object->inputvalues ;
      //
    //  return response()->json(  $object);
 return view('admin.input.edit', ['input' => $object]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInputRequest $request, $id)
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

        DB::transaction(function ()use($formdata,$request,$id) {  
        $oldObj = Input::find($id);
       $oldtype=$oldObj->type;
       //delete  old options
if(  $oldtype=="list"  ){
 $res= Inputvalue::where('input_id',$id)->delete();
}
         if ($request->hasFile('field_icon_edit')) {
          $file = $request->file('field_icon_edit');
          // $filename= $file->getClientOriginalName();               
          $this->storeSvg($file,$id);
          //  $this->storeImage( $file,2);
        }
        Input::find($id)->update([
          'name' => $formdata['field_name_edit'],
          'type' => $formdata['field_type_edit'],
          'tooltipe' => $formdata['field_tooltipe_edit'],
         // 'icon' => $formdata['field_icon_edit'],
       // 'ispersonal' =>0,
         // 'is_active' =>1,
          
          
      ]);

      if($formdata['field_type_edit']=="list"){
//creat or update
foreach($formdata['list_option'] as $option){
  if(!is_null($option)){
    $inputvalue=new Inputvalue();
    $inputvalue->value= $option;
    $inputvalue->input_id=$id;
    $inputvalue->is_active=1;
    $inputvalue->save();
  }      
     } 
      }
       });
        return response()->json("ok");
        
      }
        /*
        Input::find($id)->update([
            'name' => $formdata['name'],
            'type' => $formdata['type'],
            'tooltipe' => $formdata['tooltipe'],
            'icon' => $formdata['icon'],
          //  'ispersonal' => $formdata['ispersonal'],
            'is_active' => $formdata['is_active'],
            
            
        ]);
      */
     
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
