<?php
namespace App\Http\Controllers;
use App\Http\Requests\Api\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
     //   $credentials = request(['username', 'password']);
      //   return response()->json( $request);
    /*
        $request->validate(
            ['userName'=>'required',
            'password'=>'required',
        ]
        );
        */
        $credentials = request(['userName', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        /*
        $user = User::where('userName',$credentials['userName'])
        ->where('password',$credentials['password']);
        */
      //  $passhash=Hash::make( $request['password']);
        /*
     $user = auth()->user();
      // $user = User::find(1);
      
        return response()->json([
            'token' => $token,
            'message'=>"success",
            'user'=>  $user ,
             'username'=> $user->userName,
             
       
        ] );
         */
       return $this->respondTokenwithExpire($token);
        
    }
    public function register()
    {
        $userCont=new UserController();
        $formdata = request(['name',
        'userName', 
        'password',      
        'email',
        'mobile',
        'nationality',
        'gender' ,
        'maritalStatus',
        'image',
    ]);
      $storrequest=new StoreUserRequest();
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

        $user=new User();
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
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    protected function respondTokenwithExpire($token)
    {
        return response()->json([
            ' token' => $token,           
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
  
}