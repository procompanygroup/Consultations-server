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
use Illuminate\Support\Facades\Storage;
class ExpertController extends Controller
{
    
    public $path = 'images/experts';
    public $recordpath = 'images/experts/records';
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
      $url =url(Storage::url($this->path)).'/';
       // $url = url('storage/app/public' . '/' . $this->path  ).'/';
      //  $pass=request(['password']);
     //   $passval=$pass['password'];
    // $passhash=bcrypt($passval);
      
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
            if (!(($user->user_name == $authuser->user_name)
           // && (Hash::check( $passval, $user->password))
        ) ){
                return response()->json(['error' => 'notexist'], 401);
            }

        } else {
            return response()->json(['error' => 'notexist'], 401);
        }
 
        return response()->json([
          'expert' => $user
          
        ]);
        }
        public function getexpertsbyserviceid()
        {
           $data = request(['id']);
           $id=$data ['id'];
          //  $url = url('storage/app/public' . '/' . $this->path  ).'/';
          $url =url(Storage::url($this->path)).'/';
          $recurl =url(Storage::url($this->recordpath)).'/';
          //  $recurl = url('storage/app/public' . '/' . $this->recordpath  ).'/';
          //  $pass=request(['password']);
         //   $passval=$pass['password'];
        // $passhash=bcrypt($passval);
          
            $List = Expert::wherehas('expertsServices',function ( $query)use ($id) {
                $query->where('service_id',  $id);
                /*
                $query->select(
                    'id'
                    'service_id',
                    'expert_id',
                    'points',
                    'expert_cost',
                    'cost_type',
                    'expert_cost_value',
                );
*/
            })->with('expertsServices:id,service_id,expert_id,points,expert_cost,cost_type,expert_cost_value')
            ->select(
                'id',
                'user_name',              
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
                 
                DB::raw("(CASE 
                WHEN record = '' THEN ''                     
                ELSE CONCAT('$recurl',record)
                END) AS record"),
                'desc',
                'call_cost',
                'answer_speed',
                DB::raw("(CASE 
                WHEN image = '' THEN ''                     
                ELSE CONCAT('$url',image)
                END) AS image")
            )->get();
    
          
            //  return response()->json(['form' =>  $credentials]);
            
     
            return response()->json([
              'expert' =>$List
              
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
