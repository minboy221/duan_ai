<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/phan-tich-ai', function () { return view('phantichAi'); })->name('phantich-ai');
Route::get('/tro-ly-giao-dich-ai', function () { return view('TroligiaodichAi'); })->name('tro-ly-giao-dich-ai');

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

    // Transactions
    Route::get('/giao-dich', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/giao-dich/chi-tiep', [TransactionController::class, 'storeExpense'])->name('transactions.expense.store');
    Route::post('/giao-dich/thu-nhap', [TransactionController::class, 'storeIncome'])->name('transactions.income.store');

    // Budget
    Route::get('/ngan-sach', [BudgetController::class, 'index'])->name('ngansach');
    Route::post('/ngan-sach', [BudgetController::class, 'store'])->name('budget.store');
    Route::delete('/ngan-sach/{id}', [BudgetController::class, 'destroy'])->name('budget.destroy');

    // Savings Goals
    Route::get('/tiet-kiem', [SavingsGoalController::class, 'index'])->name('savings.index');
    Route::post('/tiet-kiem', [SavingsGoalController::class, 'store'])->name('savings.store');
    Route::patch('/savings/{id}/add', [SavingsGoalController::class, 'update'])->name('savings.update');
    Route::delete('/tiet-kiem/{id}', [SavingsGoalController::class, 'destroy'])->name('savings.destroy');

    // Recurring Transactions
    Route::get('/giao-dich-dinh-ky', [RecurringTransactionController::class, 'index'])->name('recurring.index');
    Route::post('/giao-dich-dinh-ky', [RecurringTransactionController::class, 'store'])->name('recurring.store');
    Route::patch('/giao-dich-dinh-ky/{id}/toggle', [RecurringTransactionController::class, 'toggle'])->name('recurring.toggle');
    Route::delete('/giao-dich-dinh-ky/{id}', [RecurringTransactionController::class, 'destroy'])->name('recurring.destroy');

    // Category Management (DanhMuc)
    Route::get('/danh-muc', [DanhMucController::class, 'index'])->name('danhmuc.index');
    Route::post('/danh-muc', [DanhMucController::class, 'store'])->name('danhmuc.store');
    Route::delete('/danh-muc/{id}', [DanhMucController::class, 'destroy'])->name('danhmuc.destroy');
});

