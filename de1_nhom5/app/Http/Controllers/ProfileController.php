<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\VerifyPasswordOtpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\OtpMail;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the profile edit view.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {

        $user = Auth::user();
        
        $dataToUpdate = [
            'ho_ten' => $request->ho_ten,
        ];

        if ($request->hasFile('anh_dai_dien')) {
            // Delete old avatar if exists
            if ($user->anh_dai_dien) {
                Storage::disk('public')->delete($user->anh_dai_dien);
            }
            $customName = 'avatar_' . $user->id . '_' . time() . '.' . $request->file('anh_dai_dien')->getClientOriginalExtension();
            $path = $request->file('anh_dai_dien')->storeAs('avatars', $customName, 'public');
            $dataToUpdate['anh_dai_dien'] = $path;
        }

        $user->update($dataToUpdate);

        return redirect()->route('profile.edit')->with('success', 'Hồ sơ đã được cập nhật thành công.');
    }

    /**
     * Cập nhật Avatar qua giao diện Crop (JS).
     */
    public function updateAvatar(Request $request)
    {
        if ($request->anh_dai_dien_base64) {
            $user = Auth::user();
            $image_parts = explode(";base64,", $request->anh_dai_dien_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = isset($image_type_aux[1]) ? $image_type_aux[1] : 'png';
            $image_base64 = base64_decode($image_parts[1]);
            
            // Delete old avatar if exists
            if ($user->anh_dai_dien) {
                Storage::disk('public')->delete($user->anh_dai_dien);
            }

            $customName = 'avatar_' . $user->id . '_' . time() . '.' . $image_type;
            $path = 'avatars/' . $customName;
            
            Storage::disk('public')->put($path, $image_base64);
            
            $user->update(['anh_dai_dien' => $path]);
            
            return back()->with('success', 'Ảnh đại diện đã được cập nhật thành công.');
        }

        return back()->with('error', 'Không tìm thấy dữ liệu ảnh.');
    }

    /**
     * Send OTP for password change over email.
     */
    public function sendPasswordOtp(Request $request)
    {
        $user = Auth::user();

        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, 'reset'));

        return redirect()->route('profile.password.verify')->with('success', 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra email để tiếp tục.');
    }

    /**
     * Show the form to verify OTP and enter new password.
     */
    public function showPasswordOtpForm()
    {
        return view('profile-password-otp');
    }

    /**
     * Verify OTP and change password.
     */
    public function verifyPasswordOtp(VerifyPasswordOtpRequest $request)
    {

        $user = Auth::user();
        
        if ($user->otp !== $request->otp) {
            return back()->with('error', 'Mã OTP không chính xác.');
        }
        
        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Mã OTP đã hết hạn.');
        }

        $user->update([
            'mat_khau' => Hash::make($request->password),
            'password_changed_at' => Carbon::now(),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return redirect()->route('profile.edit')->with('success', 'Đổi mật khẩu thành công!');
    }
}
