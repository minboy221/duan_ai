<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'so_tien' => 'required|numeric|min:0',
            'ngay_giao_dich' => 'required|date',
            'ghi_chu' => 'nullable|string'
        ]; }

    public function messages(): array {
        return [
            'danh_muc_id.required' => 'Vui lòng chọn danh mục.',
            'danh_muc_id.exists' => 'Danh mục không hợp lệ.',
            'so_tien.required' => 'Vui lòng nhập số tiền.',
            'so_tien.numeric' => 'Số tiền phải là dạng số.',
            'so_tien.min' => 'Số tiền tối thiểu là 0 VNĐ.',
            'ngay_giao_dich.required' => 'Vui lòng chọn ngày giao dịch.'
        ];
    }
}