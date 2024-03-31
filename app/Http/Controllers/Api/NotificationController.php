<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Models\User;
use App\Http\Controllers\Api\StorageController;
use Notification;

class NotificationController extends Controller
{

    public function saveToken(Request $request)
    {
   //  print_r($request->all());
     auth()->user()->update(['token'=>$request->token]);
   return response()->json(['Token Saved!']);
    }
    public function sendNotification(Request $request)
    {
      $strgCtrlr=new StorageController();
      $defaultimg=$strgCtrlr->DefaultPath('image');
      $defaultsvg=$strgCtrlr->DefaultPath('icon');
      
      $tokenList=User::whereNotNull('token')->pluck('token')->all();
      return Larafirebase::withTitle($request->title)
      ->withBody($request->body)
      ->withImage($defaultimg)
      ->withIcon($defaultsvg)
      ->withSound('default')
      ->withClickAction('https://www.google.com')
      ->withPriority('high')
      ->withAdditionalData([
          'color' => '#000000',
          'badge' => 0,
          'username'=>"Ahmad",
          'image'=>$defaultimg,
      ])
    ->  sendMessage($tokenList);
    //  ->sendNotification($tokenList);
    }
    public function sendbytoken(Request $request)
    {
      $strgCtrlr=new StorageController();
      $defaultimg=$strgCtrlr->DefaultPath('image');
      $defaultsvg=$strgCtrlr->DefaultPath('icon');
      $formdata = $request->all();
      $token="";
      if(isset($formdata['input_token'])){
        $token=$formdata['input_token'];

        $tokenList =[$token];
        
        return Larafirebase::withTitle($request->title)
        ->withBody($request->body)
        ->withImage($defaultimg)
        ->withIcon($defaultsvg)
        ->withSound('default')
        ->withClickAction('https://www.google.com')
        ->withPriority('high')        
        ->withAdditionalData([         
            'username'=>"Ahmad",
            'image'=>$defaultimg,
        ])
      ->  sendMessage($tokenList);
      }else{
        return 'empty token'  ;
      }
     

    //  ->sendNotification($tokenList);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.notify.show' );
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
