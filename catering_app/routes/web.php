<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BE\BarangControllerBE;
use App\Http\Controllers\FE\AdminControllerFE;
use App\Http\Controllers\FE\BarangControllerFE;
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

Route::middleware(['auth','role:admin'])->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/',[AdminControllerFE::class,'index'])->name('admin');
        Route::get('/barang',[BarangControllerFE::class,'index'])->name('barang_index');
        Route::post('/create',[BarangControllerBE::class,'store'])->name('store.barang');
        Route::get('/getBarang/{id}',[BarangControllerBE::class,'getbarang']);
        Route::patch('/update', [BarangControllerBE::class, 'update'])->name('update.barang');
        Route::delete('/delete/{id}',[BarangControllerBE::class,'destroy'])->name('delete.barang');

    });

});