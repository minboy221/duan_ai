<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPasswordOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array { return [
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|same:confirm-password'
        ]; }

    public function messages(): array {
        return [
            'otp.required' => 'Vui lòng nhập mã bảo mật OTP.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
            'password.same' => 'Mật khẩu xác nhận không khớp.'
        ];
    }
}