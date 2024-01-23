<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Client;
use File;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

/*
use App\Http\Requests\Web\Client\StoreClientRequest;
use App\Http\Requests\Web\Client\UpdateClientRequest;
use App\Models\Pointtransfer;
use App\Models\Cashtransfer;
use App\Models\Expertfavorite;
use App\Models\Servicefavorite;
use App\Models\Selectedservice;
*/
class ClientController extends Controller
{

    public $path = 'images/clients';
   
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
    public function getbymobile()
    {


        $credentials = request(['mobile']);
    // $url = url('storage/app/public' . '/' . $this->path  ).'/';
    $url =url( Storage::url($this->path)).'/';
        $user = Client::where('mobile', $credentials)->select(
            'id',
            'user_name',
            'mobile',
            'email',
            'nationality',
            'birthdate',
            'gender',
            'marital_status',             
            'is_active',
            DB::raw("CONCAT('$url',image)  AS image")
        )->first();

        $authuser = auth()->user();
        //  return response()->json(['form' =>  $credentials]);
        if (!is_null($user)) {
            if (!($user->mobile == $authuser->mobile)) {
                return response()->json(['error' => 'notexist'], 401);
            }

        } else {
            return response()->json(['error' => 'notexist'], 401);
        }

        return response()->json([
            'client' => $user,
        ]);


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
    public function addUser(Client $newUClient)
    {
        $newUClient->save();
        return $newUClient;
    }
    public function storeImage($file, $id)
    {
        $imagemodel = Client::find($id);
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
        //    $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
            Client::find($id)->update([
                "image" => $filename
            ]);
            Storage::delete("public/" . $this->path . '/' . $oldimagename);
         
        }
        return 1;
    }
}
