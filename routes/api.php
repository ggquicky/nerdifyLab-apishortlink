<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ClickReportController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('users', [UserController::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function (){
//    Route::post('/links', [LinkController::class, 'store']);
//    Route::get('/links', [LinkController::class, 'show']);
//    Route::patch('/links/{link}', [LinkController::class, 'update']);
    Route::resource('links', LinkController::class);
    Route::get('/click_report', [ClickReportController::class, 'monthlyReport']);

});
