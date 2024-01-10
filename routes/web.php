<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Web\UserController;
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
    return view('welcome');
});
 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 

 
Route::middleware(['auth', 'verified']) ->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    // user 
    Route::prefix('/user')->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('/add', [UserController::class, 'create']);
    });
       Route::prefix('/expert')->group(function () {
        Route::get('/view', [ExpertController::class, 'index']);
        Route::get('/getloguser', [ClientController::class, 'getloguser']);
    });

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
