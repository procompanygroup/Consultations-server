<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\Providers\MailConfigServiceProvider;
use App\Models\ClientEmail;
use Illuminate\Http\Request; 
use DB;
//use Config;
use Mail;
use  App\Mail\VerifyEmail;
use App;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Mail\GetMailRequest;
use App\Http\Requests\Api\Mail\ValidateCodeRequest;

use Config;
 //use URL;
//  use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
//use FFMpeg;
class MailController extends Controller
{
    public function viewForm()
    {
        return view('mail.add');
    }
    public function create(Request $request)
    {
     
   
    }
    public function sendMail($mailTo )
    {
        $mailTo = "najyms@gmail.com";
        $app = App::getInstance();
        $app->register('App\Providers\MailConfigServiceProvider');
        $bcc="support@oras.orasweb.com";
    //    Mail::to( $mailTo)->bcc($bcc)->send(new VerifyEmail(  ));
      
/*
        Mail::send(array(),array(), function($message) use ($content,$mailTo)
        {
            $message->to($mailTo)
                    ->subject('Test Dynamic SMTP Config')
                    ->from(Config::get('mail.from.address'),Config::get('mail.from.name'))
                    //->setBody($content);
                    ->html($content);
           
            echo 'Mail Sent Successfully';
        });
        */
    }
    public function getmail()
    {
        $request = request();
        $formdata = $request->all();      
        $storrequest = new GetMailRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
          $code= rand(100000, 999999);
            $clientemail = $formdata['email'];
             $mailmodel=new ClientEmail;
             $mailmodel->email=$clientemail;
             $mailmodel->code= $code;
             $mailmodel->is_confirm= 0;             
             $mailmodel->save();
             //send mail 
             $username="support@oras.orasweb.com";
             $password="[vOxZJbSHfwB";
             $config = array(
              'driver'     => 'smtp',
              'host'       => 'mail.oras.orasweb.com',
              'port'       => '587',
              'from'       => array('address' =>$username, 'name' =>config('app.name', 'Rouh')),
              'encryption' => '',
              'username'   => $username,
              'password'   => $password,
              'sendmail'   => '/usr/sbin/sendmail -bs',
              'pretend'    => false,
              'timeout' => null,
              'local_domain' => env('MAIL_EHLO_DOMAIN'),
              'verify_peer' => false, // <== This is needed here
          );
          Config::set('mail', $config);
           // $app->register('App\Providers\MailConfigServiceProvider'); 
        //   $logo=URL::asset('assets/img/brand/logo-title.svg');
           $strgCtrlr = new StorageController();
           $logo=$strgCtrlr->DefaultPath('icon'); 
           $data=[
              'code'=>$code,                          
            'com_title'=>config('app.name', 'Rouh'),
            'logo'=> $logo,
           ];     
        // // Mail::to( $mailTo)->bcc($bcc)->send(new ContactEmail( $data));
        Mail::to($clientemail)->send(new VerifyEmail($data)); 
            return response()->json("ok");
        }
    }

    public function codevalidate()
    {
        $request = request();
        $formdata = $request->all();      
        $storrequest = new ValidateCodeRequest();//php artisan make:request Api/Expertfavorite/StoreRequest

        $validator = Validator::make(
            $formdata,
            $storrequest->rules(),
            $storrequest->messages()
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {        
            $clientemail = $formdata['email'];
            $code=$formdata['code'];
            $mailmodel=ClientEmail::where('email',$clientemail)
            ->where('code',$code)
            ->where('is_confirm',0)
            ->orderByDesc('created_at')->first();
            if($mailmodel){
            //  $mailmodel->is_confirm=1;
              ClientEmail::where('email',$clientemail)->where('is_confirm',0)->update(
                [
                  'is_confirm'=>1
                ]
              );
            //  $mailmodel->save();
               return response()->json("ok");
            }else{
              return response()->json("notmatch");
            }
         
          }
    }

  //   public function convertfile(Request $request)
  // {
  //   if ($request->hasFile('record')) {
  //    // $name = $request->file('record')->getClientOriginalName();
  //     FFMpeg::open($request->file('record'))
  //       ->export()
  //       ->toDisk('public')
  //       ->save('concat.mp3');
  //   }
  //   $filename = "1.3gpp";
  //   $destfile = "out.mp3";
  //   /*
  //    $sourcepath= storage_path('app/public').'/'.$filename;
  //    $destpath= storage_path('app/public').'/'.  $destfile;
  //    FFMpeg::fromDisk('public')
  //    ->open(['1.3gpp' ])
  //   ->export()  
  //    ->save('concat.mp3');
  //    */
  //   //
  //   return response()->json(['ok']);
  // }
}
