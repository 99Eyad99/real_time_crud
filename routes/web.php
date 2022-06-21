<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\userController;
use App\Http\Controllers\viewController;
use App\Http\Controllers\postController;
use App\Http\Controllers\accountController;
use App\Http\Controllers\caledarController;



$userAuth = 'App\Http\Middleware\userAuth';
$disable_back_btn = 'App\Http\Middleware\disable_back_btn';


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login'); 
});

Route::post('/',[userController::class,'login']);


Route::group(['middleware' => $disable_back_btn], function (){
    Route::group(['middleware' => 'App\Http\Middleware\userAuth'], function () {

        Route::get('app',function(){
            return view('app');
        });


         // ---------------- view controllers ------------------
         Route::get('profile',[viewController::class,'viewProfile']);

         Route::get('dashboard',[viewController::class,'viewDashboard']);

         Route::get('accounts',[viewController::class,'viewAccounts']);

         Route::get('calendar',[viewController::class,'viewCalendar']);

         Route::get('add-post',[viewController::class,'viewAddpost']);

         // ---------------- end view controller ---------------------

         // ----------------- post controller -------------------------
         Route::get('getPosts',[postController::class,'getPosts']);

         Route::post('addPost',[postController::class,'addPost']);
         Route::post('updatePost',[postController::class,'updatePost']);

         Route::get('deletePost',[postController::class,'deletePost']);

         // ----------------- end post controller -------------------------

         // ----------------- start accounts controler ----------------------
          
         Route::get('getAccounts',[accountController::class,'getAccounts']);
         Route::get('deleteAccount',[accountController::class,'deleteAccount']);

         Route::post('addAccount',[accountController::class,'addAccount']);
         Route::post('updateAccount',[accountController::class,'updateAccount']);

        // ----------------- end accounts controler ----------------------

        // --------------------- start Calender controller ---------------
        
        Route::get('getCalendar',[caledarController::class,'getCalendar']);
        Route::get('deleteCalendar',[caledarController::class,'deleteCalendar']);

        Route::post('postCalendar',[caledarController::class,'postCalendar']);



        

        // --------------------- end Calender controller ---------------







         

         

         // --------------------------------------------------

        Route::get('logout',[userController::class,'logout']);

        Route::get('main', function () {
            return view('main'); 
        });
       

        Route::post('userUpdate', [userController::class,'UserUpdate']);

        


   /* Route::get('/', function () {
        return view('dashboard'); 
    });
    */

});

});
