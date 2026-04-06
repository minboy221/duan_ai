<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ]; }

    public function messages(): array {
        return [
            'email.required' => 'Thiếu thông tin email.',
            'otp.required' => 'Vui lòng nhập mã xác nhận.',
            'otp.digits' => 'Mã xác nhận bao gồm 6 chữ số.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải từ 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.'
        ];
    }
}