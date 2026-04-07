<?php

namespace App\Http\Requests\SavingsGoal;

use Illuminate\Foundation\Http\FormRequest;

class StoreSavingsGoalRequest extends FormRequest
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
            'ten_muc_tieu' => 'required|string|max:255',
            'so_tien_muc_tieu' => 'required|numeric|min:1',
            'so_tien_hien_tai' => 'nullable|numeric|min:0',
            'han_chot' => 'required|date|after_or_equal:today'
        ]; }

    public function messages(): array {
        return [
            'ten_muc_tieu.required' => 'Vui lòng nhận tên mục tiêu.',
            'so_tien_muc_tieu.required' => 'Vui lòng nhập số tiền mục tiêu.',
            'han_chot.required' => 'Vui lòng chọn ngày dự kiến hoàn thành.'
        ];
    }
}