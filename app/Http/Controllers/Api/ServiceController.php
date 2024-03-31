<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\InputController;
use App\Http\Controllers\Api\StorageController;
/*
use App\Http\Requests\Web\Service\StoreServiceRequest;
use App\Http\Requests\Web\Service\UpdateServiceRequest;
*/

/*
use App\Models\Selectedservice;
use App\Models\ExpertService;
use App\Models\InputService;
use App\Models\Servicefavorite;
use App\Models\Permission;
*/
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $path = 'images/services';
    public $iconpath = 'images/services/icons';
    public function index()
    {
       // $url =url(Storage::url($this->path)).'/';
     //   $iconurl =url(Storage::url($this->iconpath)).'/';
        $strgCtrlr=new StorageController();
        $url=$strgCtrlr->ServicePath('image');
        $iconurl=$strgCtrlr->ServicePath('icon');
        $defaultimg=$strgCtrlr->DefaultPath('image');
        $defaultsvg=$strgCtrlr->DefaultPath('icon');
      //  $url = url('storage/app/public' . '/' . $this->path) . '/';
        $list = DB::table('services')->where('is_active',1)->select('id',
            'name',    
          DB::raw("(CASE 
          WHEN services.desc is NULL THEN ''                  
         ELSE services.desc END) AS 'desc'"),
            'is_active',
            'is_callservice',           
           // DB::raw("CONCAT('$url',image)  AS image1"),
            DB::raw("(CASE 
            WHEN services.image is NULL THEN '$defaultimg'                  
            ELSE CONCAT('$url',image)
            END) AS image"),
            DB::raw("(CASE 
            WHEN services.icon is NULL THEN '$defaultsvg'                    
            ELSE CONCAT('$iconurl',icon)
            END) AS icon")
        )->orderBy('is_callservice')->get();
/*
DB::raw("(CASE 
            WHEN services.image = ''THEN ''   
            WHEN services.image IS NULL THEN ''              
            ELSE CONCAT('$url',image)
            END) AS image")
*/
        return response()->json($list);
        //return response()->json($users);
    }
    public function getinputserviceform()
    {
        $data = request(['id']);
     //   $url =url(Storage::url($this->path)).'/';
      //  $iconurl =url(Storage::url($this->iconpath)).'/';
        $strgCtrlr=new StorageController();
        $url=$strgCtrlr->ServicePath('image');
        $iconurl=$strgCtrlr->ServicePath('icon');
       
       // $url = url('storage/app/public' . '/' . $this->path) . '/';
         /*
        $service = Service::find($data['id'])->with('inputservices.input')
        ->first();
         */
    //  $inputctrlr=new InputController();
     // $urlinput =url(Storage::url($inputctrlr->path)).'/';
   //   $iconurlinput =url(Storage::url($inputctrlr->iconpath)).'/';
   $iconurlinput =$strgCtrlr->InputPath('icon');
   $defaultimg=$strgCtrlr->DefaultPath('image');
   $defaultsvg=$strgCtrlr->DefaultPath('icon');
$service = Service::select('id',
'name',
DB::raw("(CASE 
WHEN services.desc is NULL THEN ''                  
ELSE services.desc END) AS 'desc'"),
DB::raw("(CASE 
WHEN services.image is NULL THEN '$defaultimg'                 
ELSE CONCAT('$url',image)
END) AS image"),
//'icon',
DB::raw("(CASE 
WHEN services.icon is NULL THEN '$defaultsvg'                     
ELSE CONCAT('$iconurl',icon)
END) AS icon"),)->find($data['id'])->load(
    ['inputservices'=>function($q){
$q->select('id','input_id','service_id');
        }    ,
        'inputservices.input'=>function($q)use($iconurlinput,$defaultsvg){
        $q->select('id','name',
        'type',
        'tooltipe',
       // 'icon',       
DB::raw("(CASE 
WHEN icon is NULL THEN '$defaultsvg'                    
ELSE CONCAT('$iconurlinput',icon)
END) AS icon"),
        'image_count',
        'ispersonal');
            }  ,
            'inputservices.input.inputvalues'=>function($q){
                $q->select('id', 'value','input_id');
                    }  
]
)
 ;

  /*
   $service = Service::find($data['id'])->select('id',
   'name',
   'desc',
   DB::raw("(CASE 
   WHEN services.image = '' THEN ''                     
   ELSE CONCAT('$url',image)
   END) AS image"),
   'icon')->first()->load(
       ['inputservices'=>
          function($q){
            $q->with([            
                'input' => function ($query) {
                    $query->select('id','name',
                    'type',
                    'tooltipe',
                    'icon',
                    'ispersonal');
                },
            ]);
$q->select( 'id','input_id','service_id');
           }  
   ]);
   */
return response()->json($service);
        //return response()->json($users);
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
}
