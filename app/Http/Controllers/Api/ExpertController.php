<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expert;
use Illuminate\Support\Facades\DB;

use File;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
class ExpertController extends Controller
{
    
    public $path = 'images/experts';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('experts')->get();
        // return view('admin.user.showusers',['users' => $users]); 
        return response()->json($users);
    }
    public function getexpert()
    {
      //  $credentials = request(['user_name','password']);
        $url = url('storage/app/public' . '/' . $this->path  ).'/';
        $pass=request(['password']);
        $passval=$pass['password'];
     $passhash=bcrypt($passval);
       // $passhash=Hash::make( $passval);
      // Hash::check('plain-text-password', $hashedPassword)
        $user = Expert::where('user_name',request(['user_name']))->
   //where('password',  $passhash)->
        select(
            'id',
            'user_name',
            'password',
            'mobile',
            'email',
            'nationality',
            'birthdate',
            'gender',
            'marital_status',             
            'is_active',
            'points_balance',
            'cash_balance',
            'cash_balance_todate',
            'rates',
            'record',
            'desc',
            'call_cost',
            'answer_speed',
            DB::raw("(CASE 
            WHEN image = '' THEN ''                     
            ELSE CONCAT('$url',image)
            END) AS image")
        )->first();

        $authuser = auth()->user();
        //  return response()->json(['form' =>  $credentials]);
        if (!is_null($user)) {
            if (!(($user->user_name == $authuser->user_name)&& (Hash::check( $passval, $user->password))) ){
                return response()->json(['error' => 'notexist'], 401);
            }

        } else {
            return response()->json(['error' => 'notexist'], 401);
        }
 
        return response()->json([
          'expert' => $user
          
        ]);
        }
    public function addUser(Expert $newExpert)
    {
        $newExpert->save();
        return $newExpert;
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
}
