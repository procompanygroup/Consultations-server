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

    public function index()
    {

        $url = url('storage/app/public' . '/' . $this->path) . '/';
        $list = DB::table('services')->where('is_active',1)->select(
            'name',
            'desc',
            'is_active',
            'icon',
           // DB::raw("CONCAT('$url',image)  AS image1"),
            DB::raw("(CASE 
            WHEN services.image = '' THEN ''                     
            ELSE CONCAT('$url',image)
            END) AS image")
        )->get();
/*
DB::raw("(CASE 
            WHEN services.image = ''THEN ''   
            WHEN services.image IS NULL THEN ''              
            ELSE CONCAT('$url',image)
            END) AS image")
*/
        return response()->json([
            'services' => $list,
        ]);
        //return response()->json($users);
    }
    public function getinputserviceform()
    {
        $data = request(['id']);
        $url = url('storage/app/public' . '/' . $this->path) . '/';
         /*
        $service = Service::find($data['id'])->with('inputservices.input')
        ->first();
         */
      
$service = Service::find($data['id'])->select('id',
'name',
'desc',
DB::raw("(CASE 
WHEN services.image = '' THEN ''                     
ELSE CONCAT('$url',image)
END) AS image"),
'icon')->first()->load(
    ['inputservices'=>function($q){
$q->select('id','input_id','service_id');
        }    ,
        'inputservices.input'=>function($q){
        $q->select('id','name',
        'type',
        'tooltipe',
        'icon',
        'ispersonal');
            }  ,
            'inputservices.input.inputvalues'=>function($q){
                $q->select('id', 'value','input_id');
                    }  
]
);

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
return response()->json([
            'service' =>  $service,
        ]);
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
