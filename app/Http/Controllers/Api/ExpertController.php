<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Pointtransfer;
use App\Models\Cashtransfer;
use App\Models\Selectedservice;
use Illuminate\Http\Request;
use App\Models\Expert;
use App\Models\Expertfavorite;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

use File;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Http\Controllers\Api\ServiceController;
use App\Models\Service;
use App\Http\Controllers\Api\StorageController;
use App\Http\Requests\Api\Expertfavorite\StoreRequest;
use App\Http\Requests\Api\Expert\UpdateExpertRequest;
use App\Http\Requests\Api\Expert\UploadAnswerRequest;
use App\Http\Requests\Api\Expert\UploadRecordRequest;
use App\Http\Requests\Api\Expert\PullBalanceRequest;
use App\Http\Requests\Api\Expert\SaveTokenRequest;
use App\Http\Requests\Api\Expert\StatisticRequest;
use App\Http\Requests\Api\Expertfavorite\StoreExpertRequest;


class ExpertController extends Controller
{

    //  public $path = 'images/experts';
    // public $recordpath = 'images/experts/records';
    /**
     * Display a listing of the resource.
     */
    public $id = 0;
    public $pointtransfer_id = 0;

    public function index()
    {
        $users = DB::table('experts')->get();
        // return view('admin.user.showusers',['users' => $users]); 
        return response()->json($users);
    }
    public function getexpert()
    {
        //  $credentials = request(['user_name','password']);
        //   $url = url(Storage::url($this->path)) . '/';
        // $url = url('storage/app/public' . '/' . $this->path  ).'/';
        //  $pass=request(['password']);
        //   $passval=$pass['password'];
        // $passhash=bcrypt($passval);
        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ExpertPath('image');
        $recurl = $strgCtrlr->ExpertPath('record');
        $defaultimg = $strgCtrlr->DefaultPath('image');
        $user = Expert::where('user_name', request(['user_name']))->
            where('is_active', 1)->
            select(
                'id',
                'user_name',
                'password',
                'mobile',
                'country_num',
                'mobile_num',
                'email',
                //  'nationality',
                'birthdate',
                'gender',
                //  'marital_status',
                'is_active',
                'points_balance',
                'cash_balance',
                'cash_balance_todate',
                'rates',
                DB::raw("(CASE 
            WHEN record is NULL THEN ''                  
            ELSE CONCAT('$recurl',record)
            END) AS record"),
                //  'desc',                   
                DB::raw("(CASE 
          WHEN experts.desc is NULL THEN ''                  
         ELSE experts.desc END) AS 'desc'"),
                'call_cost',
                'answer_speed',
                DB::raw("(CASE 
            WHEN image is NULL THEN '$defaultimg'                    
            ELSE CONCAT('$url',image)
            END) AS image"),
                'first_name',
                'last_name',
            )->first();

        $authuser = auth()->user();
        //  return response()->json(['form' =>  $credentials]);
        if (!is_null($user)) {
            if (
                !(($user->user_name == $authuser->user_name)
                    // && (Hash::check( $passval, $user->password))
                )
            ) {
                return response()->json('notexist', 401);
            }

        } else {
            return response()->json('notexist', 401);
        }

        return response()->json($user);
    }


    public function getwithcomments()
    {
        $data = request(['id']);
        $id = $data['id'];
        $authuser = auth()->user();
        $client_id = $authuser->id;
        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ExpertPath('image');
        $recurl = $strgCtrlr->ExpertPath('record');
        $defaultimg = $strgCtrlr->DefaultPath('image');

        $serviceUrl = $strgCtrlr->ServicePath('image');
        $iconurl = $strgCtrlr->ServicePath('icon');
        $defaultsvg = $strgCtrlr->DefaultPath('icon');

        $clientUrl = $strgCtrlr->ClientPath('image');

        $clienids = Selectedservice::where('expert_id', $id)->where('comment_state', 'agree')
            ->wherehas('client', function ($query) {
                $query->where('is_active', 1);
            })->groupBy('client_id')->select('client_id')->get()
        ;


        $selectList = Selectedservice::where('expert_id', $id)->where('comment_state', 'agree')
            ->wherehas('client', function ($query) {
                $query->where('is_active', 1);
            })->orderBy('client_id')->orderByDesc('comment_date')
            ->select('id', 'expert_id', 'service_id', 'client_id', 'comment', 'comment_state', 'comment_date')
            ->get();

        $seletedserviceidlist = [];
        $seletedserviceidlist = $this->idlist($clienids, $selectList);

        $expertDB = Expert::
            //where('password',  $passhash)->
            select(
                'id',
                'user_name',
                'first_name',
                'last_name',
                //   'password',
                // 'mobile',
                // 'email',
                //  'nationality',
                // 'birthdate',
                //   'gender',
                //  'marital_status',
                'is_active',
                //  'points_balance',
                // 'cash_balance',
                //   'cash_balance_todate',
                'rates',
                DB::raw("(CASE 
            WHEN record is NULL THEN ''                  
            ELSE CONCAT('$recurl',record)
            END) AS record"),
                //  'desc',                   
                DB::raw("(CASE 
          WHEN  experts.desc is NULL THEN ''                  
         ELSE experts.desc END) AS 'desc'"),
                // 'call_cost',
                //  'answer_speed',
                DB::raw("(CASE 
            WHEN image is NULL THEN '$defaultimg'                    
            ELSE CONCAT('$url',image)
            END) AS image")
            )->with(
                [
                    'expertsServices:id,expert_id,service_id',
                    'expertsServices.service' => function ($q) use ($defaultimg, $serviceUrl, $defaultsvg, $iconurl) {
                        $q->select(
                            'id',
                            'name',
                            DB::raw("(CASE 
                WHEN services.image is NULL THEN '$defaultimg'                  
                ELSE CONCAT('$serviceUrl',image)
                END) AS image"),
                            DB::raw("(CASE 
                WHEN services.icon is NULL THEN '$defaultsvg'                    
                ELSE CONCAT('$iconurl',icon)
                END) AS icon")
                        );
                    }
                    ,
                    'selectedservices' => function ($q) use ($seletedserviceidlist) {

                        $q
                            ->whereIn('id', $seletedserviceidlist)
                            ->select('id', 'expert_id', 'service_id', 'client_id', 'comment', 'comment_state', 'comment_date')
                            ->orderByDesc('comment_date');
                        /*
                        $q->each(function(Selectedservice $item) {
                            $item->makeHidden(['comment_state_conv']);
                        });
                        */
                        /*
                        $q->where('comment_state', 'agree')
                         ->wherehas('client', function ($query){
                            $query->where('is_active',1);
                        })                 
                   */

                        /*
                                          $q->where('comment_state', 'agree')
                                          ->wherehas('client', function ($query){
                                             $query->where('is_active',1);
                                         }) ->orderBy('client_id')->orderByDesc('comment_date')
                                         ->select('id', 'expert_id', 'service_id', 'client_id', 'comment', 'comment_state', 'comment_date') 
                                         ->get() ;
                                         */
                        //->get()
                        //  ->makeHidden(['form_state_conv','answer_state','answer_state_conv','comment_state_conv','answers'])
            
                        /*
                        $Comment  = Selectedservice::whereIn(DB::raw('(comment_date, client_id)'), function ($query) use ($latestComments) {
                          $query->selectRaw('MAX(comment_date) as latest_comment_date, client_id')
                                ->fromSub($latestComments, 'latest_comments')
                                ->groupBy('client_id');
                      })
                      ->get();
                      */

                    }
                    ,
                    'selectedservices.client' => function ($q) use ($defaultimg, $clientUrl) {
                        $q->select(
                            'id',
                            'user_name',
                            DB::raw("(CASE 
                WHEN clients.image is NULL THEN '$defaultimg'                  
                ELSE CONCAT('$clientUrl',image)
                END) AS image")
                        );
                    },
                    'expertsFavorites' => function ($q) use ($client_id) {
                        $q->where('client_id', $client_id)->select('id', 'client_id', 'expert_id');
                    }
                ]
            )
            ->where('id', $id)->where('is_active', 1)->first();//find($id);
        /// map 
        $expert = $this->experttoArr($expertDB);

        return response()->json($expert);

    }
    public function getexpertwithcomments()
    {
        $data = request(['expert_id']);
        $id = $data['expert_id'];


        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ExpertPath('image');
        $recurl = $strgCtrlr->ExpertPath('record');
        $defaultimg = $strgCtrlr->DefaultPath('image');

        $serviceUrl = $strgCtrlr->ServicePath('image');
        $iconurl = $strgCtrlr->ServicePath('icon');
        $defaultsvg = $strgCtrlr->DefaultPath('icon');

        $clientUrl = $strgCtrlr->ClientPath('image');

        $clienids = Selectedservice::where('expert_id', $id)->where('comment_state', 'agree')
            ->wherehas('client', function ($query) {
                $query->where('is_active', 1);
            })->groupBy('client_id')->select('client_id')->get()
        ;


        $selectList = Selectedservice::where('expert_id', $id)->where('comment_state', 'agree')
            ->wherehas('client', function ($query) {
                $query->where('is_active', 1);
            })->orderBy('client_id')->orderByDesc('comment_date')
            ->select('id', 'expert_id', 'service_id', 'client_id', 'comment', 'comment_state', 'comment_date')
            ->get();

        $seletedserviceidlist = [];
        $seletedserviceidlist = $this->idlist($clienids, $selectList);

        $expertDB = Expert::

            select(
                'id',
                'user_name',
                'first_name',
                'last_name',
                //   'password',
                // 'mobile',
                // 'email',
                //  'nationality',
                // 'birthdate',
                //   'gender',
                //  'marital_status',
                'is_active',
                //  'points_balance',
                // 'cash_balance',
                //   'cash_balance_todate',
                'rates',
                DB::raw("(CASE 
            WHEN record is NULL THEN ''                  
            ELSE CONCAT('$recurl',record)
            END) AS record"),
                //  'desc',                   
                DB::raw("(CASE 
          WHEN  experts.desc is NULL THEN ''                  
         ELSE experts.desc END) AS 'desc'"),
                // 'call_cost',
                //  'answer_speed',
                DB::raw("(CASE 
            WHEN image is NULL THEN '$defaultimg'                    
            ELSE CONCAT('$url',image)
            END) AS image")
            )->with(
                [
                    'expertsServices:id,expert_id,service_id',
                    'expertsServices.service' => function ($q) use ($defaultimg, $serviceUrl, $defaultsvg, $iconurl) {
                        $q->select(
                            'id',
                            'name',
                            DB::raw("(CASE 
                WHEN services.image is NULL THEN '$defaultimg'                  
                ELSE CONCAT('$serviceUrl',image)
                END) AS image"),
                            DB::raw("(CASE 
                WHEN services.icon is NULL THEN '$defaultsvg'                    
                ELSE CONCAT('$iconurl',icon)
                END) AS icon")
                        );
                    }
                    ,
                    'selectedservices' => function ($q) use ($seletedserviceidlist) {

                        $q
                            ->whereIn('id', $seletedserviceidlist)
                            ->select('id', 'expert_id', 'service_id', 'client_id', 'comment', 'comment_state', 'comment_date')
                            ->orderByDesc('comment_date');


                    }
                    ,
                    'selectedservices.client' => function ($q) use ($defaultimg, $clientUrl) {
                        $q->select(
                            'id',
                            'user_name',
                            DB::raw("(CASE 
                WHEN clients.image is NULL THEN '$defaultimg'                  
                ELSE CONCAT('$clientUrl',image)
                END) AS image")
                        );
                    }
                ]
            )
            ->where('id', $id)->where('is_active', 1)->first();//find($id);
        /// map 
        $expert = $this->convtoArrForExpertapp($expertDB);

        return response()->json($expert);

    }
    public function idlist($clienids, $selectList)
    {
        $seletedserviceidlist = [];

        foreach ($clienids as $cid) {
            $id = $selectList->where('client_id', $cid['client_id'])->first()->id;
            $seletedserviceidlist[] = $id;
        }
        return $seletedserviceidlist;
    }



    public function getexpertsbyserviceid()
    {
        $data = request(['id']);
        $id = $data['id'];
        //  $url = url('storage/app/public' . '/' . $this->path  ).'/';
        // $url = url(Storage::url($this->path)) . '/';
        //  $recurl = url(Storage::url($this->recordpath)) . '/';
        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ExpertPath('image');
        $recurl = $strgCtrlr->ExpertPath('record');
        $defaultimg = $strgCtrlr->DefaultPath('image');
        //         $List = Expert::wherehas('expertsServices', function ($query) use ($id) {
//             $query->where('service_id', $id);
//             /*
//             $query->select(
//                 'id'
//                 'service_id',
//                 'expert_id',
//                 'points',
//                 'expert_cost',
//                 'cost_type',
//                 'expert_cost_value',
//             );
// */
//         })->with('expertsServices:id,service_id,expert_id,points,expert_cost,cost_type,expert_cost_value')
//             ->select(
//                 'id',
//                 'user_name',
//                 'mobile',
//                 'email',
//                 'nationality',
//                 'birthdate',
//                 'gender',
//                 'marital_status',
//                 'is_active',
//                 'points_balance',
//                 'cash_balance',
//                 'cash_balance_todate',
//                 'rates',

        //                 DB::raw("(CASE 
//                 WHEN record = '' THEN ''                     
//                 ELSE CONCAT('$recurl',record)
//                 END) AS record"),
//                 'desc',
//                 'call_cost',
//                 'answer_speed',
//                 DB::raw("(CASE 
//                 WHEN image = '' THEN ''                     
//                 ELSE CONCAT('$url',image)
//                 END) AS image")
//             )->get();


        $List = Expert::with([
            'expertsServices' => function ($q) use ($id) {
                $q->where('service_id', $id)
                    ->select('id', 'service_id', 'expert_id', 'points', 'expert_cost', 'cost_type', 'expert_cost_value');
            }
        ])
            ->select(
                'id',
                'user_name',
                'mobile',
                'country_num',
                'mobile_num',
                'email',
                // 'nationality',
                'birthdate',
                'gender',
                // 'marital_status',
                'is_active',
                'points_balance',
                'cash_balance',
                'cash_balance_todate',
                'rates',
                DB::raw("(CASE 
            WHEN record  is NULL THEN ''                  
            ELSE CONCAT('$recurl',record)
            END) AS record"),
                // 'desc',
                DB::raw("(CASE 
            WHEN experts.desc is NULL THEN ''                  
           ELSE experts.desc END) AS 'desc'"),
                'call_cost',
                'answer_speed',
                DB::raw("(CASE 
            WHEN image  is NULL THEN '$defaultimg'                  
            ELSE CONCAT('$url',image)
            END) AS image")
            )->wherehas('expertsServices', function ($query) use ($id) {
                $query->where('service_id', $id);
            })->where('is_active', 1)->get();


        //  return response()->json(['form' =>  $credentials]);


        return response()->json($List);
    }
    public function addUser(Expert $newExpert)
    {
        $newExpert->save();
        return $newExpert;
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
    public function getwithfav()
    {
        $authuser = auth()->user();

        $data = request(['client_id']);
        $id = $data['client_id'];
        if ($authuser->id == $id) {

            $strgCtrlr = new StorageController();
            $url = $strgCtrlr->ExpertPath('image');
            $recurl = $strgCtrlr->ExpertPath('record');
            $service_url = $strgCtrlr->ServicePath('image');
            $service_icon_url = $strgCtrlr->ServicePath('icon');
            $defaultimg = $strgCtrlr->DefaultPath('image');
            $defaultsvg = $strgCtrlr->DefaultPath('icon');
            //     $url = url(Storage::url($this->path)) . '/';
            //   $recurl = url(Storage::url($this->recordpath)) . '/';


            // $servicectrlr = new ServiceController();
            // $servicepath = $servicectrlr->path;
            // $serviceiconpath = $servicectrlr->iconpath;
            //  $service_url = url(Storage::url($servicepath)) . '/';
            // $service_icon_url = url(Storage::url($serviceiconpath)) . '/';

            $DBList = Expert::
                with([
                    //'expertsServices.service',
                    //  'expertsServices',
                    'expertsFavorites' => function ($q) use ($id) {
                        $q->where('client_id', $id)->select('id', 'client_id', 'expert_id');
                    },
                    'expertsServices.service' => function ($q) {
                        $q->select(
                            'id',
                            'name',
                            'desc',
                            'image',
                            'icon',
                            'is_active',
                            'is_callservice'
                        );
                    }
                ])->where('is_active',1)->get();
            $collList = collect($DBList);

            $List = $DBList->map(function ($expert) use ($url, $recurl, $service_url, $service_icon_url, $defaultimg, $defaultsvg) {
                //expertsServicesMap
                $expertsServicesMap = $expert->expertsServices
                    ->map(function ($expertsServices) use ($service_url, $service_icon_url, $defaultimg, $defaultsvg) {

                        //ServiceMap 
                        // $ServiceMap1 = $expertsServices ->service->find($expertsServices->service_id)->first()->get();
    
                        //end   ServiceMap 
    
                        /*[
                            'id' => $expertsServices->id,
                            'expert_id' => $expertsServices->expert_id,
                            'service_id' => $expertsServices->service_id,
                            'points'=> $expertsServices->points,
                            'expert_cost'=>$expertsServices->expert_cost,
                            'cost_type'=> $expertsServices->cost_type,
                            'expert_cost_value'=>$expertsServices->expert_cost_value,
                         //   'service' => $expertsServices->service,
                         */
                        //  'service' =>
                        return $this->servicetoArray($expertsServices->service, $service_url, $service_icon_url, $defaultimg, $defaultsvg);
                        // ];
    
                    });
                // end expertsServicesMap
                return [
                    'id' => $expert->id,
                    'user_name' => $expert->user_name,
                    'mobile' => $expert->mobile,
                    'country_num' => $expert->country_num,
                    'mobile_num' => $expert->mobile_num,
                    'email' => $expert->email,
                    'birthdate' => $expert->birthdate,
                    'gender' => $expert->gender,

                    'is_active' => $expert->is_active,
                    'points_balance' => $expert->points_balance,
                    'cash_balance' => $expert->cash_balance,
                    'cash_balance_todate' => $expert->cash_balance_todate,
                    'rates' => $expert->rates,
                    'desc' => $expert->desc == null ? " " : $expert->desc,
                    'call_cost' => $expert->call_cost,
                    'answer_speed' => $expert->answer_speed,
                    'record' => $expert->record == null ? " " : $recurl . $expert->record,
                    'image' => $expert->image == null ? $defaultimg : $url . $expert->image,
                    'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,


                    //  'expertsFavorites' => $expert->expertsFavorites,
                    //  'expertsServices'=>$item->expertsServices,
                    'services' => $expertsServicesMap,

                ];
            });


            return response()->json($List);



        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function getexpertwithfav()
    {
        $authuser = auth()->user();

        $data = request(['expert_id']);
        $id = $data['expert_id'];
        if ($authuser->id == $id) {

            $strgCtrlr = new StorageController();
            $url = $strgCtrlr->ExpertPath('image');
            $recurl = $strgCtrlr->ExpertPath('record');
            $service_url = $strgCtrlr->ServicePath('image');
            $service_icon_url = $strgCtrlr->ServicePath('icon');
            $defaultimg = $strgCtrlr->DefaultPath('image');
            $defaultsvg = $strgCtrlr->DefaultPath('icon');
            //     $url = url(Storage::url($this->path)) . '/';
            //   $recurl = url(Storage::url($this->recordpath)) . '/';


            // $servicectrlr = new ServiceController();
            // $servicepath = $servicectrlr->path;
            // $serviceiconpath = $servicectrlr->iconpath;
            //  $service_url = url(Storage::url($servicepath)) . '/';
            // $service_icon_url = url(Storage::url($serviceiconpath)) . '/';

            $DBList = Expert::
                with([
                    //'expertsServices.service',
                    //  'expertsServices',
                    'expertsFavorites' => function ($q) use ($id) {
                        $q->where('login_expert_id', $id)->select('id', 'login_expert_id', 'expert_id');
                    },
                    'expertsServices.service' => function ($q) {
                        $q->select(
                            'id',
                            'name',
                            'desc',
                            'image',
                            'icon',
                            'is_active',
                            'is_callservice'
                        );
                    }
                ])->whereNot('id',$id)->where('is_active',1)->get();
            $collList = collect($DBList);

            $List = $DBList->map(function ($expert) use ($url, $recurl, $service_url, $service_icon_url, $defaultimg, $defaultsvg) {
                //expertsServicesMap
                $expertsServicesMap = $expert->expertsServices
                    ->map(function ($expertsServices) use ($service_url, $service_icon_url, $defaultimg, $defaultsvg) {

                        //ServiceMap 
                        // $ServiceMap1 = $expertsServices ->service->find($expertsServices->service_id)->first()->get();
    
                        //end   ServiceMap 
    
                        /*[
                            'id' => $expertsServices->id,
                            'expert_id' => $expertsServices->expert_id,
                            'service_id' => $expertsServices->service_id,
                            'points'=> $expertsServices->points,
                            'expert_cost'=>$expertsServices->expert_cost,
                            'cost_type'=> $expertsServices->cost_type,
                            'expert_cost_value'=>$expertsServices->expert_cost_value,
                         //   'service' => $expertsServices->service,
                         */
                        //  'service' =>
                        return $this->servicetoArray($expertsServices->service, $service_url, $service_icon_url, $defaultimg, $defaultsvg);
                        // ];
    
                    });
                // end expertsServicesMap
                return [
                    'id' => $expert->id,
                    'user_name' => $expert->user_name,
                    'first_name' => $expert->first_name ,
                    'last_name' => $expert->last_name ,
                    'full_name' => $expert->full_name ,
                    'mobile' => $expert->mobile,
                    'country_num' => $expert->country_num,
                    'mobile_num' => $expert->mobile_num,
                    'email' => $expert->email,
                    'birthdate' => $expert->birthdate,
                    'gender' => $expert->gender,

                    'is_active' => $expert->is_active,
                    'points_balance' => $expert->points_balance,
                    'cash_balance' => $expert->cash_balance,
                    'cash_balance_todate' => $expert->cash_balance_todate,
                    'rates' => $expert->rates,
                    'desc' => $expert->desc == null ? " " : $expert->desc,
                    'call_cost' => $expert->call_cost,
                    'answer_speed' => $expert->answer_speed,
                    'record' => $expert->record == null ? " " : $recurl . $expert->record,
                    'image' => $expert->image == null ? $defaultimg : $url . $expert->image,
                    'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,
                    

                    //  'expertsFavorites' => $expert->expertsFavorites,
                    //  'expertsServices'=>$item->expertsServices,
                    'services' => $expertsServicesMap,
                    

                ];
            });


            return response()->json($List);



        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
    public function servicetoArray($service, $service_url, $service_icon_url, $defaultimg, $defaultsvg)
    {

        return [
            "id" => $service->id,
            "name" => $service->name,
            'desc' => $service->desc == null ? " " : $service->desc,
            'image' => $service->image == null ? $defaultimg : $service_url . $service->image,
            'icon' => $service->icon == null ? $defaultsvg : $service_icon_url . $service->icon,
            'is_active' => $service->is_active,
            'is_callservice' => $service->is_callservice,
        ];
    }
    public function servicetoArr($service)
    {

        return [
            "id" => $service->id,
            "name" => $service->name,
            // 'desc' => $service->desc == null ? " " : $service->desc,
            'image' => $service->image,
            'icon' => $service->icon,
            //  'is_active' => $service->is_active,

        ];
    }
    public function experttoArr($expert)
    {
        if (is_null($expert)) {
            return $expert;
        } else {


            //start services
            $ServicesMap = $expert->expertsServices
                ->map(function ($expertsServices) {

                    //ServiceMap 
                    // $ServiceMap1 = $expertsServices ->service->find($expertsServices->service_id)->first()->get();
    
                    //end   ServiceMap 
    

                    return $this->servicetoArr($expertsServices->service);

                    // return $expertsServices->service;
                    // ];
    
                });
            //end services
/* for edit columns
   //start selectedservices
   $selectedservicesMap = $expert->selectedservices
   ->map(function ($selectedservices)   {       
   return [
    'id'=>$selectedservices->id,
    'expert_id'=>$selectedservices->expert_id,
    'service_id'=>$selectedservices->service_id,
    'client_id'=>$selectedservices->client_id,
    'comment'=>$selectedservices->comment,
    'comment_state'=>$selectedservices->comment_state,
    'comment_date'=>$selectedservices->comment_date,
    'client'=>$selectedservices->client,
   ];  
   });
   //end selectedservices
*/
            return [
                'id' => $expert->id,
                'user_name' => $expert->user_name,
                'first_name' => $expert->first_name,
                'last_name' => $expert->last_name,
                'is_active' => $expert->is_active,
                'rates' => $expert->rates,
                'record' => $expert->record,
                'desc' => $expert->desc,
                'image' => $expert->image,
                'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,
                'services' => $ServicesMap,

                //  'selectedservices' =>$selectedservicesMap,
                'selectedservices' => $expert->selectedservices->makeHidden(['title', 'answer_state', 'answers']),
                // 'selectedservices' => $expert->selectedservices->makeHidden(['comment_state_conv'])  ,
            ];
        }
    }
    public function convtoArrForExpertapp($expert)
    {
        if (is_null($expert)) {
            return $expert;
        } else {


            //start services
            $ServicesMap = $expert->expertsServices
                ->map(function ($expertsServices) {

                    //ServiceMap 
                    // $ServiceMap1 = $expertsServices ->service->find($expertsServices->service_id)->first()->get();
    
                    //end   ServiceMap 
    

                    return $this->servicetoArr($expertsServices->service);

                    // return $expertsServices->service;
                    // ];
    
                });
            //end services
/* for edit columns
   //start selectedservices
   $selectedservicesMap = $expert->selectedservices
   ->map(function ($selectedservices)   {       
   return [
    'id'=>$selectedservices->id,
    'expert_id'=>$selectedservices->expert_id,
    'service_id'=>$selectedservices->service_id,
    'client_id'=>$selectedservices->client_id,
    'comment'=>$selectedservices->comment,
    'comment_state'=>$selectedservices->comment_state,
    'comment_date'=>$selectedservices->comment_date,
    'client'=>$selectedservices->client,
   ];  
   });
   //end selectedservices
*/
            return [
                'id' => $expert->id,
                'user_name' => $expert->user_name,
                'first_name' => $expert->first_name,
                'last_name' => $expert->last_name,
                'is_active' => $expert->is_active,
                'rates' => $expert->rates,
                'record' => $expert->record,
                'desc' => $expert->desc,
                'image' => $expert->image,
                // 'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,
                'services' => $ServicesMap,

                //  'selectedservices' =>$selectedservicesMap,
                'selectedservices' => $expert->selectedservices->makeHidden(['title', 'answer_state', 'answers']),
                // 'selectedservices' => $expert->selectedservices->makeHidden(['comment_state_conv'])  ,
            ];
        }
    }
    public function expertforclientorder($expert)
    {
        if (is_null($expert)) {
            return $expert;
        } else {

            return [
                'id' => $expert->id,
                'user_name' => $expert->user_name,
                'rates' => $expert->rates,
                'is_active' => $expert->is_active,
                'first_name' => $expert->first_name,
                'last_name' => $expert->last_name,
                'image' => $expert->image,
                'full_name' => $expert->full_name,
                'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,
            ];
        }
    }

    public function getwithfavandExpServ()
    {
        $authuser = auth()->user();

        $data = request(['client_id']);
        $id = $data['client_id'];
        if ($authuser->id == $id) {

            //  $url = url(Storage::url($this->path)) . '/';
            //    $recurl = url(Storage::url($this->recordpath)) . '/';
            //  $servicectrlr = new ServiceController();
            //  $servicepath = $servicectrlr->path;
            // $serviceiconpath = $servicectrlr->iconpath;
            //    $service_url = url(Storage::url($servicepath)) . '/';
            //   $service_icon_url = url(Storage::url($serviceiconpath)) . '/';

            $strgCtrlr = new StorageController();
            $url = $strgCtrlr->ExpertPath('image');
            $recurl = $strgCtrlr->ExpertPath('record');
            $service_url = $strgCtrlr->ServicePath('image');
            $service_icon_url = $strgCtrlr->ServicePath('icon');
            $defaultimg = $strgCtrlr->DefaultPath('image');
            $defaultsvg = $strgCtrlr->DefaultPath('icon');
            $DBList = Expert::
                with([
                    'expertsServices.service',
                    //  'expertsServices',
                    'expertsFavorites' => function ($q) use ($id) {
                        $q->where('client_id', $id)->select('id', 'client_id', 'expert_id');
                    }
                ])->get();
            $collList = collect($DBList);

            $List = $DBList->map(function ($expert) use ($url, $recurl, $service_url, $service_icon_url, $defaultimg, $defaultsvg) {
                //expertsServicesMap
                $expertsServicesMap = $expert->expertsServices
                    ->map(function ($expertsServices) use ($service_url, $service_icon_url, $defaultimg, $defaultsvg) {

                        //ServiceMap 
                        $ServiceMap = $expertsServices->service->get()->map(function ($service) use ($service_url, $service_icon_url, $defaultimg, $defaultsvg) {
                            return [
                                'id' => $service->id,
                                'name' => $service->name,
                                'desc' => $service->desc == null ? " " : $service->desc,
                                'image' => $service->image == null ? $defaultimg : $service_url . $service->image,
                                'icon' => $service->icon == null ? $defaultsvg : $service_icon_url . $service->icon,
                                'is_active' => $service->is_active,
                                'is_callservice' => $service->is_callservice,
                            ];
                        });
                        //end   ServiceMap 
                        return [
                            'id' => $expertsServices->id,
                            'expert_id' => $expertsServices->expert_id,
                            'service_id' => $expertsServices->service_id,
                            'points' => $expertsServices->points,
                            'expert_cost' => $expertsServices->expert_cost,
                            'cost_type' => $expertsServices->cost_type,
                            'expert_cost_value' => $expertsServices->expert_cost_value,
                            'service' => $ServiceMap,

                        ];

                    });
                // end expertsServicesMap
                return [
                    'id' => $expert->id,
                    'user_name' => $expert->user_name,
                    'mobile' => $expert->mobile,
                    'country_num' => $expert->country_num,
                    'mobile_num' => $expert->mobile_num,
                    'email' => $expert->email,
                    'birthdate' => $expert->birthdate,
                    'gender' => $expert->gender,

                    'is_active' => $expert->is_active,
                    'points_balance' => $expert->points_balance,
                    'cash_balance' => $expert->cash_balance,
                    'cash_balance_todate' => $expert->cash_balance_todate,
                    'rates' => $expert->rates,
                    'desc' => $expert->desc == null ? " " : $expert->desc,
                    'call_cost' => $expert->call_cost,
                    'answer_speed' => $expert->answer_speed,
                    'record' => $expert->record == null ? "" : $recurl . $expert->record,
                    'image' => $expert->image == null ? $defaultimg : $url . $expert->image,
                    'is_favorite' => $expert->expertsFavorites->isEmpty() ? 0 : 1,

                    'expertsServices' => $expertsServicesMap,

                ];
            });


            /*
            $collList=collect($List)->map
            ->only(['id', 'user_name', 'mobile','expertsFavorites','expertsServices','expertsServices[service][id]']); 
             */
            /*
                   $List = DB::table('experts')
                       ->leftJoin('expertsfavorites', function ($join) use ($id) {
                           $join->on('experts.id', '=', 'expertsfavorites.expert_id')
                               ->where('expertsfavorites.client_id', '=', $id);
                       })
                  //    ->leftJoin('experts_services', 'experts.id', '=', 'experts_services.expert_id')
                      ->with('expertsServices')
                       ->select(
                           'experts.id',
                           'user_name',
                           'mobile',
                           'email',
                           'birthdate',
                           'gender',
                        //   'marital_status',
                           'is_active',
                           'points_balance',
                           'cash_balance',
                           'cash_balance_todate',
                           'rates',
                           'desc',
                           'call_cost',
                           'answer_speed',
                           DB::raw("(CASE 
                           WHEN experts.record = '' THEN ''                     
                           ELSE CONCAT('$recurl',experts.record)
                           END) AS record"),
                           DB::raw("(CASE 
                           WHEN experts.image = '' THEN ''                     
                           ELSE CONCAT('$url',experts.image)
                           END) AS image"),
                           DB::raw('IF(expertsfavorites.client_id IS NULL, 0, 1) AS is_favorite')
              
                      )
                     //  ->with('expertsServices.service')
                       ->get();
                        */
            //  $List=$List->with('expertsServices.service')->get();
            return response()->json($DBList);



        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function savefav()
    {
        $authuser = auth()->user();
        $request = request();

        $formdata = $request->all();

        $storrequest = new StoreRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {

            //   $data = json_decode($request->getContent(), true);            
            //   return response()->json([$client_id,$authuser->id]);
            if ($authuser->id == $formdata['client_id']) {

                if ($formdata['is_favorite'] == true) {
                    //updateOrCreate
                    $expertfavorit = Expertfavorite::updateOrCreate(
                        ['client_id' => $formdata['client_id'], 'expert_id' => $formdata['expert_id']]
                    );
                } else {
                    //delete
                    $deleted = Expertfavorite::where('client_id', $formdata['client_id'])->where('expert_id', $formdata['expert_id'])->delete();

                }
                return response()->json("ok");
                //   return response()->json( $client_id );
            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        }
    }
//expert app
public function saveexpertfav()
{
    $authuser = auth()->user();
    $request = request();

    $formdata = $request->all();

    $storrequest = new StoreExpertRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

    $validator = Validator::make(
        $formdata,
        $storrequest->rules(),
        $storrequest->messages()
    );
    if ($validator->fails()) {

        return response()->json($validator->errors());
        //   return redirect()->back()->withErrors($validator)->withInput();

    } else {

        //   $data = json_decode($request->getContent(), true);            
        //   return response()->json([$client_id,$authuser->id]);
        if ($authuser->id == $formdata['login_expert_id']) {

            if ($formdata['is_favorite'] == true) {
                //updateOrCreate
                $expertfavorit = Expertfavorite::updateOrCreate(
                    ['login_expert_id' => $formdata['login_expert_id'], 'expert_id' => $formdata['expert_id']]
                );
            } else {
                //delete
                $deleted = Expertfavorite::where('login_expert_id', $formdata['login_expert_id'])->where('expert_id', $formdata['expert_id'])->delete();

            }
            return response()->json("ok");
            //   return response()->json( $client_id );
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
//end
    public function deleteaccount()
    {
        $formdata = request(['id']);
        $id = $formdata["id"];
        $authuser = auth()->user();
        if (!($authuser->id == $id)) {
            return response()->json('notexist', 401);
        } else {
            Expertfavorite::where('expert_id', $id)->delete();
            Expertfavorite::where('login_expert_id', $id)->delete();
            Expert::find($id)->update([
                'is_active' => 0,
            ]);

            auth('api')->logout();
            return response()->json($id);
        }
    }

    public function updateprofile(Request $filerequest)
    {
        $formdata = $filerequest->all();
        $id = 0;
        if (isset($formdata["id"])) {
            $id = $formdata["id"];
        }
        $cnum = "";
        $mnum = "";
        if (isset($formdata["country_num"])) {
            $cnum = $formdata["country_num"];
        }
        if (isset($formdata["mobile_num"])) {
            $mnum = $formdata["mobile_num"];
        }


        $storrequest = new UpdateExpertRequest();

        $validator = Validator::make(
            $formdata,
            $storrequest->rules($id, $cnum, $mnum),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $authuser = auth()->user();
            if (!($authuser->id == $id)) {
                return response()->json('notexist', 401);
            } else {
                $birthdate = Carbon::create($formdata["birthdate"])->format('Y-m-d');
                $cnum = $formdata["country_num"];
                $mnum = $formdata["mobile_num"];

                Expert::find($id)->update([
                    'first_name' => $formdata['first_name'],
                    'last_name' => $formdata['last_name'],
                    'email' => $formdata['email'],
                    //   'user_name'=>  $formdata['user_name'],
                    'country_num' => $cnum,
                    'mobile_num' => $mnum,
                    'mobile' => $cnum . $mnum,
                    'gender' => (int) $formdata['gender'],
                    'birthdate' => $birthdate,
                    'desc' => $formdata['desc'],
                ]);
                if ($filerequest->hasFile('image')) {
                    $file = $filerequest->file('image');
                    $this->storeImage($file, $id);
                }
                if (isset($formdata['password'])) {
                    $password = trim($formdata['password']);
                    Expert::find($id)->update([
                        'password' => bcrypt($password),
                    ]);
                }
                return response()->json($id);
            }
        }
    }

    public function storeImage($file, $id)
    {
        $imagemodel = Expert::find($id);
        $oldimage = $imagemodel->image;
        $oldimagename = basename($oldimage);
        $strgCtrlr = new StorageController();
        $path = $strgCtrlr->path['experts'];
        $oldimagepath = $path . '/' . $oldimagename;
        //save photo

        if ($file !== null) {
            //  $filename= rand(10000, 99999).".".$file->getClientOriginalExtension();
            $filename = rand(10000, 99999) . $id . ".webp";
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image = $image->toWebp(75);
            if (!File::isDirectory(Storage::url('/' . $path))) {
                Storage::makeDirectory('public/' . $path);
            }
            $image->save(storage_path('app/public') . '/' . $path . '/' . $filename);
            //   $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
            Expert::find($id)->update([
                "image" => $filename
            ]);
            Storage::delete("public/" . $path . '/' . $oldimagename);
        }
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
    public function storeAnswerRecord($file, $id)
    {
        $model = Answer::find($id);
        $oldfile = $model->record;
        $oldfilename = basename($oldfile);
        $strgCtrlr = new StorageController();
        $recpath = $strgCtrlr->recordpath['answers'];
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
            $now = Carbon::now();
            Answer::find($id)->update([
                "record" => $filename,
                "answer_date" => $now,
            ]);
            Storage::delete("public/" . $recpath . '/' . $oldfilename);
        }
        return 1;
    }


    public function uploadanswer(Request $request)
    {
        //
        $formdata = $request->all();
        $storrequest = new UploadAnswerRequest();
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $sleservice = Selectedservice::find($formdata['selectedservice_id']);
            if ($sleservice->expert_id == auth()->user()->id) {
                DB::transaction(function () use ($request, $formdata) {
                    if ($request->hasFile('record')) {
                        $newObj = new Answer();
                        $newObj->answer_reject_reason = "";
                        $newObj->selectedservice_id = $formdata['selectedservice_id'];
                        $newObj->answer_state = 'wait';
                        $newObj->save();
                        $file = $request->file('record');
                        $this->storeAnswerRecord($file, $newObj->id);
                        $this->id = $newObj->id;
                    }
                });
                return response()->json([
                    "message" => $this->id
                ]);

            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }


        }

    }

    public function uploadrecord(Request $request)
    {
        //
        $formdata = $request->all();
        $storrequest = new UploadRecordRequest();
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {


            DB::transaction(function () use ($request, $formdata) {

                if ($request->hasFile('record')) {
                    $file = $request->file('record');
                    $this->storeExpertRecord($file, $formdata['id']);
                    $this->id = $formdata['id'];
                }
            });

            return response()->json([
                "message" => $this->id
            ]);

        }

    }
    public function gettype(Request $request)
    {
        //
        $formdata = $request->all();



        if ($request->hasFile('record')) {
            $file = $request->file('record');
            $mimeType = File::mimeType($file);


            //dd($mimeType);
        }


        return response()->json([

            "message" => $mimeType,

        ]);
    }
    public function pullbalance()
    {
        //   $authuser = auth()->user();
        $request = request();

        $formdata = $request->all();

        $storrequest = new PullBalanceRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            //   if ($authuser->id == $client->id ) {
            $expert = Expert::find($formdata['expert_id']);
            $amount = $formdata["amount"];
            if ($expert->cash_balance < $amount) {
                return response()->json([
                    // "message" => 0,
                    "message" => 0,
                    "error" => "not_enough_balance",
                ]);
            } else {
                $this->expertpullbalance($expert, $amount);
                return response()->json([
                    "message" => $expert->id
                ]);
            }
        }
    }
    public function expertpullbalance($expert, $amount)
    {

        DB::transaction(function () use ($expert, $amount) {
            //decrease cash from expert 
            $newblnce = $expert->cash_balance - $amount;
            $newblncetodate = $expert->cash_balance_todate + $amount;
            Expert::find($expert->id)->update(
                [
                    'cash_balance' => $newblnce,
                    'cash_balance_todate' => $newblncetodate,
                ]
            );
            //add point transfer for expert

            $pointtransfer = new Pointtransfer();
            $pntctrlr = new PointTransferController();
            $type = 'p';
            $firstLetters = $type . 'ex-';
            $newpnum = $pntctrlr->GenerateCode($firstLetters);

            $pointtransfer->expert_id = $expert->id;
            $pointtransfer->count = $amount;
            $pointtransfer->status = 1;
            $pointtransfer->side = 'to-expert';
            $pointtransfer->state = 'balance';
            $pointtransfer->type = $type;
            $pointtransfer->num = $newpnum;

            $pointtransfer->save();
            $this->pointtransfer_id = $pointtransfer->id;
            ///////////////////////////
            //add cach transfer for Expert
            $cashtype1 = 'p';
            $cashtrctrlr = new CashTransferController();
            $firstLetters = $cashtype1 . 'ex-';
            $expCode = $cashtrctrlr->GenerateCode($firstLetters);
            $expertCash = new Cashtransfer();
            $expertCash->cash = $amount;
            $expertCash->cashtype = $cashtype1;
            $expertCash->fromtype = 'expert';
            $expertCash->totype = 'expert';
            $expertCash->status = 'balance';
            $expertCash->expert_id = $expert->id;

            $expertCash->pointtransfer_id = $pointtransfer->id;
            $expertCash->cash_num = $expCode;
            $expertCash->pointtransfer_id = $pointtransfer->id;
            $expertCash->save();


            //add cash to company balance
            $comObj = Company::find(1);
            Company::find(1)->update(
                [
                    'cash_balance' => $comObj->cash_balance - $amount,

                ]
            );

        });

        //send auto notification 5 pull balance
        $notctrlr = new NotificationController();

        $title = __('general.5expertpullbalance_title');
        $body = __('general.5expertpullbalance_body', ['Cash' => $amount]);
        $notctrlr->sendautonotify($title, $body, 'auto', 'text', '', 'finance', 0, $expert->id, 0, $this->pointtransfer_id);

        return 1;
    }
    public function getavailable()
    {

        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ExpertPath('image');
        $recurl = $strgCtrlr->ExpertPath('record');
        $defaultimg = $strgCtrlr->DefaultPath('image');
        $user = Expert::where('is_available', 1)->
            where('is_active', 1)->
            select(
                'id',
                'user_name',
                'is_active',
                'rates',
                'call_cost',
                'answer_speed',
                DB::raw("(CASE 
            WHEN image is NULL THEN '$defaultimg'                    
            ELSE CONCAT('$url',image)
            END) AS image"),
                'first_name',
                'last_name',
                'is_available'
            )->get();



        return response()->json($user);
    }

    public function savetoken()
    {

        $request = request();

        $formdata = $request->all();

        $storrequest = new SaveTokenRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
        } else {

            $expert_id = $formdata['expert_id'];
            //save token in expert 

            Expert::find($expert_id)->update(
                [
                    'token' => $formdata["token"],
                ]
            );
            return response()->json("ok");

        }
    }

    public function getstatistics()
    {

        //  return response()->json(['form' =>  $credentials]);
        $request = request();

        $formdata = $request->all();

        $storrequest = new StatisticRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            $expert_id = $formdata['expert_id'];
            $strgCtrlr = new StorageController();
            $iconurl = $strgCtrlr->ServicePath('icon');
            $defaultsvg = $strgCtrlr->DefaultPath('icon');
            //group services
            $serviceIds = Selectedservice::where('expert_id', $expert_id)->
                where(function ($query) {
                    $query->where('comment_state', 'agree')
                        ->orWhere('rate', '>', 0);
                })->groupBy('service_id')->select('service_id')->get();
            //group service client for comment and rate
            $service_clientIds = Selectedservice::where('expert_id', $expert_id)->
                where(function ($query) {
                    $query->where('comment_state', 'agree')
                        ->orWhere('rate', '>', 0);
                })->groupBy('service_id', 'client_id')->select('service_id', 'client_id')->get();
            $rate_id_list = [];
            $admin_rate_id_list = [];
            $comment_id_list = [];
            foreach ($service_clientIds as $service_clint_row) {
                //group service client rate
                //rate 
                $rate_Id = Selectedservice::where('expert_id', $expert_id)->
                    where('service_id', $service_clint_row->service_id)->
                    where('client_id', $service_clint_row->client_id)->
                    where('rate', '>', 0)->orderByDesc('rate_date')->select('id')->first();
                if ($rate_Id) {
                    $rate_id_list[] = $rate_Id->id;
                }
                //admin rate 
                $admin_rate_Id = Selectedservice::where('expert_id', $expert_id)->
                    where('service_id', $service_clint_row->service_id)->
                    where('client_id', $service_clint_row->client_id)->
                    where('comment_state', 'agree')->
                    where('comment_rate', '>', 0)
                    ->orderByDesc('comment_rate_date')->select('id')->first();
                if ($admin_rate_Id) {
                    $admin_rate_id_list[] = $admin_rate_Id->id;
                }

            }
            $last_service_list = [];
            foreach ($serviceIds as $service_row) {
                //rate
                $rateavg = Selectedservice::where('expert_id', $expert_id)
                    ->where('service_id', $service_row->service_id)
                    ->whereIn('id', $rate_id_list)->select('rate')->average('rate');
                //admin rate avg
                $adminrateavg = Selectedservice::where('expert_id', $expert_id)
                    ->where('service_id', $service_row->service_id)
                    ->whereIn('id', $admin_rate_id_list)->select('comment_rate')->average('comment_rate');
                $finalrate = 0;
                if ($rateavg == 0 || $adminrateavg == 0) {
                    $finalrate = ($rateavg + $adminrateavg);
                } else {
                    $finalrate = ($rateavg + $adminrateavg) / 2;
                }
                //2.1 ->3
                $finalrate = ceil($finalrate);
                //comment
                $commentrow = Selectedservice::where('expert_id', $expert_id)
                    ->where('service_id', $service_row->service_id)
                    ->where('comment_state', 'agree')->orderByDesc('comment_date')->select('comment')->first();
                $finalcomment = '';
                if ($commentrow) {
                    $finalcomment = $commentrow->comment;
                }

                $service = Service::select(
                    'id',
                    'name',
                    DB::raw("(CASE 
                    WHEN services.icon is NULL THEN '$defaultsvg'                    
                    ELSE CONCAT('$iconurl',icon)
                    END) AS icon")
                )->find($service_row->service_id);
                $arrayservice = [
                    'service_id' => $service->id,
                    'name' => $service->name,
                    'icon' => $service->icon,
                    'rate' => $finalrate,
                    'comment' => $finalcomment,
                ];
                $last_service_list[] = $arrayservice;
            }
            $expert = Expert::select('id', 'answer_speed')->find($expert_id);
            $answerspeed = $expert->answer_speed;

            return response()->json(['answer_speed' => $answerspeed, 'service_statistics' => $last_service_list]);

        }
    }
    public function getwallet()
    {
        //  return response()->json(['form' =>  $credentials]);
        $request = request();
        $formdata = $request->all();
        $storrequest = new StatisticRequest();//php artisan make:request Api/Expertfavorite/StoreRequest
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            $strgCtrlr = new StorageController();
            $iconurl = $strgCtrlr->ServicePath('icon');
            $defaultsvg = $strgCtrlr->DefaultPath('icon');
            $expert = Expert::select('id', 'cash_balance', 'cash_balance_todate')->find($formdata['expert_id']);
            $expert->makeHidden(['full_name']);
            return response()->json($expert);

        }
    }
}
