<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\ValueService;
class ValueServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
      $imagemodel = ValueService::find($id);
      $oldimage = $imagemodel->image;
      $oldimagename = basename($oldimage);
      $strgCtrlr=new StorageController();
      $path=$strgCtrlr->path['values_services'];
     // $oldimagepath = $path . '/' . $oldimagename;
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
        ValueService::find($id)->update([
          "value" => $filename
        ]);
        Storage::delete("public/" .  $path . '/' . $oldimagename);
      }
      return 1;
    }

    public function storerecord($file, $id)
    {
      $imagemodel = ValueService::find($id);
      $oldimage = $imagemodel->value;
      $oldimagename = basename($oldimage);
      $strgCtrlr=new StorageController();
      $recpath=$strgCtrlr->recordpath['values_services'];
  //    $oldimagepath = $recpath . '/' . $oldimagename;
      //save photo
  
      if ($file !== null) {
        $filename= rand(10000, 99999). $id .".".$file->getClientOriginalExtension();
   
     //   $manager = new ImageManager(new Driver());
     //   $image = $manager->read($file);
        
        if (!File::isDirectory(Storage::url('/' . $recpath))) {
          Storage::makeDirectory('public/' . $recpath);
        }
        $path =$file->storeAs(
          $recpath, $filename,'public'
      );

       // $image->save(storage_path('app/public') . '/' . $this->iconpath . '/' . $filename);
        //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
        ValueService::find($id)->update([
          "value" => $filename
        ]);
        Storage::delete("public/" . $recpath . '/' . $oldimagename);
      }
      return 1;
    }
}
