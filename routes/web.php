<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LinkAccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SettingController;
use App\Http\Controllers\errorController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

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
Route::get('/verification/{token}',[LinkAccountController::class,'verifyEmail']);
Route::post('/reset-password',[LoginController::class,'showResetPassword'])->name('reset.password');
Route::get('/reset-password/{token}',[LoginController::class,'resetPassword']);
Route::put('/password-reset',[LoginController::class,'passwordReset'])->name('password-reset');


Route::middleware(['auth.custom'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'showCreateTicketForm'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'createTicket'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/responses', [TicketController::class, 'storeResponse'])->name('ticket.responses.store');
});


Route::get('/',[homeController::class,'index'])->name('Home');
