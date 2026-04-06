<?php

namespace App\Http\Requests\SavingsGoal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSavingsGoalRequest extends FormRequest
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
            'so_tien_them' => 'required|numeric|min:0'
        ]; }

    public function messages(): array {
        return [
            'so_tien_them.required' => 'Vui lòng nhập số tiền tích lũy thêm.',
            'so_tien_them.min' => 'Số tiền không hợp lệ.'
        ];
    }
}