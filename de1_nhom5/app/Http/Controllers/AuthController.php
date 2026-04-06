<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $user = NguoiDung::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->mat_khau)) {
            if (!$user->email_verified_at) {
                $otp = rand(100000, 999999);
                $user->update([
                    'otp' => $otp,
                    'otp_expires_at' => Carbon::now()->addMinutes(5)
                ]);
                Mail::to($user->email)->send(new OtpMail($otp, 'register'));
                return redirect()->route('verify-otp', ['email' => $user->email])
                    ->with('error', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email để lấy mã OTP.');
            }

            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['error' => 'Email hoặc mật khẩu không chính xác.'])->withInput();
    }

    public function register(RegisterRequest $request)
    {

        $otp = rand(100000, 999999);

        $user = NguoiDung::create([
            'ho_ten' => $request->fullname,
            'email' => $request->email,
            'mat_khau' => Hash::make($request->password),
            'tien_te' => 'VND',
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'email_verified_at' => null
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, 'register'));

        return redirect()->route('verify-otp', ['email' => $user->email])
            ->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để lấy mã OTP kích hoạt.');
    }

    public function showVerifyOtp(Request $request)
    {
        if (!$request->email) return redirect()->route('login');
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {

        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user) return back()->with('error', 'Không tìm thấy người dùng.');
        if ($user->otp !== $request->otp) return back()->with('error', 'Mã OTP không chính xác.');
        if (Carbon::now()->greaterThan($user->otp_expires_at)) return back()->with('error', 'Mã OTP đã hết hạn.');

        $user->update([
            'email_verified_at' => Carbon::now(),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Kích hoạt tài khoản thành công!');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(ForgotPasswordRequest $request)
    {
        $user = NguoiDung::where('email', $request->email)->first();
        if (!$user) return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);

        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, 'reset'));

        return redirect()->route('reset-password', ['email' => $user->email])
            ->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    public function showResetPassword(Request $request)
    {
        if (!$request->email) return redirect()->route('forgot-password');
        return view('auth.reset-password', ['email' => $request->email]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $user = NguoiDung::where('email', $request->email)->first();
        
        if (!$user) return back()->with('error', 'Không tìm thấy người dùng.');
        if ($user->otp !== $request->otp) return back()->with('error', 'Mã OTP không chính xác.');
        if (Carbon::now()->greaterThan($user->otp_expires_at)) return back()->with('error', 'Mã OTP đã hết hạn.');

        $user->update([
            'mat_khau' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
