<?php

use App\Http\Controllers\Auth\LinkAccountController;
use App\Http\Controllers\errorController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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





Route::get("/home",[homeController::class, 'Home'])->name('Home');
Route::get('/token/{token}', [LinkAccountController::class, 'showLinkForm'])->name('account.link');
Route::post('/token/{token}', [LinkAccountController::class, 'linkAccount']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect(\route('Home'));
})->name('logout');
Route::get('/setting',[SettingController::class,'index'])->name('setting');
Route::put('/setting', [SettingController::class,'update'])->name('settings.update');
Route::get('/error',[errorController::class,'error'])->name('error');
Route::get('/verify-email/{token}', 'VerifyEmailController@verify')->name('verify.email');