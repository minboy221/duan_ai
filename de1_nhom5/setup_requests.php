<?php

$dir = __DIR__ . '/app/Http/Requests';

$requests = [
    'Auth/RegisterRequest' => [
        'rules' => "return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:nguoi_dung,email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted'
        ];",
        'messages' => "return [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng.'
        ];"
    ],
    'Auth/LoginRequest' => [
        'rules' => "return [
            'email' => 'required|email',
            'password' => 'required'
        ];",
        'messages' => "return [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ];"
    ],
    'Auth/VerifyOtpRequest' => [
        'rules' => "return [
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6'
        ];",
        'messages' => "return [
            'email.required' => 'Thiếu thông tin email.',
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'Mã OTP bao gồm 6 chữ số.'
        ];"
    ],
    'Auth/ForgotPasswordRequest' => [
        'rules' => "return [
            'email' => 'required|email'
        ];",
        'messages' => "return [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.'
        ];"
    ],
    'Auth/ResetPasswordRequest' => [
        'rules' => "return [
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ];",
        'messages' => "return [
            'email.required' => 'Thiếu thông tin email.',
            'otp.required' => 'Vui lòng nhập mã xác nhận.',
            'otp.digits' => 'Mã xác nhận bao gồm 6 chữ số.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải từ 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.'
        ];"
    ],
    'Transaction/StoreExpenseRequest' => [
        'rules' => "return [
            'so_tien' => 'required|numeric|min:1000',
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'nguon_tien' => 'required|string',
            'date' => 'required|date',
            'ghi_chu' => 'nullable|string'
        ];",
        'messages' => "return [
            'so_tien.required' => 'Vui lòng nhập số tiền.',
            'so_tien.numeric' => 'Số tiền phải là dạng số.',
            'so_tien.min' => 'Số tiền tối thiểu là 1.000 VNĐ.',
            'danh_muc_id.required' => 'Vui lòng chọn danh mục.',
            'danh_muc_id.exists' => 'Danh mục không hợp lệ.',
            'nguon_tien.required' => 'Vui lòng chọn nguồn tiền chi.',
            'date.required' => 'Vui lòng chọn ngày giao dịch.'
        ];"
    ],
    'Transaction/StoreIncomeRequest' => [
        'rules' => "return [
            'so_tien' => 'required|numeric|min:1000',
            'nguon_thu' => 'required|string',
            'date' => 'required|date',
            'ghi_chu' => 'nullable|string'
        ];",
        'messages' => "return [
            'so_tien.required' => 'Vui lòng nhập số tiền.',
            'so_tien.min' => 'Số tiền tối thiểu là 1.000 VNĐ.',
            'nguon_thu.required' => 'Vui lòng nhập nguồn thu.',
            'date.required' => 'Vui lòng chọn ngày nhận.'
        ];"
    ],
    'Budget/StoreBudgetRequest' => [
        'rules' => "return [
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'so_tien' => 'required|numeric|min:1000'
        ];",
        'messages' => "return [
            'danh_muc_id.required' => 'Vui lòng chọn danh mục để lập ngân sách.',
            'danh_muc_id.exists' => 'Danh mục không tồn tại.',
            'so_tien.required' => 'Vui lòng nhập số tiền ngân sách.',
            'so_tien.min' => 'Hạn mức tối thiểu là 1.000 VNĐ.'
        ];"
    ],
    'SavingsGoal/StoreSavingsGoalRequest' => [
        'rules' => "return [
            'ten_muc_tieu' => 'required|string|max:255',
            'muc_tieu' => 'required|numeric|min:1000',
            'ngay_du_kien' => 'required|date|after_or_equal:today'
        ];",
        'messages' => "return [
            'ten_muc_tieu.required' => 'Vui lòng tên mục tiêu.',
            'muc_tieu.required' => 'Vui lòng nhập số tiền mục tiêu.',
            'ngay_du_kien.required' => 'Vui lòng chọn ngày dự kiến hoàn thành.',
            'ngay_du_kien.after_or_equal' => 'Ngày dự kiến không thể nằm trong quá khứ.'
        ];"
    ],
    'SavingsGoal/UpdateSavingsGoalRequest' => [
        'rules' => "return [
            'so_tien' => 'required|numeric|min:1000'
        ];",
        'messages' => "return [
            'so_tien.required' => 'Vui lòng nhập số tiền tích lũy thêm.',
            'so_tien.min' => 'Số tiền tích lũy tối thiểu là 1.000 VNĐ.'
        ];"
    ],
    'RecurringTransaction/StoreRecurringRequest' => [
        'rules' => "return [
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'so_tien' => 'required|numeric|min:1000',
            'loai_giao_dich' => 'required|in:thu,chi',
            'chu_ky' => 'required|in:hang_ngay,hang_tuan,hang_thang,hang_nam',
            'ngay_bat_dau' => 'required|date',
            'ghi_chu' => 'nullable|string'
        ];",
        'messages' => "return [
            'danh_muc_id.required' => 'Vui lòng chọn danh mục.',
            'so_tien.required' => 'Vui lòng nhập số tiền giao dịch định kỳ.',
            'loai_giao_dich.required' => 'Vui loại giao dịch (thu/chi).',
            'chu_ky.required' => 'Vui lòng chọn chu kỳ.',
            'ngay_bat_dau.required' => 'Vui lòng ngày bắt đầu chu kỳ.'
        ];"
    ],
    'Category/StoreCategoryRequest' => [
        'rules' => "return [
            'ten_danh_muc' => 'required|string|max:255',
            'loai_danh_muc' => 'required|in:thu,chi',
            'biu_tuong' => 'nullable|string'
        ];",
        'messages' => "return [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'loai_danh_muc.required' => 'Vui lòng chọn loại danh mục.'
        ];"
    ],
    'Profile/UpdateProfileRequest' => [
        'rules' => "return [
            'ho_ten' => 'required|string|max:255',
            'tien_te' => 'nullable|string|size:3',
            'ngon_ngu' => 'nullable|string|size:2'
        ];",
        'messages' => "return [
            'ho_ten.required' => 'Vui lòng nhập họ và tên hiển thị.',
            'tien_te.size' => 'Định dạng tiền tệ không đúng.',
            'ngon_ngu.size' => 'Định dạng ngôn ngữ không đúng.'
        ];"
    ],
    'Profile/VerifyPasswordOtpRequest' => [
        'rules' => "return [
            'otp' => 'required|digits:6',
            'password' => 'required|confirmed|min:6'
        ];",
        'messages' => "return [
            'otp.required' => 'Vui lòng nhập mã bảo mật OTP.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.'
        ];"
    ]
];

foreach ($requests as $name => $data) {
    $path = $dir . '/' . $name . '.php';
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // Ensure authorize returns true
        $content = str_replace('return false;', 'return true;', $content);
        
        // Replace empty rules array
        $content = preg_replace('/public function rules\(\): array\s*\{\s*return \[.*?\];\s*\}/s', 'public function rules(): array { ' . $data['rules'] . ' }', $content);
        
        // Add custom messages function
        $msgFunc = "\n    public function messages(): array {\n        " . $data['messages'] . "\n    }\n}";
        $content = preg_replace('/\}\s*$/', $msgFunc, $content);
        
        file_put_contents($path, $content);
        echo "Updated $name\n";
    }
}
echo "Done.\n";
