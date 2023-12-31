<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AuthController;
//use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientAuthController;
use App\Http\Controllers\Api\ExpertAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpertController;
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
Route::post('registerexpert', [ExpertAuthController::class, 'register']);
Route::post('loginexpert', [ExpertAuthController::class, 'login']);
 
Route::post('registerclient', [ClientAuthController::class, 'register']);
Route::post('loginclient', [ClientAuthController::class, 'login']);
Route::middleware('authExpert:api')->group(function () {
  // مسارات المصادقة للـ Expert
  Route::prefix('/expert')->group(function () {
    Route::get('/view', [ExpertController::class, 'index']);
    Route::get('/getloguser', [ClientController::class, 'getloguser']);
});



});
Route::get('getloguser', [ClientController::class, 'getloguser']);
Route::middleware('authClient:api_clients')->group(function () {
    // مسارات المصادقة للـ Client
    Route::prefix('/client')->group(function () {
        Route::get('/view', [ClientController::class, 'index']);
        Route::get('/getloguser', [ClientController::class, 'getloguser']);
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