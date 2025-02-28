<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\ClientDelOrder;
use File;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Client\StoreClientRequest;
use App\Http\Requests\Web\Client\UpdateClientRequest;
use App\Models\Pointtransfer;
use App\Models\Cashtransfer;
use App\Models\Expertfavorite;
use App\Models\Servicefavorite;
use App\Models\Selectedservice;
use App\Http\Controllers\Api\StorageController;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  //  public $path = 'media/clients';
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
      $list =Client::where('is_active',1)->get();
      return view('admin.client.show', ['clients' => $list]);
      //return response()->json($users);
  
    }
   
    
    public function showbalance()
    {
      $list = Client::where('is_active',1)->get();
      
    return view('admin.balance.client', ['clients' => $list]);
      //return response()->json($users);
  
    }
    public function showoperations($id)
    {
      $list = Pointtransfer::with( 'cashtransfers', 'selectedservices')
      ->where('client_id',$id)
      ->where(function ($query) {
        $query->where('side','from-client')
              ->orWhere('side','to-client')->orWhere('side','from-gift-client');
    })->get();
      
      
 
     //'cashtransfers',
      $object = Client::find($id);
// return $list ;
   return view('admin.operation.client', ['transfers' => $list,'client' => $object]);
      //return response()->json($users);
  
    }

  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.client.add');
    }
  
    /**
     * Store a newly created resource in storage.
     */
  //   public function store(Request $request)
  //   {
  //     $formdata = $request->all();
  //     $validator = Validator::make(
  //       $formdata,
  //       $request->rules(),
  //       $request->messages()
  //     );
  
  //     if ($validator->fails()) {
  
  //       return redirect()->back()->withErrors($validator)
  //         ->withInput();
  
  //     } else {
       
  //       $newObj = new Client;
 
  // $newObj->user_name = $formdata['user_name'];
  // $newObj->password = $formdata['password'];
  // $newObj->mobile = $formdata['mobile'];
  // $newObj->email = $formdata['email'];
  // $newObj->nationality = $formdata['nationality'];
  // $newObj->birthdate = $formdata['birthdate'];
  // $newObj->gender = $formdata['gender'];
  // $newObj->marital_status = $formdata['marital_status'];
  // $newObj->image = $formdata['image'];
  // $newObj->points_balance = $formdata['points_balance'];
  // $newObj->cash_balance =0;
  // $newObj->cash_balance_todate = 0;
  // $newObj->rates = 0;
  // $newObj->record = $formdata['record'];
  // $newObj->desc = $formdata['desc'];
  // $newObj->call_cost = $formdata['call_cost'];
  // //$newObj->token = $formdata['token'];
  
  
  //       $newObj->save();
  //       //save image
  //     //  $this->path = 'media/clients';
  //       $separator = '/';
  //       if ($request->hasFile('image')) {
  //         // $imagemodel->save();
  //         $image_tmp = $request->file('image');
  //         if ($image_tmp->isValid()) {
  //           $folderpath = $this->path . $separator;
  //           //Get image Extension
  //           $extension = $image_tmp->getClientOriginalExtension();
  //           //Generate new Image Name
  
  //           $now = Carbon::now();
  //           $imageName = rand(10000, 99999) . $newObj->id . '.' . $extension;
  
  //           if (!File::isDirectory($folderpath)) {
  //             File::makeDirectory($folderpath, 0777, true, true);
  //           }
  //           $imagePath = $folderpath . $imageName;
  //           //Upload the Image
  //           $manager = new ImageManager(new Driver());
  
  //           // read image from filesystem
  //           $image = $manager->read($image_tmp);
  //           //$image= $image->toWebp(75);
  //           $image->save($imagePath);
  //           //$fullpath= url($imagePath);
  
  //           Client::find($newObj->id)->update([
  //             "image" => $imageName
  //           ]);
  
  //           // if(File::exists($oldimagepath )){
  //           //   File::delete($oldimagepath );
  //           // }
  //         }
  //       }
  
  //       return redirect()->back()->with('success_message', 'user has been Added!');
  //     }
  //   }
  
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      $strgCtrlr=new StorageController();
      //$url=$strgCtrlr->ExpertPath('image');
     // $recurl=$strgCtrlr->ExpertPath('record');
     // $url =url(Storage::url($this->path)).'/';
      $object = Client::find($id);
      $object->birthdateStr= (string)Carbon::create($object->birthdate)->format('d/m/Y');
      $url=$strgCtrlr->InputPath('icon');
      $usericon= $url.'username.svg';
     $mobileicon=$url.'mobile-phone-icon.svg';
     $emailicon=$url.'email.svg';
     $nationalityicon=$url.'nationality.svg';
     $birthicon=$url.'birthdate.svg';
     $gendericon=$url.'gender.svg';
     $martialicon=$url.'martial.svg';
 
      // if( $object->image !="" ){
      //   $object->fullpathimg= $url.$object->image;
      // }
      //
       //return  dd ($object);
      return view('admin.client.showinfo', ['client' => $object,
      'usericon' =>$usericon ,
      'mobileicon' =>$mobileicon,
      'emailicon' =>$emailicon,
      'nationalityicon' =>$nationalityicon, 
      'birthicon' =>$birthicon, 
      'gendericon' =>$gendericon, 
      'martialicon' =>$martialicon
    ]);
    }
  
    /** 
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $object = DB::table('clients')->find($id);
  
      //
      return view('admin.client.edit', ['client' => $object]);
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      $formdata = $request->all();
      //validate      
      $validator = Validator::make(
        $formdata,
        $request->rules(),
        $request->messages()
      );
      if ($validator->fails()) {
        /*
          return redirect('/cpanel/users/add')
          ->withErrors($validator)
                      ->withInput();
                      */
        return redirect()->back()->withErrors($validator)
          ->withInput();
  
      } else {
        $imagemodel = Client::find($id);
        $oldimage = $imagemodel->image;
        Client::find($id)->update([
          'user_name' => $formdata['user_name'],
          'password' => $formdata['password'],
          'mobile' => $formdata['mobile'],
          'email' => $formdata['email'],
          'nationality' => $formdata['nationality'],
          'birthdate' => $formdata['birthdate'],
          'gender' => $formdata['gender'],
          'marital_status' => $formdata['marital_status'],
       //   'image' => $formdata['image'],
      //    'points_balance' => $formdata['points_balance'],
       //   'cash_balance' => $formdata['cash_balance'],
        //  'cash_balance_todate' => $formdata['cash_balance_todate'],
        //  'rates' => $formdata['rates'],
          'record' => $formdata['record'],
          'desc' => $formdata['desc'],
          'call_cost' => $formdata['call_cost'],
       //   'token' => $formdata['token'],
          
        ]);
        //save image
 /*
        $separator = '/';
        if ($request->hasFile('image')) {
          // $imagemodel->save();
          $image_tmp = $request->file('image');
          if ($image_tmp->isValid()) {
            $folderpath = $this->path . $separator;
            //Get image Extension
            $extension = $image_tmp->getClientOriginalExtension();
            //Generate new Image Name
            $now = Carbon::now();
            $imageName = rand(10000, 99999) . $id . '.' . $extension;
            if (!File::isDirectory($folderpath)) {
              File::makeDirectory($folderpath, 0777, true, true);
            }
            $imagePath = $folderpath . $imageName;
            //Upload the Image
            $manager = new ImageManager(new Driver());
            // read image from filesystem
            $image = $manager->read($image_tmp);
            //$image= $image->toWebp(75);
            $image->save($imagePath);
            Client::find($id)->update([
              "image" => $imageName
            ]);
  
            //  delete old image
            $oldimagepath = $this->path . $separator . $oldimage;
            if (File::exists($oldimagepath)) {
              File::delete($oldimagepath);
            }
             
            return redirect()->back()->with('success_message', 'user has been Updated!');
          }
        }
*/
return redirect()->back()->with('success_message', 'user has been Updated!');
      }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $object = Client::find($id);
      if (!($object === null)) {
  
        //delete check related tables
        //   $item1= ExpertService::where('client_id',$id)->first();
        //   $item1= Expertfavorite::where('client_id',$id)->first();
        $item1 = Pointtransfer::where('client_id', $id)->first();
        $item2 = Cashtransfer::where('client_id', $id)->first();
        $item3 = Selectedservice::where('client_id', $id)->first();
        if (!($item1 === null) || !($item2 === null) || !($item3 === null)) {
         // disable client account
         Client::find($id)->update([
          "is_active" => 0
        ]);
  
        } else {
         
    //delete image
    if (!empty($object->image)) {
      $strgCtrlr=new StorageController();
      $path=$strgCtrlr->path['clients'];
      $imgpath =  $path . '/' . $object->image;
      if (File::exists($imgpath)) {
        File::delete($imgpath);
      }
    }
//delete related rows
    
    Expertfavorite::where('client_id', $id)->delete();
  // Servicefavorite::where('client_id', $id)->delete();
    //delete object
    Client::find($id)->delete();
        }
      }
      return redirect()->route('client.index');
      // return  $this->index();
      //   return redirect()->route('users.index');
  
    }


public function del_client($order_id)
    {
      $order=ClientDelOrder::find($order_id);
      $id=$order->client_id;
      $object = Client::find($id);
      if (!($object === null)) {  
    
            //delete image
    if (!empty($object->image)) {
      $strgCtrlr=new StorageController();
      $path=$strgCtrlr->path['clients'];
      $imgpath =  $path . '/' . $object->image;
      if (File::exists($imgpath)) {
        File::delete($imgpath);
      }
    }
    Expertfavorite::where('client_id', $id)->delete();
        $item1 = Pointtransfer::where('client_id', $id)->first();
        $item2 = Cashtransfer::where('client_id', $id)->first();
        $item3 = Selectedservice::where('client_id', $id)->first();
        if (!($item1 === null) || !($item2 === null) || !($item3 === null)) {
         // disable client account
         Client::find($id)->update([
     
          'user_name'=>'',
          'password'=>'',
           'mobile'=>'',
          'email'=>'',
          'nationality'=>'',
           'birthdate'=>null,
           'gender'=>null,
          'marital_status'=>null,
           'image'=>'',
          'token'=>null,
          'points_balance'=>0,
          'minutes_balance'=>0,
          'is_active'=>0,
          'country_code'=>'',
   'country_num'=>'',
   'mobile_num'=>'',
        ]);
  
        } else {

    //delete object
    Client::find($id)->delete();
        }
        ClientDelOrder::find($order_id)->delete();
      }
      return 1;
    }
    // delete orders
    public function del_orders()
    {
      $list =ClientDelOrder::with('client')->orderByDesc('created_at')->get();

      return view('admin.client.del-show', ['delorders' => $list]);
      //return response()->json($users);
  
    }
    
    public function show_order($id)
    {
      $strgCtrlr=new StorageController();
      //$url=$strgCtrlr->ExpertPath('image');
     // $recurl=$strgCtrlr->ExpertPath('record');
     // $url =url(Storage::url($this->path)).'/';
     $order=ClientDelOrder::with('client')->find($id);
  //    $object = Client::find($id);
  $order->client->birthdateStr= (string)Carbon::create( $order->client->birthdate)->format('d/m/Y');
      $url=$strgCtrlr->InputPath('icon');
      $usericon= $url.'username.svg';
     $mobileicon=$url.'mobile-phone-icon.svg';
     $emailicon=$url.'email.svg';
     $nationalityicon=$url.'nationality.svg';
     $birthicon=$url.'birthdate.svg';
     $gendericon=$url.'gender.svg';
     $martialicon=$url.'martial.svg';
     $sharp= $strgCtrlr->DefaultPath('sharp');
 
      // if( $object->image !="" ){
      //   $object->fullpathimg= $url.$object->image;
      // }
      //
       //return  dd ($object);
      return view('admin.client.del-showinfo', ['order' =>  $order,
      'usericon' =>$usericon ,
      'mobileicon' =>$mobileicon,
      'emailicon' =>$emailicon,
      'nationalityicon' =>$nationalityicon, 
      'birthicon' =>$birthicon, 
      'gendericon' =>$gendericon, 
      'martialicon' =>$martialicon,
    'sharp' =>  $sharp,
    ]);
    }

    public function del_client_request($id)
    {
     $res= $this->del_client($id);
     
      if( $res==1){
        return redirect()->route('client.del-order.all')->with('success-msg','deleted');
      }else{
        return redirect()->back()->with( 'error-msg','not-deleted');
      }
     
    }
   
}
