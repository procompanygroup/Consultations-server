<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\InputController;
use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\ExpertController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\PointController;
use App\Http\Controllers\Web\ExpertsServiceController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Web\AnswerController;
use App\Http\Controllers\Web\ReasonController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\RateController;
use App\Http\Controllers\Web\ClientOperationController;
use App\Http\Controllers\Web\ExpertOperationController;
use App\Http\Controllers\Web\PointTransferController;
use App\Http\Controllers\Web\GiftController;
use App\Http\Controllers\Web\GiftExpertController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});



//Route::get('/', [AuthenticatedSessionController::class, 'create']);
/*
Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

*/

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');


   
    
    Route::middleware('role.admin:admin')->group(function () {

        // Route::prefix('user')->group(function () {
        //     Route::get('', [UserController::class, 'index'])->name('admin.user.show');
        //     Route::get('/add', [UserController::class, 'create']);
        //     Route::post('/store', [UserController::class, 'store']);
        //     Route::get('/edit/{id}', [UserController::class, 'edit']);
        //     Route::post('/update/{id}', [UserController::class, 'update']);
        //     Route::get('/delete/{id}', [UserController::class, 'destroy']);
        // });
        //notific
        Route::resource('notify', NotificationController::class, ['except' => ['update']]);
        Route::post('saveToken', [NotificationController::class, 'saveToken']);
        Route::post('sendNotification', [NotificationController::class, 'sendNotification']);
        Route::post('sendbytoken', [NotificationController::class, 'sendbytoken']);
        Route::get('testnotify', [NotificationController::class, 'testnotify']);

        Route::resource('user', UserController::class, ['except' => ['update']]);
        Route::prefix('user')->group(function () {
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        });
        Route::resource('point', PointController::class, ['except' => ['update']]);
        Route::prefix('point')->group(function () {
            Route::post('/update/{id}', [PointController::class, 'update'])->name('point.update');
        });
        Route::resource('setting', SettingController::class, ['except' => ['update']]);
        Route::prefix('setting')->group(function () {
            Route::post('/update/{id}', [SettingController::class, 'update'])->name('setting.update');
            Route::post('/updatepercent/{id}', [SettingController::class, 'updatepercent']);
            Route::post('/updatepoints/{id}', [SettingController::class, 'updatepoints']);
            Route::post('/updatesecretkey/{id}', [SettingController::class, 'updatesecretkey']);
            Route::post('/updatepublishablekey/{id}', [SettingController::class, 'updatepublishablekey']);
            Route::post('/updatedays/{id}', [SettingController::class, 'updatedays']);
            
        });
         // المعاملات المالية 
        //الرصيد
        Route::prefix('balance')->group(function () {   
            Route::get('/client', [ClientController::class, 'showbalance']);       
            Route::get('/expert', [ExpertController::class, 'showbalance']);
            Route::get('/client/{id}', [ClientController::class, 'showoperations']); 
            Route::get('/expert/{id}', [ExpertController::class, 'showoperations']);   
            Route::get('/pulls', [PointTransferController::class , 'pulls']); 
            Route::get('/createpull', [PointTransferController::class, 'createpull']);    
            Route::post('/savepull', [PointTransferController::class, 'savepull']);   
            Route::get('/getbyside', [PointTransferController::class, 'getbyside']); 
        
        });
//Gifts
Route::prefix('gift')->group(function () {   
     
    Route::get('/', [GiftController::class , 'index']); 
    Route::get('/create', [GiftController::class, 'create']);    
    Route::post('/store', [GiftController::class, 'store']);   
    Route::get('/fillclients', [GiftController::class, 'fillclients']); 

});
Route::prefix('expertgift')->group(function () {   
     
    Route::get('/', [GiftExpertController::class , 'index']); 
    Route::get('/create', [GiftExpertController::class, 'create']);    
    Route::post('/store', [GiftExpertController::class, 'store']);   
    // Route::get('/fillexperts', [GiftExpertController::class, 'fillclients']); 

});
        Route::resource('expert', ExpertController::class, ['except' => ['update']]);
        Route::get('expertstatus', [ExpertController::class, 'showstatus']);
        Route::prefix('expert')->group(function () {
            Route::post('/update/{id}', [ExpertController::class, 'update'])->name('expert.update');
            Route::post('/delrecord/{id}', [ExpertController::class, 'delrecord'])->name('expert.delrecord');
       
          
        });

        Route::resource('client', ClientController::class, ['except' => ['update']]);
        Route::prefix('client')->group(function () {
            Route::post('/update/{id}', [ClientController::class, 'update'])->name('client.update');
           

           
        });

        Route::resource('service', ServiceController::class, ['except' => ['update']]);
        Route::prefix('service')->group(function () {
            Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
            Route::post('/savepersonal/{id}', [ServiceController::class, 'savepersonal']);
            Route::post('/saveimgrecord/{id}', [ServiceController::class, 'saveimgrecord']);
            Route::post('/savefield/{id}', [ServiceController::class, 'savefield']);
            Route::get('/showinputs/{id}', [ServiceController::class, 'showinputs']);

            //عرض النسب
            Route::get('/percent/show', [ServiceController::class, 'showpercent']);
            //عرض الخبراء لخدمة محددة مع نسبة كل خبير
            Route::get('/expert/percentedit/{id}', [ServiceController::class, 'editpercentexpert']);
            //حفظ النسبة
            Route::post('/percent/save/{id}', [ServiceController::class, 'percentsave']);
            //عرض نسبة الخدمة حسب ال id modal
            Route::get('/percent/edit/{id}', [ServiceController::class, 'percentmodaledit']);

            //عرض الخبراء المقدمين للخدمات
            Route::get('/expert/show', [ServiceController::class, 'showexpert']);
            Route::get('/expert/showselected/{id}', [ServiceController::class, 'showselected']);

            Route::post('/expert/deleteselected/{id}', [ExpertsServiceController::class, 'deleteselected']);
            Route::get('/expert/edit/{id}', [ServiceController::class, 'editexpert'])->name('service.expert.edit');
            // حفظ الخبير
            Route::post('/expert/save/{id}', [ServiceController::class, 'expertsave']);
            // points
            //عرض النقاط في ال modal  حسب ال id
            Route::get('/point/edit/{id}', [ServiceController::class, 'pointedit']);
            //حفظ النقاط
            Route::post('/point/save/{id}', [ServiceController::class, 'pointsave']);
        });
        Route::prefix('input')->group(function () {
            Route::get('/delete/{id}', [InputController::class, 'destroy']);
            Route::get('/edit/{id}', [InputController::class, 'edit']);
            Route::post('/update/{id}', [InputController::class, 'update']);
        });

        Route::resource('reason', ReasonController::class, ['except' => ['update']]);
        Route::prefix('reason')->group(function () {
            Route::post('/update/{id}', [ReasonController::class, 'update'])->name('reason.update');
        });

    });
////////////////////////////////////////////////////////////////////
    Route::middleware('role.admin:admin-super')->group(function () {

        // expert
        // Route::prefix('/expert')->group(function () {
        // Route::get('', [ExpertController::class, 'index'])->name('admin.expert.show');
        //     Route::get('/add', [ExpertController::class, 'create']);
        //     Route::post('/store', [ExpertController::class, 'store']);
        //     Route::get('/edit/{id}', [ExpertController::class, 'edit']);
        //     Route::post('/update/{id}', [ExpertController::class, 'update']);
        //     Route::get('/delete/{id}', [ExpertController::class, 'destroy']);
        // });   
// update profile
Route::prefix('user')->group(function () {
    Route::get('/editprofile/{id}', [UserController::class, 'editprofile'])->name('user.editprofile');
    Route::post('/updateprofile/{id}', [UserController::class, 'updateprofile'])->name('user.updateprofile');
});
        //الطلبات
        Route::resource('order', OrderController::class, ['except' => ['update']]);
        Route::prefix('order')->group(function () {          
            Route::post('/agree/{id}', [OrderController::class, 'agreemethod'])->name('order.agree');
            Route::post('/reject/{id}', [OrderController::class, 'rejectmethod'])->name('order.reject');
        });
        //ردود الخبير
        Route::resource('answer', AnswerController::class, ['except' => ['update']]);
        Route::prefix('answer')->group(function () {          
      
            Route::post('/agree/{id}', [AnswerController::class, 'agreemethod'])->name('answer.agree');
            Route::post('/reject/{id}', [AnswerController::class, 'rejectmethod'])->name('answer.reject');
            Route::get('/getbyid/{id}', [AnswerController::class, 'getbyselectedid']) ;
        });     
        
        Route::resource('comment', CommentController::class, ['except' => ['update']]);
        Route::prefix('comment')->group(function () {
            Route::post('/update/{id}', [CommentController::class, 'update'])->name('comment.update');
            Route::post('/agree/{id}', [CommentController::class, 'agreemethod'])->name('comment.agree');
            Route::post('/reject/{id}', [CommentController::class, 'rejectmethod'])->name('comment.reject');
            Route::post('/rate/{id}', [CommentController::class, 'ratemethod'])->name('comment.rate');
       
        });
        //التعليقات
        Route::resource('rate', RateController::class, ['except' => ['update']]);
        Route::prefix('rate')->group(function () {
            Route::post('/update/{id}', [RateController::class, 'update'])->name('rate.update');
            Route::post('/agree/{id}', [RateController::class, 'agreemethod'])->name('rate.agree');
            Route::post('/reject/{id}', [RateController::class, 'rejectmethod'])->name('rate.reject');
            // Route::post('/rate/{id}', [RateController::class, 'ratemethod'])->name('rate.rate');
       
        });
       
      
    });
    /*
    Route::middleware('role.admin:super')->group(function () {

        // expert
   Route::prefix('/expert')->group(function () {
       Route::get('', [ExpertController::class, 'index'])->name('admin.expert.show');

   });

   });
*/
});
/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/
require __DIR__ . '/auth.php';
