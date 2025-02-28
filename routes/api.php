<?php

use App\Http\Controllers\Web\GiftMinuteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AuthController;
//use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientAuthController;
use App\Http\Controllers\Api\ExpertAuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ExpertController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SelectedServiceController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\PointTransferController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Web\GiftController;
use App\Http\Controllers\Api\CallpointController;
use App\Http\Controllers\Web\MessageController;
 //use App\Http\Middleware\Api\AuthenticateClient;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::post('registerexpert', [ExpertAuthController::class, 'register']);
 
Route::post('loginexpert', [ExpertAuthController::class, 'login']);
Route::post('getmail', [MailController::class, 'getmail']);
Route::post('codevalidate', [MailController::class, 'codevalidate']);
Route::post('registerclient', [ClientAuthController::class, 'register']);
Route::post('loginclient', [ClientAuthController::class, 'login']);
Route::middleware('authExpert:api')->group(function () {
  // مسارات المصادقة للـ Expert
  Route::prefix('/expert')->group(function () {
    Route::post('/view', [ExpertController::class, 'index']);
    Route::post('/getexpert', [ExpertController::class, 'getexpert']);
    Route::post('/deleteaccount', [ExpertController::class, 'deleteaccount']);
    Route::post('/updateprofile', [ExpertController::class, 'updateprofile']);
   // Route::post('/uploadrecord', [ExpertController::class, 'uploadrecord']);
    Route::post('/uploadanswer', [ExpertController::class, 'uploadanswer']);
    Route::post('/getorders', [SelectedServiceController::class, 'getorders']);
    Route::post('/getorderbyid', [SelectedServiceController::class, 'getorderbyid']);
    Route::post('/getwaitanswer', [SelectedServiceController::class, 'getwaitanswer']);
    Route::post('/getwithcomments', [ExpertController::class, 'getexpertwithcomments']); 
    Route::post('/pullbalance', [ExpertController::class, 'pullbalance']);
    Route::post('/savetoken', [ExpertController::class, 'savetoken']);
    // Route::post('/gettype', [ExpertController::class, 'gettype']);
    Route::post('/changeavailable', [ExpertController::class, 'changeavailable']);
    Route::post('/changestatus', [ExpertController::class, 'changestatus']);
    //notify status
    Route::post('/changenotifystate', [ExpertController::class, 'changenotifystate']);
    Route::post('/getnotifystate', [ExpertController::class, 'getnotifystate']);
   // Route::post('/uploadcall', [ExpertController::class, 'uploadcall']);
   // Route::post('/convertfile', [MailController::class, 'convertfile']);

    Route::post('/getstatistics', [ExpertController::class, 'getstatistics']);//
    Route::post('/getwallet', [ExpertController::class, 'getwallet']);
 //   Route::post('/getloguser', [ClientController::class, 'getloguser']);uploadanswer
 Route::post('/getwithfav', [ExpertController::class, 'getexpertwithfav']); 
 Route::post('/savefav', [ExpertController::class, 'saveexpertfav']); 
 //notification
 Route::post('/getnotifylist', [NotificationController::class, 'getexpertnotifylist']);
 Route::post('/settoread', [NotificationController::class, 'settoreadexpert']);
 Route::post('/getnotifybyid', [NotificationController::class, 'getexpertnotifybyid']);
 //messages
 Route::post('/sendmsg', [MessageController::class, 'expertsendmsg']);
 Route::post('/getmsgs', [MessageController::class, 'expertgetmsg']);
 //
 Route::post('/logout', [ExpertAuthController::class, 'logout_expert']);
 Route::prefix('/service')->group(function () {
    Route::post('/viewall', [serviceController::class, 'index']); 
    Route::post('/getinputform', [serviceController::class, 'getinputserviceform']); 
});

Route::post('/getlinks', [SettingController::class, 'getlinks']);
});
});
//Route::get('getloguser', [ClientController::class, 'getloguser']);
Route::middleware('authClient:api_clients')->group(function () {
    // مسارات المصادقة للـ Client
    Route::prefix('/client')->group(function () {
        // Route::post('/view', [ClientController::class, 'index']);
        Route::post('/getloguser', [ClientController::class, 'getloguser']);
        Route::post('/getbymobile', [ClientController::class, 'getbymobile']);
        Route::post('/updateprofile', [ClientController::class, 'updateprofile']);
        Route::post('/deleteaccount', [ClientController::class, 'deleteaccount']);
        Route::post('/addcomment', [SelectedServiceController::class, 'addcomment']);
        Route::post('/addrate', [SelectedServiceController::class, 'addrate']);
        Route::post('/changebalance', [ClientController::class, 'changebalance']);
        Route::post('/buyminutes', [ClientController::class, 'buyminutes']);
         
        Route::post('/savetoken', [ClientController::class, 'savetoken']);
        Route::post('/getbyid', [ClientController::class, 'getbyid']);

        Route::post('/store', [PointTransferController::class, 'store']);
        Route::post('/getnotifylist', [NotificationController::class, 'getclientnotifylist']);
        Route::post('/settoread', [NotificationController::class, 'settoread']);
        Route::post('/getnotifybyid', [NotificationController::class, 'getnotifybyid']);
        Route::post('/getgift', [GiftController::class, 'getgift']);
        Route::post('/getgiftminute', [GiftMinuteController::class, 'getgift']);
        Route::post('/callorder', [SelectedServiceController::class, 'callorder']);
        Route::post('/uploadcall', [ClientController::class, 'uploadcall']);
        Route::post('/sendcallalert', [ClientController::class, 'sendcallalert']);
        //message
        Route::post('/sendmsg', [MessageController::class, 'clientsendmsg']);
        Route::post('/getmsgs', [MessageController::class, 'clientgetmsg']);
        //
        Route::post('/logout', [ClientAuthController::class, 'logout_client']);
        //notify
        Route::post('/changeavailable', [ClientController::class, 'changeavailable']);
        Route::post('/changestatus', [ClientController::class, 'changestatus']);
//notify
        Route::post('/changenotifystate', [ClientController::class, 'changenotifystate']);
        Route::post('/getnotifystate', [ClientController::class, 'getnotifystate']);
//api/client/service
        Route::prefix('/service')->group(function () {
            Route::post('/viewall', [serviceController::class, 'index']); 
            Route::post('/getinputform', [serviceController::class, 'getinputserviceform']); 
            Route::post('/savewithvalues', [SelectedServiceController::class, 'savewithvalues']);
            Route::post('/uploadfilesvalue', [SelectedServiceController::class, 'uploadfilesvalue']); 
            Route::post('/callexperts', [ExpertController::class, 'getcallexperts']);       
         //   Route::post('/diftime', [serviceController::class, 'diftime']);   
        });
        Route::prefix('/expert')->group(function () {
            Route::post('/getexpertsbyserviceid', [ExpertController::class, 'getexpertsbyserviceid']); 
            Route::post('/getwithfav', [ExpertController::class, 'getwithfav']); 
            Route::post('/savefav', [ExpertController::class, 'savefav']); 
            Route::post('/getwithcomments', [ExpertController::class, 'getwithcomments']); 
            Route::post('/getavailable', [ExpertController::class, 'getavailable']); 
            Route::post('/getorderwithanswer', [SelectedServiceController::class, 'getorderwithanswer']); 
            Route::post('/changenotifyme', [ExpertController::class, 'changenotifyme']); 
            Route::post('/getnotifyme', [ExpertController::class, 'getnotifyme']); 
        });
        Route::prefix('/point')->group(function () {
            Route::post('/getall', [PointController::class, 'index']); 
      
        });
        Route::prefix('/minute')->group(function () {
            Route::post('/getall', [CallpointController::class, 'index']); 
      
        });
        Route::prefix('/setting')->group(function () {
            Route::post('/getkeys', [SettingController::class, 'getkeys']); 
      
        });
        Route::post('/getlinks', [SettingController::class, 'getlinks']);
    });

});

/*
Route::middleware(['auth:api' ])->group(function () {

Route::prefix('/users')->group(function () {
    Route::get('/view', [UserController::class, 'index']);
    Route::get('/getLoginUser', [UserController::class, 'getLoginUser']); 
   
});

});
*/

/*
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
// Broadcast::routes([
//     'middleware' => [
//         'authExpert:api',
//         'authClient:api_clients'

//     ]
// ]);