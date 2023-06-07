<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompleteProfile;
use App\Http\Controllers\Api\LaborApiController;
use App\Http\Controllers\Api\DashboardApi;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\LaborHiringController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\paymentProofController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\PaymentApproval;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::controller(AuthController::class)->group(function(){
//     Route::post('login','login');
//     Route::post('register','register');
// });
    // Route::post('login1',function(){
    //     return 'asd';
    // });

    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::post('test',[AuthController::class,'test']);
    
    ////COMPLETE PROFILE
    Route::post('fandlname/{id}',[CompleteProfile::class,'fandlname']);
    Route::post('gsmandid/{id}',[CompleteProfile::class,'gsmandid']);
    // Route::post('dobandaddress/{id}',[CompleteProfile::class,'dobandaddress']);
    Route::post('docs/{id}',[CompleteProfile::class,'docs'])->name('docs');
    Route::post('docs_required/{id}', [CompleteProfile::class, 'docsRequired']);
    Route::post('onlysponsorid/{id}',[CompleteProfile::class,'onlysponsorid']);


    Route::post('laborone/{id?}',[LaborApiController::class,'laborone']);
    Route::post('labortwo/{id}',[LaborApiController::class,'labortwo']);
    Route::post('laborthree/{id}',[LaborApiController::class,'laborthree']);
    Route::post('laborfour/{id}',[LaborApiController::class,'laborfour']);

    ////LABORS SEARCH
    Route::post('searchlabor',[LaborApiController::class,'search']);
    Route::get('services',[LaborApiController::class,'services']);

     ////USER API CONTROLLER
     Route::post('userapicontroller', [UserApiController::class, 'index']);

    ////MINMAX
    Route::get('minmax',[LaborApiController::class,'minmax']);

   ///DASHBOARD
    Route::get('dashboard',[DashboardApi::class,'index']);

    //LABOR HIRING
    Route::post('laborhiring',[LaborHiringController::class,'index']);

    //NOTIFICATION
    Route::get('notification',[NotificationController::class,'index']);
    Route::post('notificationstatus',[NotificationController::class,'update_notification_status']);
    Route::get('clearnotification',[NotificationController::class,'clearnotification']);
    Route::post('deletenotification',[NotificationController::class,'deletenotification']);
    
    //REQUESTS
    Route::get('recievedrequest',[NotificationController::class,'recievedrequest']);
    Route::get('sentrequest',[NotificationController::class,'sentrequest']);
    Route::post('updaterequest',[NotificationController::class,'updaterequest']);
    Route::get('unreadnotification',[NotificationController::class,'unreadNotification']);

    Route::get('laborUserDetail',[NotificationController::class,'labor_user_detail']);

    //MIN SALARY
    Route::get('min_salary',[SettingController::class,'minSalary']);

    //PAYMENT DOCUMENT APPROVAL
    Route::post('paymentproof',[paymentProofController::class,'index']);

     //INVOICE DETAILS 
    //  Route::post('paymentproof',[paymentProofController::class,'index']);


  


});




