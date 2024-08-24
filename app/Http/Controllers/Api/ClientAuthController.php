<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Client\StoreClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\Api\AuthenticateClient;
use JWTAuth;
use Carbon\Carbon;
class ClientAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('authClient:api_clients', ['except' => ['register','login','loginclient','registerclient']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
  
        $credentials = request(['mobile']);
        $user= Client::where('mobile',  $credentials)->where('is_active',1)->first();
      //  return response()->json(['form' =>  $credentials]);
        if (  !is_null( $user)) {
            if(! $token = auth('api_clients')->fromUser($user)){
                return response()->json(['error' => 'notexist'], 401);
            }
           
        }else{
            return response()->json(['error' => 'notexist'], 401);
        }
        //Auth::check();
     //  $atype=  Auth::user()->type; 
   //  $user=auth('api_clients')->user();
    // auth('api_clients')->login($user);
       return response()->json([
        'token' => $token,
       // 'user'=> $user,   
     ]);
      
    }

    public function register(Request $filerequest)
    {
        $clintCont=new clientController();
        $formdata = $filerequest->all();
        $cnum ="";
        $mnum = "";
        if(isset($formdata["country_num"])){
          $cnum = $formdata["country_num"];
        }
        if(isset($formdata["mobile_num"])){
          $mnum = $formdata["mobile_num"];
        }
    
    //    $id = $formdata["id"];
        /*
        $formdata = request(['user_name',
        'password',
         'mobile',
        'email',
        'nationality',
         'birthdate',
         'gender',
        'marital_status',
         'image',
     //  'token',
        //'points_balance',
    ]);
    */
   
  //  $file=  $formdata ->file('image');
      $storrequest=new StoreClientRequest();
    //  $storrequest->request()=$formdata ;
   //   $storrequest=  $formdata ;
      $validator = Validator::make($formdata,
      $storrequest->rules(  $cnum,$mnum),
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
      
     
        $newObj=new Client();
        $birthdate= Carbon::create($formdata["birthdate"])->format('Y-m-d');
   
        $newObj->user_name= $formdata["user_name"];
      
        $newObj->email= $formdata["email"];
        $newObj->country_num = $cnum;
        $newObj->mobile_num = $mnum;
        $newObj->mobile = $cnum. $mnum;
        $newObj->nationality= $formdata["nationality"];
        $newObj->birthdate= $birthdate;
        $newObj->gender= $formdata["gender"];
        $newObj->marital_status= $formdata["marital_status"];
      //  $newObj->is_active = 0;
   
        $newObj= $clintCont->addUser( $newObj);
     //  if( isset($formdata["image"]))
     //  {
        if ($filerequest->hasFile('image')) {
            $file= $filerequest->file('image');
            $clintCont->storeImage( $file,$newObj->id);
        }
  //    }
       // return response()->json(['formdata' => $formdata ]);
        // return response()->json(['userName' => $formdata["userName"]]);
         return response()->json($newObj->id);
      }

    /*
    {
    "userName":"ahmad2",
     "password":"123123",
    "email":"aa@gmail.com",
    "mobile":"0957575",
    "nationality":"syr",
    "gender":0,
    "maritalStatus":"single",
    "image":""
    }
    */
  
  
      //  $token=Auth::login($user);

      //  return response()->json(['name' => 'Unauthorized']);
        /*
        $credentials = request(['userName', 'password']);

        if (! $token = auth('api_clients')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
        */
    }
     
  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api_clients')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout_client()
    {
      $user_id = auth('api_clients')->user()->id;
      Client::find($user_id)->update([
        'token' => '',
    ]);
        auth('api_clients')->logout();

        return response()->json('ok');
    }
    public function logout()
    {
        auth('api_clients')->logout();
        
         return response()->json('Success');
    }
    /*
 public function login()
    {
     //   $credentials = request(['username', 'password']);
      //   return response()->json( $request);
  

        $credentials = request(['mobile','password']);
      //  return response()->json(['form' =>  $credentials]);
        if (! $token = auth('api_clients')->attempt($credentials)) {
            return response()->json(['error' => 'UnauthorizedC'], 401);
        }
        //Auth::check();
     //  $atype=  Auth::user()->type; 
     $user=auth('api_clients')->user();
     auth('api_clients')->login($user);
       return response()->json([
        'token' => $token,
        'user'=> $user,   
    ] );
       
      //  $passhash=Hash::make( $request['password']);
     
     //  return $this->respondTokenwithExpire($token);
        
    }

    */
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api_clients')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api_clients')->factory()->getTTL() * 60
        ]);
    }
    protected function respondTokenwithExpire($token)
    {
        return response()->json([
            ' token' => $token,           
            'expires_in' => auth('api_clients')->factory()->getTTL() * 60
        ]);
    }

  
}
