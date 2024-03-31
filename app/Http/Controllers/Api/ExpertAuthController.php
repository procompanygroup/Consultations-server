<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Expert\StoreExpertRequest;
use Illuminate\Http\Request;

use App\Http\Requests\Api\Client\StoreClientRequest;
use App\Models\Expert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ExpertController;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\Api\AuthenticateExpert;
use JWTAuth;
 
class ExpertAuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('authExpert:api', ['except' => ['register','login','loginexpert','registerexpert']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
/*
    public function login()
    {
     //   $credentials = request(['username', 'password']);
      //   return response()->json( $request);
   
      //  $request->validate(
        //    ['userName'=>'required',
       //     'password'=>'required',
      //  ]
      //  );
       
        $credentials = request(['user_name', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'notexist'], 401);
        }
        
      //  $user = User::where('userName',$credentials['userName'])
     //   ->where('password',$credentials['password']);
      
      //  $passhash=Hash::make( $request['password']);
    
        
      //  $user=auth('api')->user();
      //  auth('api')->login( $user);
       // $type=  auth('api')->type();
       // Auth::login($user);
        return response()->json(
            [
                'token' => $token,                
             ]
           // 'message'=>"success",
          //  'user'=> $user,
         //   'type'=>  $type,
        );
    //   return $this->respondTokenwithExpire($token);        
    }
*/


    public function login()
    {
     //   $credentials = request(['user_name', 'password']);
     $formdata=request();
        $user_name=$formdata['user_name'];
        $password= $formdata['password'];
     //   $credentials = request(['mobile']);
       
     
        $user= Expert::where('user_name',$user_name)->where('is_active',1)->first();
      //  return response()->json(['form' =>  $credentials]);
        if (!is_null( $user)) {
            if (Hash::check( $password,$user->password)) {
                // The passwords match...
                if(! $token =auth('api')->fromUser($user)){
                    return response()->json(['error' => 'notexist'], 401);
                }
            }else{
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
    public function register()
    {
        $userCont=new ExpertController();
        $formdata = request(['user_name',
        'password',
         'mobile',
         
        'email',
        'nationality',
         'birthdate',
         'gender',
        'marital_status',
         'image',
        'token',
        'points_balance',
    ]);
      $storrequest=new StoreExpertRequest();
    //  $storrequest->request()=$formdata ;
   //   $storrequest=  $formdata ;
      $validator = Validator::make($formdata,
      $storrequest->rules(),
      $storrequest->messages()
    );
    if ($validator->fails()) {
        /*
          return redirect('/cpanel/users/add')
          ->withErrors($validator)
                      ->withInput();
                      */
                      return response()->json(['errorValidation' => $validator->errors()]);
     //   return redirect()->back()->withErrors($validator)->withInput();
  
      } else {

        $user=new Expert();
        $user->userName= $formdata["userName"];
        $user->password= $formdata["password"];
        $user->email= $formdata["email"];
        $user->mobile= $formdata["mobile"];
        $user->nationality= $formdata["nationality"];
        $user->gender= $formdata["gender"];
        $user->maritalStatus= $formdata["maritalStatus"];
        $user->image= $formdata["image"];
        $user= $userCont->addUser($user);

       // return response()->json(['formdata' => $formdata ]);
        // return response()->json(['userName' => $formdata["userName"]]);
         return response()->json(['userId' => $user->id]);
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

        if (! $token = auth()->attempt($credentials)) {
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
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json('Success');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    protected function respondTokenwithExpire($token)
    {
        return response()->json([
            ' token' => $token,           
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
  
}
