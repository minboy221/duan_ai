<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
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
            'so_tien_han_muc' => 'required|numeric|min:1000',
            'thang' => 'required|integer|min:1|max:12',
            'nam' => 'required|integer|min:2000|max:2100',
        ]; }

    public function messages(): array {
        return [
            'danh_muc_id.required' => 'Vui lòng chọn danh mục để lập ngân sách.',
            'danh_muc_id.exists' => 'Danh mục không tồn tại.',
            'so_tien_han_muc.required' => 'Vui lòng nhập số tiền ngân sách.',
            'so_tien_han_muc.min' => 'Hạn mức tối thiểu là 1.000 VNĐ.',
            'thang.required' => 'Vui lòng chọn tháng.',
            'nam.required' => 'Vui lòng chọn năm.'
        ];
    }
}