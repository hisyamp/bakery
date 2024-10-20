<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Logitem\LogitemController;

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
// [App\Http\Controllers\HomeController::class, 'index']
Route::get('/', [App\Http\Controllers\Auth\LoginController::class,'formlogin'])->name('login');
Route::post('/postlogin', [App\Http\Controllers\Auth\LoginController::class,'postLogin']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class,'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class,'verify'])->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class,'resend'])->name('verification.resend');
Route::post('/regis', [App\Http\Controllers\Auth\RegisterController::class,'regis'])->name('register');

Route::group(['middleware' => 'auth'], function(){
    Route::get('dashboard_admin', [App\Http\Controllers\Admin\AdminController::class,'dashboard_admin']);
    Route::get('list_user', [App\Http\Controllers\Admin\AdminController::class,'list_user']);
    Route::get('api_user', [App\Http\Controllers\Admin\AdminController::class,'api_user']);
    Route::get('reset_password/{id}', [App\Http\Controllers\Admin\AdminController::class,'reset_password']);
    Route::get('aktivasi/{id}', [App\Http\Controllers\Admin\AdminController::class,'aktivasi']);
    Route::get('api_logitem', [App\Http\Controllers\Admin\AdminController::class,'api_logitem']);
    Route::get('list_logitem', [App\Http\Controllers\Admin\AdminController::class,'list_logitem'])->name('list_logitem');;
    Route::get('detailitem/{id}', [App\Http\Controllers\Admin\AdminController::class,'detailitem']);
    Route::post('actionitem/{id}/{status}', [App\Http\Controllers\Admin\AdminController::class,'actionitem']);
    Route::get('api_dashboard', [App\Http\Controllers\Admin\AdminController::class,'api_dashboard']);
    Route::get('ceklaporan', [App\Http\Controllers\Admin\AdminController::class,'ceklaporan'])->name('ceklaporan');
    Route::get('export_laporan', [App\Http\Controllers\Admin\AdminController::class,'export_laporan'])->name('export_laporan');
    Route::post('signature', [App\Http\Controllers\Admin\AdminController::class,'signature'])->name('signature');
    //customer
    Route::get('list_pengajuan', [App\Http\Controllers\Customer\CustomerController::class,'list_pengajuan']);
    Route::get('api_logpengajuan', [App\Http\Controllers\Customer\CustomerController::class,'api_logpengajuan']);
    Route::get('form_pengembalian', [App\Http\Controllers\Customer\CustomerController::class,'form_pengembalian']);
    Route::post('pengembalian', [App\Http\Controllers\Customer\CustomerController::class,'pengembalian']);


    Route::resource('item', ItemController::class);
    Route::get('api_item', [App\Http\Controllers\Item\ItemController::class,'api_item']);

    Route::resource('logitem', LogitemController::class);
    Route::get('api_log', [App\Http\Controllers\Logitem\LogitemController::class,'api_log']);
    
});