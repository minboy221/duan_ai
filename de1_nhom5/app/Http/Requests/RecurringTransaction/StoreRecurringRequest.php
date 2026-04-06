<?php

namespace App\Http\Requests\RecurringTransaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecurringRequest extends FormRequest
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
            'loai_giao_dich' => 'required|in:thu,chi',
            'so_tien' => 'required|numeric|min:1',
            'chu_ky' => 'required|in:hang_ngay,hang_tuan,hang_thang,hang_nam',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'nullable|date|after:ngay_bat_dau'
        ]; }

    public function messages(): array {
        return [
            'danh_muc_id.required' => 'Vui lòng chọn danh mục.',
            'loai_giao_dich.required' => 'Vui lòng chọn loại tài chính.',
            'so_tien.required' => 'Vui lòng nhập số tiền hợp lệ.',
            'chu_ky.required' => 'Vui lòng chọn chu kỳ.',
            'ngay_bat_dau.required' => 'Vui lòng ngày bắt đầu chu kỳ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.'
        ];
    }
}