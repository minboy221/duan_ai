<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'ho_ten' => 'required|string|max:255',
            'tien_te' => 'nullable|string',
            'ngon_ngu' => 'nullable|string',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]; }

    public function messages(): array {
        return [
            'ho_ten.required' => 'Vui lòng nhập họ và tên hiển thị.',
            'anh_dai_dien.image' => 'File tải lên phải là hình ảnh.',
            'anh_dai_dien.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ];
    }
}