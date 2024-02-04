<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\InputController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Web\ExpertController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\PointController;

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
    return redirect()-> route('login');
});
 


//Route::get('/', [AuthenticatedSessionController::class, 'create']);
 /*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

*/

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::middleware('role.admin:admin') ->group(function () {

        // Route::prefix('user')->group(function () {
        //     Route::get('', [UserController::class, 'index'])->name('admin.user.show');
        //     Route::get('/add', [UserController::class, 'create']);
        //     Route::post('/store', [UserController::class, 'store']);
        //     Route::get('/edit/{id}', [UserController::class, 'edit']);
        //     Route::post('/update/{id}', [UserController::class, 'update']);
        //     Route::get('/delete/{id}', [UserController::class, 'destroy']);
        // });

        Route::resource('user', UserController::class, ['except' => ['update']]);
        Route::prefix('user')->group(function () {
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        });
        Route::resource('point', PointController::class, ['except' => ['update']]);
        Route::prefix('point')->group(function () {
            Route::post('/update/{id}', [PointController::class, 'update'])->name('point.update');
        });
            });

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
        Route::resource('expert', ExpertController::class, ['except' => ['update']]);
        Route::prefix('expert')->group(function () {
            Route::post('/update/{id}', [ExpertController::class, 'update'])->name('expert.update');
        });
      
        
        Route::resource('service', ServiceController::class, ['except' => ['update']]);
        Route::prefix('service')->group(function () {
            Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
            Route::post('/savepersonal/{id}', [ServiceController::class, 'savepersonal']);
            Route::post('/saveimgrecord/{id}', [ServiceController::class, 'saveimgrecord']);
            Route::post('/savefield/{id}', [ServiceController::class, 'savefield']);
            Route::get('/showinputs/{id}', [ServiceController::class, 'showinputs']);
        });
        Route::prefix('input')->group(function () {
            Route::get('/delete/{id}', [InputController::class, 'destroy']);
            Route::get('/edit/{id}', [InputController::class, 'edit']);
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
require __DIR__.'/auth.php';
