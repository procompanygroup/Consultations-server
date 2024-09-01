<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Setting\UpdateCallCostRequest;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Web\Setting\UpdateExpertServicePointsRequest;
use App\Http\Requests\Web\Setting\UpdateExpertPercentRequest;
use App\Http\Requests\Web\Setting\UpdatePublishablekeyRequest;
use App\Http\Requests\Web\Setting\UpdateSecretkeyRequest;
use App\Http\Requests\Web\Setting\UpdateExpireDaysRequest;
use App\Http\Requests\Web\Setting\UpdateAppLinkRequest;


class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //  $list =Setting::get();
    $expert_percent = $this->findbyname('expert_percent');
    $expert_service_points = $this->findbyname('expert_service_points');
    $secret_key = $this->findbyname('secret_key');
    $publishable_key = $this->findbyname('publishable_key');
    $gift_expire_days = $this->findbyname('gift_expire_days');
    $call_cost = $this->findbyname('call_cost');
    $gplay_link = $this->findbyname('gplay_link');
    $appstor_link = $this->findbyname('appstor_link');
    $x_link = $this->findbyname('x_link');
    $facebook_link = $this->findbyname('facebook_link');
    //  updatepoints
    return view('admin.setting.show', [
      'expert_percent' => $expert_percent,
      'expert_service_points' => $expert_service_points,
      'secret_key' => $secret_key,
      'publishable_key' => $publishable_key,
      'gift_expire_days' => $gift_expire_days,
      'call_cost' => $call_cost,
      'gplay_link' => $gplay_link,
      'appstor_link' => $appstor_link,
      'x_link' => $x_link,
      'facebook_link' => $facebook_link,
    ]);

    //  return view('admin.setting.show', ['settings' => ['expert_percent'=>$expert_percent,'expert_service_points'=>$expert_service_points]]);
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
   * Display the specified resource.php artisan make:request Web/Setting/UpdateSettingRequest
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
    $object = Setting::where('name', $name)->first();

    return $object;
  }

  public function updatepercent(UpdateExpertPercentRequest $request, $id)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);

    } else {

      Setting::find($id)->update([

        'value' => $formdata['expert_percent'],

      ]);

      //save image
      return response()->json("ok");

    }
  }

  public function updatecallcost(UpdateCallCostRequest $request, $id)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);
    } else {
      Setting::find($id)->update([
        'value' => $formdata['call_cost'],
      ]);
      //save image
      return response()->json("ok");
    }
  }

  public function updatepoints(UpdateExpertServicePointsRequest $request, $id)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);

    } else {

      Setting::find($id)->update([

        'value' => $formdata['expert_service_points'],

      ]);

      //save image
      return response()->json("ok");

    }
  }

  ////
  public function updatesecretkey(UpdateSecretkeyRequest $request, $id)
  {

    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);

    } else {

      Setting::find($id)->update([

        'value' => $formdata['secret_key'],

      ]);

      //save image
      return response()->json("ok");

    }
  }
  public function updatepublishablekey(UpdatePublishablekeyRequest $request, $id)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);

    } else {

      Setting::find($id)->update([
        'value' => $formdata['publishable_key'],
      ]);

      //save image
      return response()->json("ok");

    }
  }


  public function updatedays(UpdateExpireDaysRequest $request, $id)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);

    } else {

      Setting::find($id)->update([

        'value' => $formdata['expire_days'],

      ]);

      //save image
      return response()->json("ok");

    }
  }
  public function expiredays()
  {
    $gift_expire_daysrow = $this->findbyname('gift_expire_days');
    $days = 0;
    if ($gift_expire_daysrow) {
      $days = $gift_expire_daysrow->value;
    }
    return $days;
  }
  public function updateapplink(UpdateAppLinkRequest $request)
  {
    $formdata = $request->all();
    //validate
    $validator = Validator::make(
      $formdata,
      $request->rules(),
      $request->messages()
    );
    if ($validator->fails()) {
      return response()->json($validator);
    } else {

if(isset($formdata['gplay_link']))
{
  $object = Setting::where('name','gplay_link')->first();
$object->value=$formdata['gplay_link'];
$object->save();
}
if(isset($formdata['appstor_link']))
{
$object = Setting::where('name','appstor_link')->first();
$object->value=$formdata['appstor_link'];
$object->save();
}
 
      return response()->json("ok");
    }
  }

  public function updatesociallink(Request $request)
  {
    $formdata = $request->all();      //validate
   
if(isset($formdata['x_link']))
{
  $object = Setting::where('name','x_link')->first();
$object->value=$formdata['x_link'];
$object->save();
}
if(isset($formdata['facebook_link']))
{
$object = Setting::where('name','facebook_link')->first();
$object->value=$formdata['facebook_link'];
$object->save();
} 
      return response()->json("ok");
    
  }
}
