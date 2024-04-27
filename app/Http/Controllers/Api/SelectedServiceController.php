<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\InputService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Models\Selectedservice;
use App\Models\Client;
use App\Models\Expert;
use App\Models\Service;
use App\Models\ExpertService;
use App\Models\ValueService;
use App\Models\Pointtransfer;
 
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\ValueService\StoreImageRequest;
use App\Http\Requests\Api\Comment\AddCommentRequest;
use App\Http\Requests\Api\Comment\AddRateRequest;
use App\Http\Requests\Api\Order\OrdersRequest;
use App\Http\Requests\Api\Order\OrderByIdRequest;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\ExpertController;
use Illuminate\Support\Str;

//use Illuminate\Support\Str;
class SelectedServiceController extends Controller
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
    public $id = 0;
    public $msg = "";
    public function store(Request $request)
    {
        //
    }
    public function savewithvalues()
    {
        //      
        DB::transaction(function () {
            $request = request();
            $data = json_decode($request->getContent(), true);
            //check client balance
            $client = Client::find($data['client_id']);
            $expertService = ExpertService::where('expert_id', $data['expert_id'])->where('service_id', $data['service_id'])->first();
            $service = Service::find($expertService->service_id);
            if ($client->points_balance < $expertService->points) {
                $this->msg = "nopoints";/*
return response()->json([
"error" => "nopoints",
"message" => 0
// 'user'=> $user,   
]);
*/
            } else {
                $newNum = $this->GenerateCode("order-");
                $now = Carbon::now();
                //save selected service
                $newObj = new Selectedservice;
                $newObj->client_id = $client->id;
                $newObj->expert_id = $expertService->expert_id;
                $newObj->service_id = $expertService->service_id;
                $newObj->points = $expertService->points;
                $newObj->rate = 0;
                $newObj->form_state = 'wait';
                //   $newObj->answer = "";
                //   $newObj->answer2 = "";
                $newObj->comment = "";
                // $newObj->iscommentconfirmd = 0;
                //   $newObj->issendconfirmd = 0;
                //    $newObj->isanswerconfirmd = 0;
                $newObj->comment_rate = 0;
                $newObj->status = "created";
                $newObj->expert_cost = $service->expert_percent;//percent
                $newObj->cost_type = $expertService->cost_type;
                //   $newObj->expert_cost_value = $expertService->expert_cost_value;
                $newObj->expert_cost_value = StorageController::CalcPercentVal($service->expert_percent, $expertService->points);
                $newObj->order_num = $newNum;
                $newObj->order_date = $now;
                $newObj->save();
                $this->id = $newObj->id;

                //save values in values_services table
                foreach ($data["valueServices"] as $row) {
                    $valueService = new valueService();
                    $input = InputService::find($row['inputservice_id'])->input()->first();

                    $valueService->value = $row['value'];
                    $valueService->inputservice_id = $row['inputservice_id'];
                    $valueService->selectedservice_id = $newObj->id;

                    $valueService->name = $input->name;
                    $valueService->type = $input->type;
                    $valueService->tooltipe = $input->tooltipe;
                    $valueService->icon = $input->icon;
                    $valueService->ispersonal = $input->ispersonal;
                    $valueService->image_count = $input->image_count;
                    $valueService->save();
                }
                // decrease client balance
                $client->points_balance = $client->points_balance - $expertService->points;
                $client->save();
                //create point transfer row
                $pointtransfer = new Pointtransfer();
                $pntctrlr = new PointTransferController();
                $type = 'd';
                $firstLetters = $type . 'cl-';
                $newpnum = $pntctrlr->GenerateCode($firstLetters);
                //$pointtransfer->point_id = $formdata['point_id'];
                $pointtransfer->client_id = $client->id;
                $pointtransfer->expert_id = $expertService->expert_id;
                $pointtransfer->service_id = $expertService->service_id;
                $pointtransfer->count = $expertService->points;
                $pointtransfer->status = 1;
                $pointtransfer->selectedservice_id = $newObj->id;
                $pointtransfer->side = 'from-client';
                $pointtransfer->state = 'wait';
                $pointtransfer->type = 'd';
                $pointtransfer->num = $newpnum;
                $pointtransfer->save();
                //  }
            }
        });
        $res = [];
        if ($this->msg == "nopoints") {
            $res = [
                "message" => 0,
                "error" => "nopoints",
            ];
        } else {
            $res = ["message" => $this->id];
        }
        return response()->json($res);

    }

    public function uploadfilesvalue(Request $request)
    {
        //
        $formdata = $request->all();

        $storrequest = new StoreImageRequest();

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            DB::transaction(function () use ($request, $formdata) {
                //isset($formdata["is_active"]) 
                $valserCntrlr = new ValueServiceController();
                //save images if exist
                if (isset ($formdata["inputservice_id"])) {
                    if ($formdata["inputservice_id"] > 0) {
                        $input = InputService::findOrFail($formdata['inputservice_id'])->input()->first();

                        for ($i = 1; $i <= 4; $i++) {
                            if ($request->hasFile('image_' . $i)) {
                                $valueService = new valueService();
                                $valueService->value = "";
                                $valueService->inputservice_id = $formdata['inputservice_id'];
                                $valueService->selectedservice_id = $formdata['selectedservice_id'];

                                $valueService->name = $input->name;
                                $valueService->type = $input->type;
                                $valueService->tooltipe = $input->tooltipe;
                                $valueService->icon = $input->icon;
                                $valueService->ispersonal = $input->ispersonal;
                                $valueService->image_count = $input->image_count;
                                $valueService->save();

                                $file = $request->file('image_' . $i);
                                $valserCntrlr->storeImage($file, $valueService->id);
                                $this->id = $valueService->id;
                            }
                        }
                    }
                }
                //save record if exist
                if (isset ($formdata["record_inputservice_id"])) {
                    if ($formdata["record_inputservice_id"] > 0) {
                        $record_input = InputService::findOrFail($formdata['record_inputservice_id'])->input()->first();
                        if ($request->hasFile('record')) {
                            $valueService = new valueService();
                            $valueService->value = "";
                            $valueService->inputservice_id = $formdata['record_inputservice_id'];
                            $valueService->selectedservice_id = $formdata['selectedservice_id'];

                            $valueService->name = $record_input->name;
                            $valueService->type = $record_input->type;
                            $valueService->tooltipe = $record_input->tooltipe;
                            $valueService->icon = $record_input->icon;
                            $valueService->ispersonal = $record_input->ispersonal;
                            $valueService->image_count = $record_input->image_count;
                            $valueService->save();

                            $file = $request->file('record');
                            $valserCntrlr->storerecord($file, $valueService->id);
                            $this->id = $valueService->id;
                        }
                    }
                }
            });
        }

        return response()->json([
            "message" => $this->id

        ]);
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
    public function additem(Selectedservice $newObject)
    {
        $newObject->save();
        return $newObject;
    }
    public function addcomment()
    {
        $authuser = auth()->user();
        $request = request();

        $formdata = $request->all();

        $storrequest = new AddCommentRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {

            $selectedservice = Selectedservice::find($formdata['selectedservice_id']);
            if ($authuser->id == $selectedservice->client_id) {
                if ($selectedservice->comment_state == 'no-comment') {
                    DB::transaction(function () use ($selectedservice, $formdata) {
                        $now = Carbon::now();
                        Selectedservice::find($selectedservice->id)->update(
                            [
                                'comment' => $formdata['comment'],
                                'comment_date' => $now,
                                'comment_state' => 'wait',
                            ]
                        );
                    });
                }
                return response()->json("ok");

            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        }
    }
    public function addrate()
    {
        $authuser = auth()->user();
        $request = request();
        $formdata = $request->all();
        $storrequest = new AddRateRequest();
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            $selectedservice = Selectedservice::find($formdata['selectedservice_id']);
            if ($authuser->id == $selectedservice->client_id) {
                if ($selectedservice->answer_state == 'agree' && $selectedservice->rate == 0) {
                    DB::transaction(function () use ($selectedservice, $formdata) {
                        $now = Carbon::now();
                        Selectedservice::find($selectedservice->id)->update(
                            [
                                'rate' => $formdata['rate'],
                                'rate_date' => $now,
                            ]
                        );
                       $rateavg= StorageController::calcRateAvg($selectedservice->expert_id);
                        Expert::find($selectedservice->expert_id)->update(
                            [
                                'rates' =>$rateavg,
                                
                            ]
                        );
                    });
                }
                return response()->json("ok");
            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        }
    }

    public function GenerateCode($firstLetters)
    {
        $firstsubLen = strlen($firstLetters) + 1;
        $numlist = Selectedservice::where('order_num', 'like', $firstLetters . '%')->select(DB::raw((string) 'SUBSTR(order_num,' . $firstsubLen . ') as order_num'))->get();
        $numzro = 0;
        if ($numlist->isEmpty()) {

            $numzro = StorageController::addZeros(1);
        } else {
            $num = $numlist->max('order_num');
            $numzro = StorageController::addZeros((int) $num + 1);
        }
        //   $numlist = Pointtransfer::where('num', 'like', $firstLetters.'%')->select('num')->get();
        //select(DB::raw('SUBSTR(num, LOCATE("-", num) +  1) as num'))   
        //DB::raw('substr(num, 1, 4) as num')
        //    $firstLetters=   Str::upper("d");
        //   $firstLetters=  $firstLetters."CL-";
        //   Str::upper("d");
        // 
        $finalcode = Str::upper($firstLetters) . $numzro;
        return $finalcode;
    }

    public function getorders()
    {

        $request = request();

        $formdata = $request->all();

        $storrequest = new OrdersRequest();

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());

        } else {
            $expert_id = $formdata['expert_id'];
            $list = Selectedservice::where('expert_id', $expert_id)->where('form_state', 'agree')
            ->wherehas('client', function ($query){
                $query->where('is_active',1);
            })
            ->select(
                    'id',
                    'client_id',
                    'expert_id',
                    'service_id',

                    'rate',
                    'order_num',
                    'form_state',

                    'order_date',
                    'order_admin_date',
                    'rate_date',
                    'answer_speed',
                )->get()->makeHidden(['answers']);

            return response()->json($list);


        }


    }
    public function getorderbyid()
    {

        $request = request();

        $formdata = $request->all();

        $storrequest = new OrderByIdRequest();

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());


        } else {
            $selectedservice_id = $formdata['selectedservice_id'];
            $authuser = auth()->user();
            $selser = Selectedservice::find($selectedservice_id);
            if ($authuser->id == $selser->expert_id) {

                $item = Selectedservice::with([

                    'client' => function ($q) {
                        $q->select(
                            'id',
                            'user_name',
                            'image',
                            'is_active',
                        )->first();
                    },
                    'valueservices' => function ($q) {
                        $q->select(
                            'id',
                            'value',
                            'selectedservice_id',
                            'inputservice_id',
                            'name',
                            'type',
                            'tooltipe',
                            'icon',
                            'ispersonal',
                            'image_count',
                        )->orderByDesc('ispersonal');
                    }
                ])->where('form_state', 'agree')
                ->wherehas('client', function ($query){
                    $query->where('is_active',1);
                })
                  ->  select(
                        'id',
                        'client_id',
                        'expert_id',
                        'service_id',

                        'rate',
                        'order_num',
                        'form_state',

                        'order_date',
                        'order_admin_date',
                        'rate_date',
                        'answer_speed',
                    )->find($selectedservice_id)
                  // ->makeHidden(['answers', 'title'])
                    ;
if( !is_null($item)){
    $item->makeHidden(['answers', 'title']);
}

                return response()->json($item);
            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        }


    }
    public function getwaitanswer()
    {
        $request = request();

        $formdata = $request->all();

        $storrequest = new OrderByIdRequest();

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());


        } else {
            $selectedservice_id = $formdata['selectedservice_id'];
            $authuser = auth()->user();
            $selser = Selectedservice::find($selectedservice_id);
            if ($authuser->id == $selser->expert_id) {

                $item = Answer::where('answer_state', 'wait')
               ->where('selectedservice_id',$selectedservice_id)
               
                  ->  select(
                        'id',
                        'record',
                        
                       // 'answer_reject_reason',
                        'answer_state',
                        'selectedservice_id',
                          )->get()->last();
                  // ->makeHidden(['answers', 'title'])
                    ;
 

                return response()->json($item);
            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        }
     }

     public function getorderwithanswer()
     {
 
         $request = request();
 
         $formdata = $request->all();
 
         $storrequest = new OrderByIdRequest();
 
         $validator = Validator::make(
             $formdata,
             $storrequest->rules(),
             $storrequest->messages()
         );
         if ($validator->fails()) {
 
             return response()->json($validator->errors()); 
         } else {
            $strgCtrlr = new StorageController();
            $url = $strgCtrlr->ExpertPath('image');
       $defaultimg = $strgCtrlr->DefaultPath('image');

             $selectedservice_id = $formdata['selectedservice_id'];
             $authuser = auth()->user();
           
             $selser = Selectedservice::find($selectedservice_id);
             $client_id= $selser->client_id;
             if ($authuser->id == $selser->client_id) {

                 $item = Selectedservice::with([
 /*
                     'client' => function ($q) {
                         $q->select(
                             'id',
                             'user_name',
                             'image',
                             'is_active',
                         )->first();
                     },
                     */
                     'expert' => function ($q) use($url,$defaultimg, $client_id){
                        $q->with([
                        'expertsFavorites' => function ($q) use ($client_id) {
                            $q->where('client_id', $client_id)->select('id', 'client_id', 'expert_id');
                        }])->select(
                            'id',
                            'user_name',
                            'rates',
                            'is_active',
                            'first_name',
                            'last_name',
                            DB::raw("(CASE 
                            WHEN image is NULL THEN '$defaultimg'                    
                            ELSE CONCAT('$url',image)
                            END) AS image"),
                        )->first();
                    },
                     'valueservices' => function ($q) {
                         $q->select(
                             'id',
                             'value',
                             'selectedservice_id',
                             'inputservice_id',
                             'name',
                             'type',
                             'tooltipe',
                             'icon',
                             'ispersonal',
                             'image_count',
                         )->orderByDesc('ispersonal');
                     },
                     'answers' => function ($q) {
                        $q->where('answer_state','agree')->select(
                            'id',
                            'record',
                            'answer_state',
                            'selectedservice_id',
                            'answer_admin_date',
                        )->first() ;
                    }
                 ])->where('form_state', 'agree')
                 ->wherehas('client', function ($query){
                     $query->where('is_active',1);
                 })
                   ->  select(
                         'id',
                         'client_id',
                         'expert_id',
                         'service_id',
 
                         'rate',
                         'order_num',
                         'form_state',
 
                         'order_date',
                         'order_admin_date',
                         'rate_date',
                         'answer_speed',
                         'comment_state',
                         'comment',                          
                         'comment_date',
                          'comment_admin_date',                                  
                        
                     )->where('id',$selectedservice_id)->get()
                    ->where('answer_state','agree')
                     ;
                    
 if( !is_null($item)){
     $item->makeHidden([ 'title']);
     $selorder= $this->selservicemap( $item);//////////
 }

                 return response()->json($selorder);
             } else {
                 return response()->json(['error' => 'Unauthenticated'], 401);
             }
         }
 
 
     }
     public function selservicemap($selectedservice)
     {
         if (is_null($selectedservice)) {
             return $selectedservice;
         } else {
            $expctrlr=new ExpertController();
            $selectedservicesMap =  $selectedservice
            ->map(function ($selectedservice) use( $expctrlr)  { 
                
               $mapexpert= $expctrlr->expertforclientorder($selectedservice->expert);

                //selectedservices 
            return [
             'id'=>$selectedservice->id,
             'expert_id'=>$selectedservice->expert_id,
             'service_id'=>$selectedservice->service_id,
             'client_id'=>$selectedservice->client_id,
            // 'comment'=>$selectedservice->comment,
             'comment_state'=>$selectedservice->comment_state,
            // 'comment_date'=>$selectedservice->comment_date,
            // 'client'=>$selectedservice->client,
            'rate'=>$selectedservice->rate,
'order_num'=>$selectedservice->order_num,
'form_state'=>$selectedservice->form_state,
'order_date'=>$selectedservice->order_date,
'order_admin_date'=>$selectedservice->order_admin_date,
'rate_date'=>$selectedservice->rate_date,
'answer_speed'=>$selectedservice->answer_speed,
'answer_state'=>$selectedservice->answer_state,
//'is_favorite' => $selectedservice->expert->expertsFavorites->isEmpty() ? 0 : 1,
//'client'=>$selectedservice->answer_state,
'expert'=> $mapexpert,

'valueservices'=>$selectedservice->valueservices,
'answers'=>$selectedservice->answers,

            ];  
            });
 return  $selectedservicesMap ;
   
         }

     }
     

}
