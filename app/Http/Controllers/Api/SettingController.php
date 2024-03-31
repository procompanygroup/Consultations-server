<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
//use App\Http\Requests\Web\Setting\UpdateExpertServicePointsRequest;
//use App\Http\Requests\Web\Setting\UpdateExpertPercentRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
    }
    public function getkeys()
    {
             $list =Setting::select("id",
             "name",
             "value",            
             "ar_name" 
          )->get();
        $secret_key=$this->findbyname('secret_key');
        $publishable_key=$this->findbyname('publishable_key');
    //    return view('admin.setting.show', ['expert_percent'=>$expert_percent,'expert_service_points'=>$expert_service_points]);
        return response()->json(
            ['secret_key' => $secret_key->value
        ,'publishable_key'=> $publishable_key->value] );
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
    public function findbyname(string $name)
    {
      $object=Setting::where('name',$name)->first();
      
      return $object;
    }
}
