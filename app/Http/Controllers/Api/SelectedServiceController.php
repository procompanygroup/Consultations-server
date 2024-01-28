<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        //
    }
    public function savewithvalues( )
    {
        //
       $request=  request();

        $data = json_decode( $request->getContent(), true);
        //check client balance
        $client=Client::find($data['client_id']);
        $expertService=ExpertService::where('expert_id',$data['expert_id'])->where('service_id',$data['service_id'])->first();
        
        if( $client->points_balance< $expertService->points){
        return response()->json([
            "error" => "nopoints",
            "message" => 0,
           // 'user'=> $user,   
         ]  );
    }else{
        //save selected service
        $newObj = new Selectedservice;
        $newObj->client_id = $client->id;
 $newObj->expert_id = $expertService->expert_id;
 $newObj->service_id =$expertService->service_id;
 $newObj->points = $expertService->points;
 $newObj->rate = 0;
 $newObj->answer = "";
 $newObj->answer2 ="";
 $newObj->comment ="";
 $newObj->iscommentconfirmd = 0;
 $newObj->issendconfirmd = 0;
 $newObj->isanswerconfirmd = 0;
 $newObj->comment_rate =0;
 $newObj->status ="created";
 $newObj->expert_cost=$expertService->expert_cost;
 $newObj->cost_type=$expertService->cost_type;
 $newObj->expert_cost_value=$expertService->expert_cost_value;

 $newObj->save();

        
        //save values in values_services table
        foreach( $data[ "valueServices"] as $row ){
           $valueService=new valueService();
           $valueService->value=$row['value'];
           $valueService->inputservice_id=$row['inputservice_id'];
           $valueService->selectedservice_id= $newObj->id;
           $valueService->save();

}
// decrease client balance
$client->points_balance= $client->points_balance- $expertService->points;
$client->save();
//create point transfer row
$pointtransfer=new Pointtransfer();
//$pointtransfer->point_id = $formdata['point_id'];
$pointtransfer->client_id = $client->id;
$pointtransfer->expert_id = $expertService->expert_id;
$pointtransfer->service_id =$expertService->service_id;
$pointtransfer->count = $expertService->points;
$pointtransfer->status = 1;
$pointtransfer->selectedservice_id =$newObj->id;
$pointtransfer->side = 'from-client';

$pointtransfer->save();
        return response()->json( [           
            "message" => $newObj->id
           // 'user'=> $user,   
         ]   );
    }
       
        //$data = request(['id']);

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
}
