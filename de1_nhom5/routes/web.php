<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () { return view('dashboard'); })->name('dashboard');
Route::get('/ngan-sach', function () { return view('ngansach'); })->name('ngansach');
Route::get('/phan-tich-ai', function () { return view('phantichAi'); })->name('phantich-ai');
Route::get('/tro-ly-giao-dich-ai', function () { return view('TroligiaodichAi'); })->name('tro-ly-giao-dich-ai');
Route::get('/huong-dan', function () { return view('huongdan'); })->name('huongdan');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('login'); })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/dang-ky', function () { return view('dangky'); })->name('dangky');
    Route::post('/dang-ky', [AuthController::class, 'register'])->name('dangky.post');
    
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp.post');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->name('forgot-password.post');
    
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
    
    // Đổi mật khẩu qua OTP (Profile)
    Route::post('/profile/password/send-otp', [ProfileController::class, 'sendPasswordOtp'])->name('profile.password.send-otp');
    Route::get('/profile/password/verify', [ProfileController::class, 'showPasswordOtpForm'])->name('profile.password.verify');
    Route::post('/profile/password/verify', [ProfileController::class, 'verifyPasswordOtp'])->name('profile.password.verify.post');
});
