<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionAuthenticate;
use App\Http\Controllers\DashboardController;


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    | Here is where you can register web routes for your application.
    | These routes are loaded by the RouteServiceProvider within a group
    | which is assigned the "web" middleware group. Now create something great!
    |
    */
    Route::get('/', [HomeController::class, 'homePage'])->name('homePage');


    Route::get('/register', [UserController::class, 'registerPage'])->name('registerPage');
    Route::post('/register', [UserController::class, 'userRegister']);
    Route::get('/login', [UserController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [UserController::class, 'userLogin']);
    
    Route::get('/forgot-password', [UserController::class, 'forgotPasswordPage'])->name('forgotPasswordPage');
    Route::post('forget-password', [UserController::class, 'forgetPassword'])->name('forgetPassword');
    Route::get('/verify-otp', [UserController::class, 'verifyOTPPage'])->name('verifyOTPPage');
    Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verifyOTP');

    
    Route::middleware(SessionAuthenticate::class)->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('logout', [UserController::class, 'userLogout'])->name('userLogout');
        // Reset Password
        Route::get('/reset-password', [UserController::class, 'resetPasswordPage'])->name('resetPasswordPage');
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
    });
?>
