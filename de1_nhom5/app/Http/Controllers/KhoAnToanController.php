<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KhoAnToanController extends Controller
{
    public function showAuth()
    {
        if (session('vault_authorized')) {
            return redirect()->route('kho-an-toan.index');
        }
        return view('kho-an-toan.auth');
    }

    public function sendOtp()
    {
        $user = Auth::user();
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, 'vault'));

        return back()->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'Mã OTP phải có 6 chữ số.'
        ]);

        $user = Auth::user();

        if ($user->otp !== $request->otp) {
            return back()->with('error', 'Mã OTP không chính xác.');
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Mã OTP đã hết hạn.');
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        session(['vault_authorized' => true]);

        return redirect()->route('kho-an-toan.index')->with('success', 'Xác thực thành công!');
    }

    public function index()
    {
        if (!session('vault_authorized')) {
            return redirect()->route('kho-an-toan.auth');
        }

        $user = Auth::user();
        
        // Calculate main balance (Income - Expense)
        $totalIncome = KhoanThu::where('nguoi_dung_id', $user->id)->sum('so_tien');
        $totalExpense = GiaoDich::where('nguoi_dung_id', $user->id)->sum('so_tien');
        $availableBalance = $totalIncome - $totalExpense;

        return view('kho-an-toan.index', compact('user', 'availableBalance'));
    }

    public function transfer(Request $request)
    {
        if (!session('vault_authorized')) {
            return response()->json(['error' => 'Chưa xác thực'], 403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'type' => 'required|in:to_safe,from_safe'
        ], [
            'amount.required' => 'Vui lòng nhập số tiền.',
            'amount.min' => 'Số tiền tối thiểu là 1,000 VND.',
            'type.required' => 'Vui lòng chọn loại giao dịch.'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        return DB::transaction(function () use ($user, $amount, $request) {
            if ($request->type === 'to_safe') {
                // To Safe: Decrease Main, Increase Safe
                $totalIncome = KhoanThu::where('nguoi_dung_id', $user->id)->sum('so_tien');
                $totalExpense = GiaoDich::where('nguoi_dung_id', $user->id)->sum('so_tien');
                $availableBalance = $totalIncome - $totalExpense;

                if ($availableBalance < $amount) {
                    return back()->with('error', 'Số dư tài khoản chính không đủ.');
                }

                // Record as Expense to reduce main balance
                GiaoDich::create([
                    'nguoi_dung_id' => $user->id,
                    'so_tien' => $amount,
                    'ghi_chu' => 'Chuyển tiền vào Kho an toàn',
                    'ngay_giao_dich' => Carbon::now(),
                    'danh_muc_id' => 1, // Will create/assign a special category later or use 1 for now
                ]);

                $user->increment('so_du_kho_an_toan', $amount);
                return back()->with('success', 'Đã chuyển tiền vào Kho an toàn thành công!');

            } else {
                // From Safe: Decrease Safe, Increase Main
                if ($user->so_du_kho_an_toan < $amount) {
                    return back()->with('error', 'Số dư Kho an toàn không đủ.');
                }

                // Record as Income to increase main balance
                KhoanThu::create([
                    'nguoi_dung_id' => $user->id,
                    'so_tien' => $amount,
                    'nguon_thu' => 'Rút tiền từ Kho an toàn',
                    'ngay_nhan' => Carbon::now(),
                    'danh_muc_id' => 1,
                ]);

                $user->decrement('so_du_kho_an_toan', $amount);
                return back()->with('success', 'Đã rút tiền từ Kho an toàn thành công!');
            }
        });
    }

    public function logout()
    {
        session()->forget('vault_authorized');
        return redirect()->route('dashboard')->with('success', 'Đã khóa Kho an toàn.');
    }
}
