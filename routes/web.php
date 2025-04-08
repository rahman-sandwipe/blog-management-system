<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticlesController;
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
    
        // Articles Routes
        Route::get('/articles',                 [ArticlesController::class, 'articlesPage'])->name('articlesPage');
        Route::get('/create-article',           [ArticlesController::class, 'articleSavePage'])->name('articleSavePage');
        Route::post('/create-article',          [ArticlesController::class, 'articleCreate'])->name('articleCreate');
        Route::post('/update-article',          [ArticlesController::class, 'articleUpdate'])->name('articleUpdate');
        Route::get('/list-article',             [ArticlesController::class, 'articleList'])->name('articleList');
        Route::post('/article-by-id',           [ArticlesController::class, 'articleById'])->name('articleById');
        Route::get('/delete-article/{id}',      [ArticlesController::class, 'articleDelete'])->name('articleDelete');
        
        // Tags Routes
        Route::post('/create-tag',              [TagController::class, 'CreateTag'])->name('tag.create');
        Route::get('/list-tag',                 [TagController::class, 'TagList'])->name('tag.list');
        Route::post('/tag-by-id',               [TagController::class, 'TagById']);
        Route::post('/update-tag',              [TagController::class, 'TagUpdate'])->name('tag.update');
        Route::get('/delete-tag/{id}',          [TagController::class, 'TagDelete'])->name('tag.delete');
        Route::get('/TagPage',                  [TagController::class, 'TagPage'])->name('TagPage');
        Route::get('/TagSavePage',              [TagController::class, 'TagSavePage'])->name('TagSavePage');
    });
?>
