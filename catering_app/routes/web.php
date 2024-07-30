<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard',function(){
    return view('home.dashboard');
});

Route::get('/register',[AuthController::class,'regist']);
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/login',[AuthController::class,'pagelogin'])->name('login');
Route::post('/logins',[AuthController::class,'login'])->name('action_login');