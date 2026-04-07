<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KhoAnToanController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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

    // Transactions
    Route::get('/giao-dich', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/giao-dich/chi-tiep', [TransactionController::class, 'storeExpense'])->name('transactions.expense.store');
    Route::post('/giao-dich/thu-nhap', [TransactionController::class, 'storeIncome'])->name('transactions.income.store');
    Route::get('/giao-dich/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::post('/giao-dich/import', [TransactionController::class, 'import'])->name('transactions.import');

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
    Route::put('/giao-dich-dinh-ky/{id}', [RecurringTransactionController::class, 'update'])->name('recurring.update');
    Route::patch('/giao-dich-dinh-ky/{id}/toggle', [RecurringTransactionController::class, 'toggle'])->name('recurring.toggle');
    Route::delete('/giao-dich-dinh-ky/{id}', [RecurringTransactionController::class, 'destroy'])->name('recurring.destroy');

    // Category Management (DanhMuc)
    Route::get('/danh-muc', [DanhMucController::class, 'index'])->name('danhmuc.index');
    Route::post('/danh-muc', [DanhMucController::class, 'store'])->name('danhmuc.store');
    Route::delete('/danh-muc/{id}', [DanhMucController::class, 'destroy'])->name('danhmuc.destroy');
    
    // Phân Tích AI
    Route::post('/ai/phan-tich', [\App\Http\Controllers\AiAnalysisController::class, 'analyzeHabits'])->name('ai.phan_tich');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
    
    // Đổi mật khẩu qua OTP (Profile)
    Route::post('/profile/password/send-otp', [ProfileController::class, 'sendPasswordOtp'])->name('profile.password.send-otp');
    Route::get('/profile/password/verify', [ProfileController::class, 'showPasswordOtpForm'])->name('profile.password.verify');
    Route::post('/profile/password/verify', [ProfileController::class, 'verifyPasswordOtp'])->name('profile.password.verify.post');

    // Notifications
    Route::get('/thong-bao', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/thong-bao/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/thong-bao/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/thong-bao/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // VNPay Demo
    Route::group(['prefix' => 'vnpay', 'as' => 'vnpay.'], function () {
        Route::get('/', [VNPayController::class, 'index'])->name('index');
        Route::post('/pay', [VNPayController::class, 'createPayment'])->name('pay');
        Route::get('/return', [VNPayController::class, 'vnpayReturn'])->name('return');
        Route::get('/query', [VNPayController::class, 'queryTransaction'])->name('query');
    });

    // Safe Vault (Kho An Toan)
    Route::group(['prefix' => 'kho-an-toan', 'as' => 'kho-an-toan.'], function () {
        Route::get('/auth', [KhoAnToanController::class, 'showAuth'])->name('auth');
        Route::post('/send-otp', [KhoAnToanController::class, 'sendOtp'])->name('send-otp');
        Route::post('/verify', [KhoAnToanController::class, 'verifyOtp'])->name('verify');
        
        Route::middleware(['auth'])->group(function () {
            Route::get('/', [KhoAnToanController::class, 'index'])->name('index');
            Route::post('/transfer', [KhoAnToanController::class, 'transfer'])->name('transfer');
            Route::post('/lock', [KhoAnToanController::class, 'logout'])->name('lock');
        });
    });
});


