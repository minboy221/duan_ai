<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'ten_danh_muc' => 'required|string|max:255',
            'loai' => 'required|in:thu,chi',
            'bieu_tuong' => 'required|string|max:50'
        ]; }

    public function messages(): array {
        return [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'loai.required' => 'Vui lòng chọn loại danh mục.',
            'bieu_tuong.required' => 'Vui lòng chọn biểu tượng cho danh mục.'
        ];
    }
}