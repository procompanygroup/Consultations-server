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
use App\Models\GiftMinute;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\ValueService\StoreImageRequest;
use App\Http\Requests\Api\Comment\AddCommentRequest;
use App\Http\Requests\Api\Comment\AddRateRequest;
use App\Http\Requests\Api\Order\OrdersRequest;
use App\Http\Requests\Api\Order\OrderByIdRequest;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\ExpertController;
use Illuminate\Support\Str;
use App\Http\Controllers\Web\GiftController;
use App\Models\Gift;
use App\Http\Requests\Api\Order\CallOrderRequest;
use App\Http\Controllers\Web\GiftMinuteController;
//use Illuminate\Support\Str;
class SelectedServiceController extends Controller
{
    public $oldestday = 30;


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
            $client_id = $data['client_id'];
            //check client balance
            $client = Client::find($client_id);
            $expert = Expert::find($data['expert_id']);
            if( $expert->status=='n'){
                $this->msg ='not-available';
            }else{
                $expertService = ExpertService::where('expert_id', $data['expert_id'])->where('service_id', $data['service_id'])->first();
                $service = Service::find($expertService->service_id);
                //free point start
                $giftctrlr = new GiftController();
                $avlarr = $giftctrlr->checkavailablepoints($client_id);
                $free_points = $avlarr['points'];
                //$giftmodel=$avlarr['giftmodel'];
    
                if ($free_points == 0) {
                    //normal send
                    if ($client->points_balance < $expertService->points) {
                        $this->msg = "nopoints";
    
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
                        $newObj->expert_cost = $expertService->expert_cost;//percent
                        $newObj->cost_type = $expertService->cost_type;
                        //   $newObj->expert_cost_value = $expertService->expert_cost_value;
                        $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
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
                        $pointtransfer->notes = $expertService->points;
                        $pointtransfer->save();
                        //  }
                      $this-> sendnotify_toclient($expertService->points,  $newObj,$service->name);
                    }
                    //end normal
    
                } else {
                          // free with balance
                    $giftmodel = $avlarr['giftmodel'];
                       //الرصيد المجاني اكبر او يساوي الكلفة
                    if ($free_points >= $expertService->points) {
                        $newfree = $free_points - $expertService->points;
                        //update gift row
                        $gift_id = $giftmodel->id;
                        Gift::find($gift_id)->update([
                            'free_points' => $newfree,
                            'status' => 'used',
                        ]);
                        // start save selected service
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
    
                        $newObj->comment = "";
    
                        $newObj->comment_rate = 0;
                        $newObj->status = "created";
                        $newObj->expert_cost = $expertService->expert_cost;//percent
                        $newObj->cost_type = $expertService->cost_type;
                        //   $newObj->expert_cost_value = $expertService->expert_cost_value;
                        $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
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
                        //end save selected service
                        //add free point transfer
                        //create point transfer row
                        $pointtransfer = new Pointtransfer();
                        $pntctrlr = new PointTransferController();
                        $type = 'd';
                        $firstLetters = $type . 'clg-';
                        $newpnum = $pntctrlr->GenerateCode($firstLetters);
                        //$pointtransfer->point_id = $formdata['point_id'];
                        $pointtransfer->client_id = $client->id;
                        $pointtransfer->expert_id = $expertService->expert_id;
                        $pointtransfer->service_id = $expertService->service_id;
                        $pointtransfer->count = $expertService->points;
                        $pointtransfer->status = 1;
                        $pointtransfer->selectedservice_id = $newObj->id;
                        $pointtransfer->side = 'from-gift-client';
                        $pointtransfer->state = 'wait';
                        $pointtransfer->type = 'd';
                        $pointtransfer->num = $newpnum;
                        $pointtransfer->gift_id = $gift_id;
                        $pointtransfer->notes = $expertService->points;
                        $pointtransfer->save();
                        //end add free point transfer
    
                    } else {
                        //الرصيد المجاني اصغر تماما من الكلفة
                        $pointsremain = $expertService->points - $free_points;
                        if ($client->points_balance < $pointsremain) {
                            $this->msg = "nopoints";
    
                        } else {
                            //update gift row
                            $gift_id = $giftmodel->id;
                            Gift::find($gift_id)->update([
                                'free_points' => 0,
                                'status' => 'used',
                            ]);
                            //
                             // start save selected service
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
                         
                            $newObj->comment = "";
                      
                            $newObj->comment_rate = 0;
                            $newObj->status = "created";
                            $newObj->expert_cost = $expertService->expert_cost;//percent
                            $newObj->cost_type = $expertService->cost_type;
                            //   $newObj->expert_cost_value = $expertService->expert_cost_value;
                            $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
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
                            //end save selected service
    
                            //add free point transfer 
                            $pointtransfer = new Pointtransfer();
                            $pntctrlr = new PointTransferController();
                            $type = 'd';
                            $firstLetters = $type . 'clg-';
                            $newpnum = $pntctrlr->GenerateCode($firstLetters);
                            //$pointtransfer->point_id = $formdata['point_id'];
                            $pointtransfer->client_id = $client->id;
                            $pointtransfer->expert_id = $expertService->expert_id;
                            $pointtransfer->service_id = $expertService->service_id;
                            $pointtransfer->count = $free_points;
                            $pointtransfer->status = 1;
                            $pointtransfer->selectedservice_id = $newObj->id;
                            $pointtransfer->side = 'from-gift-client';
                            $pointtransfer->state = 'wait';
                            $pointtransfer->type = 'd';
                            $pointtransfer->num = $newpnum;
                            $pointtransfer->gift_id = $gift_id;
                            $pointtransfer->notes = $expertService->points;
                            $pointtransfer->save();
                            //end add free point transfer
                            // decrease client balance
                            $client->points_balance = $client->points_balance - $pointsremain;
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
                            $pointtransfer->count = $pointsremain;
                            $pointtransfer->status = 1;
                            $pointtransfer->selectedservice_id = $newObj->id;
                            $pointtransfer->side = 'from-client';
                            $pointtransfer->state = 'wait';
                            $pointtransfer->type = 'd';
                            $pointtransfer->num = $newpnum;
                            $pointtransfer->notes = $expertService->points;
                            $pointtransfer->save();
                             ///////// noti
                             $this->sendnotify_toclient($pointsremain, $newObj,$service->name);
    
                        }
    
    
                    }
                }
            }
        

        });
        $res = [];
        if ($this->msg == "nopoints") {
            $res = [
                "message" => 0,
                "error" => "nopoints",
            ];
        } else if($this->msg == "not-available"){
          
            return response()->json(["message" =>"not-available"]);
        }else {
            $res = ["message" => $this->id];
        }
        return response()->json($res);

    }

    public function sendnotify_toclient($points, $selectedservice,$service_name)
    {
        $notctrlr2 = new NotificationController();
        $title2 = __('general.17minuspoints_title');
        $body2 = __('general.17minuspoints_body', ['Points' => $points,'Service'=>$service_name]);
        $notctrlr2->sendautonotify($title2, $body2, 'auto', 'finance', '', 'finance', $selectedservice->client_id, 0, $selectedservice->id, 0);

    }
    public function sendnotifyminute_toclient($points, $selectedservice)
    {
        $notctrlr2 = new NotificationController();
        $title2 = __('general.16minusminute_title');
        $body2 = __('general.16minusminute_body', ['Minuts' => $points]);
        $notctrlr2->sendautonotify($title2, $body2, 'auto', 'finance', '', 'finance', $selectedservice->client_id, 0, $selectedservice->id, 0);

    }
    /*
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
                    $this->msg = "nopoints"; 
     
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
    */
    public function uploadfilesvalue(Request $request)
    {
        //
        $formdata = $request->all();
        $this->id=1;
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
                if (isset($formdata["inputservice_id"])) {
                    if ($formdata["inputservice_id"] > 0) {
                        $input = InputService::find($formdata['inputservice_id'])->input()->first();

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
                if (isset($formdata["record_inputservice_id"])) {
                    if ($formdata["record_inputservice_id"] > 0) {

                        $record_input = InputService::find($formdata['record_inputservice_id'])->input()->first();
                        if ($request->hasFile('record') ) {
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
                                'rate_state' => 'wait'
                            ]
                        );
                        // $rateavg = StorageController::calcRateAvg($selectedservice->expert_id);
                        // Expert::find($selectedservice->expert_id)->update(
                        //     [
                        //         'rates' => $rateavg,

                        //     ]
                        // );
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
            $nowsub = Carbon::now()->subDays($this->oldestday);
            $expert_id = $formdata['expert_id'];
            $callservice = Service::where('is_callservice', 1)->first();
            $callservice_id = 0;
            if ($callservice) {
                $callservice_id = $callservice->id;
            }
            $list = Selectedservice::where('expert_id', $expert_id)->where('form_state', 'agree')
                ->whereNot('service_id', $callservice_id)
                ->whereDate('created_at', '>=', $nowsub)
                ->wherehas('client', function ($query) {
                    $query->where('is_active', 1);
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
                )->orderByDesc('order_date')->get()->makeHidden(['answers']);

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
                    ->wherehas('client', function ($query) {
                        $query->where('is_active', 1);
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
                    )->find($selectedservice_id)
                    // ->makeHidden(['answers', 'title'])
                ;
                if (!is_null($item)) {
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
                    ->where('selectedservice_id', $selectedservice_id)

                    ->select(
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
            $client_id = $selser->client_id;
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
                    'expert' => function ($q) use ($url, $defaultimg, $client_id) {
                        $q->with([
                            'expertsFavorites' => function ($q) use ($client_id) {
                                $q->where('client_id', $client_id)->select('id', 'client_id', 'expert_id');
                            }
                        ])->select(
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
                        $q->where('answer_state', 'agree')->select(
                            'id',
                            'record',
                            'answer_state',
                            'selectedservice_id',
                            'answer_admin_date',
                        )->first();
                    }
                ])->where('form_state', 'agree')
                    ->wherehas('client', function ($query) {
                        $query->where('is_active', 1);
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
                        'comment_state',
                        'comment',
                        'comment_date',
                        'comment_admin_date',

                    )->where('id', $selectedservice_id)->get()
                    ->where('answer_state', 'agree')
                ;

                if (!is_null($item)) {
                    $item->makeHidden(['title']);
                    $selorder = $this->selservicemap($item);//////////
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
            $expctrlr = new ExpertController();
            $selectedservicesMap = $selectedservice
                ->map(function ($selectedservice) use ($expctrlr) {

                    $mapexpert = $expctrlr->expertforclientorder($selectedservice->expert);

                    //selectedservices 
                    return [
                        'id' => $selectedservice->id,
                        'expert_id' => $selectedservice->expert_id,
                        'service_id' => $selectedservice->service_id,
                        'client_id' => $selectedservice->client_id,
                        // 'comment'=>$selectedservice->comment,
                        'comment_state' => $selectedservice->comment_state,
                        // 'comment_date'=>$selectedservice->comment_date,
                        // 'client'=>$selectedservice->client,
                        'rate' => $selectedservice->rate,
                        'order_num' => $selectedservice->order_num,
                        'form_state' => $selectedservice->form_state,
                        'order_date' => $selectedservice->order_date,
                        'order_admin_date' => $selectedservice->order_admin_date,
                        'rate_date' => $selectedservice->rate_date,
                        'answer_speed' => $selectedservice->answer_speed,
                        'answer_state' => $selectedservice->answer_state,
                        'comment' => $selectedservice->comment,
                        'comment_date' => $selectedservice->comment_date,
                        'comment_admin_date' => $selectedservice->comment_admin_date,
                        //'is_favorite' => $selectedservice->expert->expertsFavorites->isEmpty() ? 0 : 1,
//'client'=>$selectedservice->answer_state,
                        'expert' => $mapexpert,

                        'valueservices' => $selectedservice->valueservices,
                        'answers' => $selectedservice->answers,

                    ];
                });
            return $selectedservicesMap;

        }

    }

    public function callorder()
    {
        $request = request();
        $formdata = $request->all();
        $storrequest = new CallOrderRequest();
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            //  client app    
            DB::transaction(function () use ($formdata) {

                $selectedservice_id = $formdata['selectedservice_id'];
                $minutes = $formdata['minutes'];
                // convert seconds to minute and get round up for cost 
                $real_minutes = $minutes / 60;
                //round down
                $floor_minutes = floor($real_minutes);
                //get remain
                $seconds = $minutes % 60;
                $str_minutes = ((string) $floor_minutes) . ":" . $seconds;
                //round up
                $cost_minutes = ceil($real_minutes);
                //
                $selectedservice = Selectedservice::find($selectedservice_id);
                if (auth()->user()->id == $selectedservice->client_id) {
                    $client_id = $selectedservice->client_id;
                    $expert_id = $selectedservice->expert_id;
                    //check client balance
                    $client = Client::find($client_id);
                    //   $service = Service::where('is_callservice', 1)->first();
                    $expertService = ExpertService::where('expert_id', $expert_id)->where('service_id', $selectedservice->service_id)->first();
                    if ($expertService) {
                        //normal send
                        //get cost for call service
                        $settctrlr = new SettingController();
                        $callcostobj = $settctrlr->findbyname('call_cost');
                        $minutecost = (float) $callcostobj->value;
                        //  
                        $call_cost = $cost_minutes * $minutecost;
                           //free point start
    $giftctrlr = new GiftMinuteController();
    $avlarr = $giftctrlr->checkavailablepoints($client_id);
    $free_points = $avlarr['points'];
    //free point end
    if ($client->minutes_balance < $cost_minutes && $free_points == 0) {
        //contunie with client minute balance as cost                
        $call_cost = $client->minutes_balance * $minutecost;
    }
    //save selected service                     
    $selectedservice->points = $call_cost;
    $selectedservice->call_duration = $str_minutes;
    $selectedservice->status = "done";
    $selectedservice->expert_cost = $expertService->expert_cost;//percent
    // $newObj->cost_type = $expertService->cost_type;
    //   $newObj->expert_cost_value = $expertService->expert_cost_value;
    $selectedservice->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $call_cost);

    $selectedservice->save();
    $this->id = $selectedservice->id;
if($free_points == 0){

    // decrease client balance
    $client->minutes_balance = $client->minutes_balance - $cost_minutes;
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
    $pointtransfer->count = $cost_minutes;
    $pointtransfer->status = 1;
    $pointtransfer->selectedservice_id = $selectedservice->id;
    $pointtransfer->side = 'from-client-minute';
    $pointtransfer->state = 'agree';
    $pointtransfer->type = 'd';
    $pointtransfer->num = $newpnum;
    $pointtransfer->notes = $call_cost;
    $pointtransfer->save();

    // send to client
    //   $cost_minutes
    // $notctrlr2 = new NotificationController();
    // $title2 = __('general.16minusminute_title');
    // $body2 = __('general.16minusminute_body', ['Minuts' => $cost_minutes]);
    // $notctrlr2->sendautonotify($title2, $body2, 'auto', 'order', '', 'finance', $selectedservice->client_id, 0, $selectedservice->id, 0);
    $this->sendnotifyminute_toclient( $cost_minutes, $selectedservice);
    //end normal

                       
    $this->msg = $this->id;
}else if($free_points >=$cost_minutes){
     //الرصيد المجاني اكبر او يساوي الكلفة
    $giftmodel = $avlarr['giftmodel'];
    $newfree = $free_points -$cost_minutes;
    //update gift row
    $gift_id = $giftmodel->id;
    GiftMinute::find($gift_id)->update([
        'free_minutes' => $newfree,
        'status' => 'used',
    ]);
//add free point transfer
                    
                    $pointtransfer = new Pointtransfer();
                    $pntctrlr = new PointTransferController();
                    $type = 'd';
                    $firstLetters = $type . 'clg-';
                    $newpnum = $pntctrlr->GenerateCode($firstLetters);
                    //$pointtransfer->point_id = $formdata['point_id'];
                    $pointtransfer->client_id = $client->id;
                    $pointtransfer->expert_id = $expertService->expert_id;
                    $pointtransfer->service_id = $expertService->service_id;
                    $pointtransfer->count = $cost_minutes;
                    $pointtransfer->status = 1;
                    $pointtransfer->selectedservice_id = $selectedservice->id;
                    $pointtransfer->side = 'from-giftminute-client';
                    $pointtransfer->state = 'agree';
                    $pointtransfer->type = 'd';
                    $pointtransfer->num = $newpnum;
                    $pointtransfer->gift_id = $gift_id;
                    $pointtransfer->notes =$call_cost;
                    $pointtransfer->save();


}else{
    //الرصيد المجاني اصغر تماما من الكلفة
    $minutesremain =$cost_minutes- $free_points;
  //update gift row
  $giftmodel = $avlarr['giftmodel'];
  $gift_id = $giftmodel->id;
  GiftMinute::find($gift_id)->update([
      'free_minutes' => 0,
      'status' => 'used',
  ]);
//add free point transfer
                    
$pointtransfer = new Pointtransfer();
$pntctrlr = new PointTransferController();
$type = 'd';
$firstLetters = $type . 'clg-';
$newpnum = $pntctrlr->GenerateCode($firstLetters);
//$pointtransfer->point_id = $formdata['point_id'];
$pointtransfer->client_id = $client->id;
$pointtransfer->expert_id = $expertService->expert_id;
$pointtransfer->service_id = $expertService->service_id;
$pointtransfer->count = $free_points;
$pointtransfer->status = 1;
$pointtransfer->selectedservice_id = $selectedservice->id;
$pointtransfer->side = 'from-giftminute-client';
$pointtransfer->state = 'agree';
$pointtransfer->type = 'd';
$pointtransfer->num = $newpnum;
$pointtransfer->gift_id = $gift_id;
$pointtransfer->notes ='0';
$pointtransfer->save();
 //end add free point transfer
 // decrease client balance

 $client->minutes_balance = $client->minutes_balance - $minutesremain;
 $client->save();
 //create point transfer row
 $remain_cost=$minutesremain * $minutecost;
 $pointtransfer = new Pointtransfer();
 $pntctrlr = new PointTransferController();
 $type = 'd';
 $firstLetters = $type . 'cl-';
 $newpnum = $pntctrlr->GenerateCode($firstLetters);
 //$pointtransfer->point_id = $formdata['point_id'];
 $pointtransfer->client_id = $client->id;
 $pointtransfer->expert_id = $expertService->expert_id;
 $pointtransfer->service_id = $expertService->service_id;
 $pointtransfer->count = $minutesremain;
 $pointtransfer->status = 1;
 $pointtransfer->selectedservice_id = $selectedservice->id;
 $pointtransfer->side = 'from-client-minute';
 $pointtransfer->state = 'wait';
 $pointtransfer->type = 'd';
 $pointtransfer->num = $newpnum;
 $pointtransfer->notes = $remain_cost;
 $pointtransfer->save();
 ///////// noti
 
 $this->sendnotifyminute_toclient( $minutesremain, $selectedservice);


}
//for expert only  add to expert balance
$this->expert_op($selectedservice, $client);
                      
                    } else {
                        $this->msg == "notallowed";
                    }
                } else {
                    $this->msg == "notallowed";
                }
            });
            $res = [];
            if ($this->msg == "nopoints" || $this->msg == "notallowed") {
                $res = [
                    "message" => 0,
                    "error" => $this->msg,
                ];
            } else {
                $res = ["message" => $this->msg];
            }
            return response()->json($res);
        }

    }
    public function expert_op($selectedObj, $client)
    {
        $comprofitperc = 100 - $selectedObj->expert_cost;
        $comprofitval = $selectedObj->points - $selectedObj->expert_cost_value;
        // calc answer speed for this order
        // $startdate= $selectedObj->order_date;
        // //$enddate= $now ;
        // $strgctrlr=new StorageController();
        //  $answespeed= $strgctrlr->calcAnswerSpeed( $startdate,$enddate);
        // end
        Selectedservice::find($selectedObj->id)->update([
            //  'status' => 'agree',
            'company_profit_percent' => $comprofitperc,
            'company_profit' => $comprofitval,
            'comment_state' => 'no-comment',
            //   'answer_speed'=>  $answespeed,
        ]);
        // $cashtrctrlr = new CashTransferController();

        // add point transfer for expert percent
        $pointtransfer = new Pointtransfer();
        $pntctrlr = new PointTransferController();
        $type = 'p';
        $firstLetters = $type . 'ex-';
        $newpnum = $pntctrlr->GenerateCode($firstLetters);
        //$pointtransfer->point_id = $formdata['point_id'];
        $pointtransfer->client_id = $selectedObj->client_id;
        $pointtransfer->expert_id = $selectedObj->expert_id;
        $pointtransfer->service_id = $selectedObj->service_id;
        $pointtransfer->count = $selectedObj->expert_cost_value;
        $pointtransfer->status = 1;
        $pointtransfer->selectedservice_id = $selectedObj->id;
        $pointtransfer->side = 'to-expert';
        $pointtransfer->state = 'agree';
        $pointtransfer->type = $type;
        $pointtransfer->num = $newpnum;
        $pointtransfer->save();
        // $this->pointtransfer_id= $pointtransfer->id;     
        ////add cost to expert balance and update answer speed  
        $expertObj = Expert::find($selectedObj->expert_id);
        Expert::find($selectedObj->expert_id)->update(
            [
                'cash_balance' => $expertObj->cash_balance + $selectedObj->expert_cost_value,
                'call_balance' => $expertObj->call_balance + $selectedObj->expert_cost_value,
                //   'cash_balance_todate' => $expertObj->cash_balance_todate + $selectedObj->expert_cost_value,
                //  'answer_speed'=>$answespeedavg ,
            ]
        );
        //  //send auto notification 4 increase balance
        $notctrlr2 = new NotificationController();
        //    $Servicename=$selectedObj->service->name;
//    $Expertname=$selectedObj->expert->full_name; 
        $Clientname = $client->user_name;
        $title2 = __('general.4addbalancetoexpert_title');
        $body2 = __('general.4addbalancetoexpert_body_call', ['Cash' => $selectedObj->expert_cost_value, 'Clientname' => $Clientname]);
        $notctrlr2->sendautonotify($title2, $body2, 'auto', 'order', '', 'call-order', 0, $selectedObj->expert_id, $selectedObj->id, $pointtransfer->id);
        return 1;
    }
    //     public function callorder()
//     {   
//         //  client app    
//         DB::transaction(function () {
//             $request = request();
//             $data = json_decode($request->getContent(), true);
//             $client_id = $data['client_id'];
//             //check client balance
//             $client = Client::find($client_id);
//             $service = Service::where('is_callservice', 1)->first();
//             $expertService = ExpertService::where('expert_id', $data['expert_id'])->where('service_id', $service->id)->first();
//             if ($expertService) {
//                 //free point start
//                 $giftctrlr = new GiftController();
//                 $avlarr = $giftctrlr->checkavailablepoints($client_id);
//                 $free_points = $avlarr['points'];
//                 //$giftmodel=$avlarr['giftmodel'];

    //                 if ($free_points == 0) {
//                     //normal send
//                     if ($client->points_balance < $expertService->points) {
//                         $this->msg = "nopoints";

    //                     } else {
//                         $newNum = $this->GenerateCode("order-");
//                         $now = Carbon::now();
//                         //save selected service
//                         $newObj = new Selectedservice;
//                         $newObj->client_id = $client->id;
//                         $newObj->expert_id = $expertService->expert_id;
//                         $newObj->service_id = $expertService->service_id;
//                         $newObj->points = $expertService->points;
//                         $newObj->rate = 0;
//                         $newObj->form_state = 'agree';
//                         //   $newObj->answer = "";
//                         //   $newObj->answer2 = "";
//                         $newObj->comment = "";
//                         // $newObj->iscommentconfirmd = 0;
//                         //   $newObj->issendconfirmd = 0;
//                         //    $newObj->isanswerconfirmd = 0;
//                         $newObj->comment_rate = 0;
//                         $newObj->status = "created";
//                         $newObj->expert_cost =$expertService->expert_cost;//percent
//                         $newObj->cost_type = $expertService->cost_type;
//                         //   $newObj->expert_cost_value = $expertService->expert_cost_value;
//                         $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
//                         $newObj->order_num = $newNum;
//                         $newObj->order_date = $now;
//                         $newObj->save();
//                         $this->id = $newObj->id;

    //                         //save values in values_services table
//                         // foreach ($data["valueServices"] as $row) {
//                         //     $valueService = new valueService();
//                         //     $input = InputService::find($row['inputservice_id'])->input()->first();

    //                         //     $valueService->value = $row['value'];
//                         //     $valueService->inputservice_id = $row['inputservice_id'];
//                         //     $valueService->selectedservice_id = $newObj->id;

    //                         //     $valueService->name = $input->name;
//                         //     $valueService->type = $input->type;
//                         //     $valueService->tooltipe = $input->tooltipe;
//                         //     $valueService->icon = $input->icon;
//                         //     $valueService->ispersonal = $input->ispersonal;
//                         //     $valueService->image_count = $input->image_count;
//                         //     $valueService->save();
//                         // }
//                         // decrease client balance
//                         $client->points_balance = $client->points_balance - $expertService->points;
//                         $client->save();
//                         //create point transfer row
//                         $pointtransfer = new Pointtransfer();
//                         $pntctrlr = new PointTransferController();
//                         $type = 'd';
//                         $firstLetters = $type . 'cl-';
//                         $newpnum = $pntctrlr->GenerateCode($firstLetters);
//                         //$pointtransfer->point_id = $formdata['point_id'];
//                         $pointtransfer->client_id = $client->id;
//                         $pointtransfer->expert_id = $expertService->expert_id;
//                         $pointtransfer->service_id = $expertService->service_id;
//                         $pointtransfer->count = $expertService->points;
//                         $pointtransfer->status = 1;
//                         $pointtransfer->selectedservice_id = $newObj->id;
//                         $pointtransfer->side = 'from-client';
//                         $pointtransfer->state = 'agree';
//                         $pointtransfer->type = 'd';
//                         $pointtransfer->num = $newpnum;
//                         $pointtransfer->notes = $expertService->points;
//                         $pointtransfer->save();
//                         //  }
//                     }
//                     //end normal

    //                 } else {
//                     // free with balance
//                     $giftmodel = $avlarr['giftmodel'];
//                     //الرصيد المجاني اكبر او يساوي الكلفة
//                     if ($free_points >= $expertService->points) {
//                         $newfree = $free_points - $expertService->points;
//                         //update gift row
//                         $gift_id = $giftmodel->id;
//                         Gift::find($gift_id)->update([
//                             'free_points' => $newfree,
//                             'status' => 'used',
//                         ]);
//                         // start save selected service
//                         $newNum = $this->GenerateCode("order-");
//                         $now = Carbon::now();
//                         //save selected service
//                         $newObj = new Selectedservice;
//                         $newObj->client_id = $client->id;
//                         $newObj->expert_id = $expertService->expert_id;
//                         $newObj->service_id = $expertService->service_id;
//                         $newObj->points = $expertService->points;
//                         $newObj->rate = 0;
//                         $newObj->form_state = 'agree';

    //                         $newObj->comment = "";

    //                         $newObj->comment_rate = 0;
//                         $newObj->status = "created";
//                         $newObj->expert_cost = $expertService->expert_cost;//percent
//                         $newObj->cost_type = $expertService->cost_type;
//                         //   $newObj->expert_cost_value = $expertService->expert_cost_value;
//                         $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
//                         $newObj->order_num = $newNum;
//                         $newObj->order_date = $now;
//                         $newObj->save();
//                         $this->id = $newObj->id;

    //                         //save values in values_services table
// // foreach ($data["valueServices"] as $row) {
// //     $valueService = new valueService();
// //     $input = InputService::find($row['inputservice_id'])->input()->first();

    //                         //     $valueService->value = $row['value'];
// //     $valueService->inputservice_id = $row['inputservice_id'];
// //     $valueService->selectedservice_id = $newObj->id;

    //                         //     $valueService->name = $input->name;
// //     $valueService->type = $input->type;
// //     $valueService->tooltipe = $input->tooltipe;
// //     $valueService->icon = $input->icon;
// //     $valueService->ispersonal = $input->ispersonal;
// //     $valueService->image_count = $input->image_count;
// //     $valueService->save();
// // }
// //end save selected service
// //add free point transfer
//                         //create point transfer row
//                         $pointtransfer = new Pointtransfer();
//                         $pntctrlr = new PointTransferController();
//                         $type = 'd';
//                         $firstLetters = $type . 'clg-';
//                         $newpnum = $pntctrlr->GenerateCode($firstLetters);
//                         //$pointtransfer->point_id = $formdata['point_id'];
//                         $pointtransfer->client_id = $client->id;
//                         $pointtransfer->expert_id = $expertService->expert_id;
//                         $pointtransfer->service_id = $expertService->service_id;
//                         $pointtransfer->count = $expertService->points;
//                         $pointtransfer->status = 1;
//                         $pointtransfer->selectedservice_id = $newObj->id;
//                         $pointtransfer->side = 'from-gift-client';
//                         $pointtransfer->state = 'agree';
//                         $pointtransfer->type = 'd';
//                         $pointtransfer->num = $newpnum;
//                         $pointtransfer->gift_id = $gift_id;
//                         $pointtransfer->notes = $expertService->points;
//                         $pointtransfer->save();
//                         //end add free point transfer

    //                     } else {
//                         //الرصيد المجاني اصغر تماما من الكلفة
//                         $pointsremain = $expertService->points - $free_points;
//                         if ($client->points_balance < $pointsremain) {
//                             $this->msg = "nopoints";

    //                         } else {
//                             //update gift row
//                             $gift_id = $giftmodel->id;
//                             Gift::find($gift_id)->update([
//                                 'free_points' => 0,
//                                 'status' => 'used',
//                             ]);
//                             //
// // start save selected service
//                             $newNum = $this->GenerateCode("order-");
//                             $now = Carbon::now();
//                             //save selected service
//                             $newObj = new Selectedservice;
//                             $newObj->client_id = $client->id;
//                             $newObj->expert_id = $expertService->expert_id;
//                             $newObj->service_id = $expertService->service_id;
//                             $newObj->points = $expertService->points;
//                             $newObj->rate = 0;
//                             $newObj->form_state = 'agree';
//                             //   $newObj->answer = "";
// //   $newObj->answer2 = "";
//                             $newObj->comment = "";
//                             // $newObj->iscommentconfirmd = 0;
// //   $newObj->issendconfirmd = 0;
// //    $newObj->isanswerconfirmd = 0;
//                             $newObj->comment_rate = 0;
//                             $newObj->status = "created";
//                             $newObj->expert_cost = $expertService->expert_cost;//percent
//                             $newObj->cost_type = $expertService->cost_type;
//                             //   $newObj->expert_cost_value = $expertService->expert_cost_value;
//                             $newObj->expert_cost_value = StorageController::CalcPercentVal($expertService->expert_cost, $expertService->points);
//                             $newObj->order_num = $newNum;
//                             $newObj->order_date = $now;
//                             $newObj->save();
//                             $this->id = $newObj->id;

    //                             //save values in values_services table
// // foreach ($data["valueServices"] as $row) {
// //   $valueService = new valueService();
// //   $input = InputService::find($row['inputservice_id'])->input()->first();

    //                             //   $valueService->value = $row['value'];
// //   $valueService->inputservice_id = $row['inputservice_id'];
// //   $valueService->selectedservice_id = $newObj->id;

    //                             //   $valueService->name = $input->name;
// //   $valueService->type = $input->type;
// //   $valueService->tooltipe = $input->tooltipe;
// //   $valueService->icon = $input->icon;
// //   $valueService->ispersonal = $input->ispersonal;
// //   $valueService->image_count = $input->image_count;
// //   $valueService->save();
// // }
// //end save selected service

    //                             //add free point transfer 
//                             $pointtransfer = new Pointtransfer();
//                             $pntctrlr = new PointTransferController();
//                             $type = 'd';
//                             $firstLetters = $type . 'clg-';
//                             $newpnum = $pntctrlr->GenerateCode($firstLetters);
//                             //$pointtransfer->point_id = $formdata['point_id'];
//                             $pointtransfer->client_id = $client->id;
//                             $pointtransfer->expert_id = $expertService->expert_id;
//                             $pointtransfer->service_id = $expertService->service_id;
//                             $pointtransfer->count = $free_points;
//                             $pointtransfer->status = 1;
//                             $pointtransfer->selectedservice_id = $newObj->id;
//                             $pointtransfer->side = 'from-gift-client';
//                             $pointtransfer->state = 'agree';
//                             $pointtransfer->type = 'd';
//                             $pointtransfer->num = $newpnum;
//                             $pointtransfer->gift_id = $gift_id;
//                             $pointtransfer->notes = $expertService->points;
//                             $pointtransfer->save();
//                             //end add free point transfer
//                             // decrease client balance
//                             $client->points_balance = $client->points_balance - $pointsremain;
//                             $client->save();
//                             //create point transfer row
//                             $pointtransfer = new Pointtransfer();
//                             $pntctrlr = new PointTransferController();
//                             $type = 'd';
//                             $firstLetters = $type . 'cl-';
//                             $newpnum = $pntctrlr->GenerateCode($firstLetters);
//                             //$pointtransfer->point_id = $formdata['point_id'];
//                             $pointtransfer->client_id = $client->id;
//                             $pointtransfer->expert_id = $expertService->expert_id;
//                             $pointtransfer->service_id = $expertService->service_id;
//                             $pointtransfer->count = $pointsremain;
//                             $pointtransfer->status = 1;
//                             $pointtransfer->selectedservice_id = $newObj->id;
//                             $pointtransfer->side = 'from-client';
//                             $pointtransfer->state = 'agree';
//                             $pointtransfer->type = 'd';
//                             $pointtransfer->num = $newpnum;
//                             $pointtransfer->notes = $expertService->points;
//                             $pointtransfer->save();
//                         }
//                     }
//                 }
//                 $this->msg=$this->id ;
//             } else {
//                 $this->msg == "notallowed";
//             }

    //         });
//         $res = [];
//         if ($this->msg == "nopoints" || $this->msg == "notallowed") {
//             $res = [
//                 "message" => 0,
//                 "error" => $this->msg,
//             ];
//         } else {
//             $res = ["message" =>  $this->msg];
//         }
//         return response()->json($res);

    //     }
}
