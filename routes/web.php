<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerifiacationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AgeCheck;
use App\Mail\AdminWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\User;
use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Support\Facades\Route;

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

Route::prefix("cms/admin")->middleware(['auth:admin' , 'verified'])->group(function(){
    Route::view('/', 'cms.starter')->name('home');
    // Route::view('/users', 'cms.users.index')->name("users.index");
    // Route::get("/users" , [UserController::class , 'index'])->name("users.index");
    // Route::get("/users/create" , [UserController::class , 'create'])->name("users.create");
    // Route::post('/users' , [UserController::class , 'store'])->name("users.store");

    // Route::get('users/{id}/edit', [UserController::class , 'edit'])->name("users.edit");
    // Route::put('users/{id}', [UserController::class , 'update'])->name("users.update");

    // Route::delete('users/{id}',[UserController::class , 'destroy'])->name("users.destroy");

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
});

Route::prefix("cms/admin")->middleware('guest:admin')->group(function(){
    Route::get('login' , [AuthController::class , 'showLogin'])->name('cms.login');
    Route::post('login' , [AuthController::class , 'login']);

    // password reset
    Route::get('forgot-password' , [AuthController::class , 'forgotPassword'])->name('password.request');
    Route::post('forgot-password' , [AuthController::class , 'sendResetEmail'])->name('password.email');

});

Route::prefix("email")->middleware('auth:admin')->group(function(){
    Route::get('logout' , [AuthController::class , 'logout'])->name('cms.logout');
    Route::get('verify' , [EmailVerifiacationController::class , 'notice'])->name('verification.notice');
    Route::get('verification-notification' , [EmailVerifiacationController::class , 'send'])->middleware('throttle:5,1')->name('verification.send');
    Route::get('verify/{id}/{hash}' , [EmailVerifiacationController::class , 'verify'])->name('verification.verify');
});




Route::get('email' , function(){
    // return new AdminWelcomeEmail();

    $user = User::first();
    return new UserWelcomeEmail( $user);
});


// Route::middleware('age_middl:15,23,24')->get('news' , function(){
//     echo 'show news';
// });
