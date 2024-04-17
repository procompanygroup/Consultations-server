<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Point;
use App\Models\Company;
use App\Models\Pointtransfer;
use App\Models\Cashtransfer;
use File;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\StorageController;
use App\Http\Requests\Api\Client\UpdateClientRequest;
use App\Http\Requests\Api\Client\ChangeBalanceRequest;
use App\Http\Requests\Api\Client\SaveTokenRequest;
use  App\Http\Controllers\Api\NotificationController;



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

    //   public $path = 'images/clients';

    /**
     * Display a listing of the resource.
     */
    public  $pointtransfer_id = 0;
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
        $strgCtrlr = new StorageController();
        $url = $strgCtrlr->ClientPath('image');
        $defaultimg = $strgCtrlr->DefaultPath('image');
        // $url =url( Storage::url($this->path)).'/';
        $user = Client::where('mobile', $credentials)->where('is_active', 1)->select(
            'id',
            'user_name',
            'mobile',
            'country_num',
            'mobile_num',
            'email',
            'nationality',
            'birthdate',
            'gender',
            'marital_status',
            'points_balance',
            'is_active',
            //  DB::raw("CONCAT('$url',image)  AS image")           
            DB::raw("(CASE 
            WHEN image is NULL THEN '$defaultimg'                  
            ELSE CONCAT('$url',image)
            END) AS image")
        )->first();

        $authuser = auth()->user();
        //  return response()->json(['form' =>  $credentials]);
        if (!is_null($user)) {
            if (!($user->mobile == $authuser->mobile)) {
                return response()->json('notexist', 401);
            }

        } else {
            return response()->json('notexist', 401);
        }

        return response()->json(
            $user
        );


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
        $strgCtrlr = new StorageController();
        $path = $strgCtrlr->path['clients'];
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
            //    $url = url('storage/app/public' . '/' . $this->path . '/' . $filename);
            Client::find($id)->update([
                "image" => $filename
            ]);
            Storage::delete("public/" . $path . '/' . $oldimagename);

        }
        return 1;
    }

    public function updateprofile(Request $filerequest)
    {

        $formdata = $filerequest->all();


        //  $file=  $formdata ->file('image');
        $storrequest = new UpdateClientRequest();
        //  $storrequest->request()=$formdata ;
        //   $storrequest=  $formdata ;
        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            /*
              return redirect('/cpanel/users/add')
              ->withErrors($validator)
                          ->withInput();
                          */
            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {
            $id = $formdata["id"];
            $authuser = auth()->user();
            if (!($authuser->id == $id)) {
                return response()->json('notexist', 401);
            } else {
                $birthdate = Carbon::create($formdata["birthdate"])->format('Y-m-d');
                Client::find($id)->update([
                    'user_name' => $formdata['user_name'],
                    'email' => $formdata['email'],
                    'nationality' => $formdata['nationality'],
                    'birthdate' => $birthdate,
                    'gender' => (int) $formdata['gender'],
                    'marital_status' => $formdata['marital_status'],
                ]);
                if ($filerequest->hasFile('image')) {
                    $file = $filerequest->file('image');
                    $this->storeImage($file, $id);
                }


                return response()->json($id);
            }
        }



    }
    public function deleteaccount(Request $filerequest)
    {
        $formdata = request(['id']);
        $id = $formdata["id"];
        $authuser = auth()->user();
        if (!($authuser->id == $id)) {
            return response()->json('notexist', 401);
        } else {
            Client::find($id)->update([
                'is_active' => 0,
            ]);
            auth('api_clients')->logout();
            return response()->json($id);
        }
    }

    public function changebalance()
    {
        $authuser = auth()->user();
        $request = request();

        $formdata = $request->all();
        //client_id
//points
        $storrequest = new ChangeBalanceRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
            //   return redirect()->back()->withErrors($validator)->withInput();

        } else {

            $client = Client::find($formdata['client_id']);
            //   if ($authuser->id == $client->id ) {

            DB::transaction(function () use ($client, $formdata) {
                $point_id = $formdata["point_id"];
                //add points to client 
                $newblnce = $client->points_balance + $formdata['points'];
                Client::find($client->id)->update(
                    [
                        'points_balance' => $newblnce,

                    ]
                );
                //add point transfer for client
                $pointrow = Point::find($point_id);
                $pointtransfer = new Pointtransfer();
                $pntctrlr = new PointTransferController();
                $type = 'p';
                $firstLetters = $type . 'cl-';
                $newpnum = $pntctrlr->GenerateCode($firstLetters);
                $pointtransfer->point_id = isset ($formdata["point_id"]) ? $formdata['point_id'] : null;

                $pointtransfer->client_id = $client->id;
                //  $pointtransfer->expert_id = $expertService->expert_id;
                // $pointtransfer->service_id = $expertService->service_id;
                $pointtransfer->count = $formdata['points'];
                $pointtransfer->status = 1;
                // $pointtransfer->selectedservice_id = $newObj->id;
                $pointtransfer->side = 'to-client';
                $pointtransfer->state = 'points';
                $pointtransfer->type = $type;
                $pointtransfer->num = $newpnum;
                $pointtransfer->save();

                ///////////////////////////
                //add cach transfer to company
                $cashtype1 = 'd';
                $cashtrctrlr = new CashTransferController();
                $firstLetters = $cashtype1 . 'com-';
                $comCode = $cashtrctrlr->GenerateCode($firstLetters);
                $companyCach = new Cashtransfer();

                $companyCach->cash = $pointrow->price;
                $companyCach->cashtype = $cashtype1;
                $companyCach->fromtype = 'client';
                $companyCach->totype = 'company';
                $companyCach->status = 'points';
                //   $companyCach->selectedservice_id = $id;
                $companyCach->cash_num = $comCode;
                $companyCach->pointtransfer_id = $pointtransfer->id;
                $companyCach->save();
                //add cash to company balance
                $comObj = Company::find(1);
                Company::find(1)->update(
                    [
                        'cash_balance' => $comObj->cash_balance + $pointrow->price,
                        // 'cash_profit' => $comObj->cash_profit + $comprofitval,
                    ]
                );

              $this->pointtransfer_id = $pointtransfer->id;

            });
            //send auto notification
            $notctrlr=new NotificationController();
            $pointsval=$formdata['points'];
            $title= __('general.1addpoint_title');
            $body= __('general.1addpoint_body',['Points'=> $pointsval]);
            $notctrlr->sendautonotify($title, $body,'auto','text','','finance',$client->id,0,0,$this->pointtransfer_id);
            return response()->json("ok");

            //   } else {
            //     return response()->json(['error' => 'Unauthenticated'], 401);
            //  }
        }
    }
    public function clientpullbalance($client, $amount)
    {

        DB::transaction(function () use ($client, $amount) {
            //decreas points from client 
            $newblnce = $client->points_balance - $amount;
            Client::find($client->id)->update(
                [
                    'points_balance' => $newblnce,
                ]
            );
            //add point transfer for client
            //   $pointrow = Point::find($point_id);
            $pointtransfer = new Pointtransfer();
            $pntctrlr = new PointTransferController();
            $type = 'd';
            $firstLetters = $type . 'cl-';
            $newpnum = $pntctrlr->GenerateCode($firstLetters);
            // $pointtransfer->point_id = isset ($formdata["point_id"]) ? $formdata['point_id'] : null;

            $pointtransfer->client_id = $client->id;
            //  $pointtransfer->expert_id = $expertService->expert_id;
            // $pointtransfer->service_id = $expertService->service_id;
            $pointtransfer->count = $amount;
            $pointtransfer->status = 1;
            // $pointtransfer->selectedservice_id = $newObj->id;
            $pointtransfer->side = 'to-client';
            $pointtransfer->state = 'pull';
            $pointtransfer->type = $type;
            $pointtransfer->num = $newpnum;
            $pointtransfer->save();

            ///////////////////////////
            //decreas cach transfer to company
            $cashtype1 = 'p';
            $cashtrctrlr = new CashTransferController();
            $firstLetters = $cashtype1 . 'com-';
            $comCode = $cashtrctrlr->GenerateCode($firstLetters);
            $companyCach = new Cashtransfer();

            $companyCach->cash = $amount;
            $companyCach->cashtype = $cashtype1;
            $companyCach->fromtype = 'company';
            $companyCach->totype = 'client';
            $companyCach->status = 'pull';
            //   $companyCach->selectedservice_id = $id;
            $companyCach->cash_num = $comCode;
            $companyCach->pointtransfer_id = $pointtransfer->id;
            $companyCach->save();
            //decrese cash to company balance
            $comObj = Company::find(1);
            Company::find(1)->update(
                [
                    'cash_balance' => $comObj->cash_balance - $amount,

                ]
            );
        });

        return 1;
    }
    public function savetoken()
    {

        $request = request();

        $formdata = $request->all();
        //client_id
//points
        $storrequest = new SaveTokenRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {

            return response()->json($validator->errors());
        } else {

            $client_id = $formdata['client_id'];
            //save token in client 

            Client::find($client_id)->update(
                [
                    'token' => $formdata["token"],
                ]
            );
            return response()->json("ok");

        }
    }

    

}
