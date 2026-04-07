# Tài Liệu Luồng Nghiệp Vụ Dự Án: The Fiscal Curator

Tài liệu này giải thích chi tiết luồng hoạt động của các chức năng chính trong dự án quản lý tài chính cá nhân.

---

## 1. Luồng Xác Thực & Bảo Mật (Authentication)

### Đăng ký tài khoản
1. Người dùng nhập thông tin (Họ tên, Email, Mật khẩu).
2. Hệ thống tạo tài khoản với trạng thái `email_verified_at = null`.
3. Một mã **OTP (6 chữ số)** được tạo ngẫu nhiên và gửi qua Email người dùng.
4. Người dùng được chuyển đến trang xác thực OTP. Sau khi nhập đúng và còn hạn, tài khoản được kích hoạt (`email_verified_at` được cập nhật).

### Đăng nhập
1. Kiểm tra Email và Mật khẩu.
2. Nếu tài khoản chưa xác thực Email, hệ thống sẽ tự động gửi mã OTP mới và yêu cầu xác thực trước khi cho phép vào Dashboard.
3. Nếu đã xác thực, người dùng vào Dashboard.

### Quên mật khẩu
1. Người dùng nhập Email.
2. Hệ thống kiểm tra sự tồn tại của Email và gửi mã OTP đặt lại mật khẩu.
3. Người dùng nhập mã OTP và mật khẩu mới để cập nhật.

---

## 2. Luồng Quản Lý Giao Dịch (Transactions)

### Thêm khoản chi (Expense)
1. Người dùng chọn danh mục, số tiền, ngày và ghi chú.
2. Hệ thống lưu vào bảng `giao_dich`.
3. **Kiểm tra Ngân sách (Budget):** Hệ thống tự động tính tổng chi tiêu của danh mục đó trong tháng hiện tại. Nếu vượt quá hạn mức ngân sách đã thiết lập, một thông báo (`Notification`) sẽ được gửi đến người dùng.

### Thêm khoản thu (Income)
1. Người dùng nhập nguồn thu, số tiền và ngày nhận.
2. Hệ thống lưu vào bảng `khoan_thu`.

### Import/Export Excel
*   **Export:** Sử dụng `maatwebsite/excel` để xuất toàn bộ lịch sử giao dịch ra file `.xlsx`.
*   **Import:** Người dùng tải file mẫu, điền dữ liệu và upload. Hệ thống sẽ đọc và thêm hàng loạt vào database.

---

## 3. Luồng Trí Tuệ Nhân Tạo (AI Smart Features)

Hệ thống sử dụng **OpenRouter API** (Model Gemini 2.0 Flash) để xử lý.

### Phân tích thói quen (Habit Analysis)
1. Thu thập dữ liệu chi tiêu trong 30 ngày gần nhất (tổng tiền, tỷ lệ giữa các nhóm: Ăn uống, Giải trí, Cố định...).
2. Gửi dữ liệu này kèm `System Instruction` (đóng vai chuyên gia tài chính) sang AI.
3. AI trả về nhận xét và lời khuyên dưới dạng Markdown. Kết quả được lưu vào bảng `phan_tich_ai` để xem lại.

### Nhập liệu nhanh bằng AI (Quick Input)
1. Người dùng nhập câu nói tự nhiên (VD: "Nay ăn phở hết 40k").
2. AI phân tích câu nói và trả về JSON chuẩn: `{"so_tien": 40000, "ten_danh_muc": "Ăn uống", "loai": "chi"}`.
3. Hệ thống tự động tìm danh mục tương ứng (nếu chưa có sẽ tạo mới) và tạo giao dịch mà không cần người dùng điền form thủ công.

### Trợ lý ảo (Curator AI Chatbot)
1. Khi người dùng hỏi, hệ thống sẽ gom thông tin tài chính hiện tại (Tổng thu, tổng chi, số dư, chi tiết danh mục) làm ngữ cảnh (`Context`).
2. Gửi câu hỏi + Ngữ cảnh sang AI.
3. AI trả lời dựa trên số liệu thực tế của người dùng, giúp câu trả lời trở nên cá nhân hóa và chính xác.

---

## 4. Luồng Kho An Toàn (Safe Vault)

Đây là tính năng bảo vệ số tiền tiết kiệm đặc biệt.

1. **Xác thực 2 lớp:** Để vào Kho an toàn, người dùng phải yêu cầu gửi mã OTP về Email và xác thực thành công. Trạng thái xác thực được lưu vào `Session` (tự động mất khi đóng trình duyệt hoặc nhấn Khóa).
2. **Nạp tiền (Transfer to Safe):**
    - Trừ tiền từ "Số dư khả dụng" (Tạo một giao dịch Chi với danh mục "Kho an toàn").
    - Cộng tiền vào cột `so_du_kho_an_toan` trong bảng `nguoi_dung`.
3. **Rút tiền (Withdraw from Safe):**
    - Kiểm tra số dư trong kho.
    - Trừ tiền ở `so_du_kho_an_toan`.
    - Cộng lại vào "Số dư khả dụng" (Tạo một giao dịch Thu với danh mục "Kho an toàn").

---

## 5. Luồng Thanh Toán VNPay

1. **Tạo thanh toán:** Người dùng nhập số tiền cần nạp/thanh toán. Hệ thống tạo URL chuyển hướng sang cổng VNPay.
2. **Xử lý kết quả (Return URL):** Sau khi toán xong, VNPay điều hướng về web. Hệ thống kiểm tra chữ ký (`vnp_SecureHash`) để đảm bảo tính toàn vẹn dữ liệu và cập nhật lịch sử giao dịch vào bảng `giao_dich_vnpay`.

---

## 6. Ngân Sách & Mục Tiêu Tiết Kiệm

*   **Ngân sách (Budget):** Thiết lập hạn mức chi cho từng danh mục theo tháng. Được dùng để cảnh báo khi chi tiêu quá tay.
*   **Mục tiêu tiết kiệm (Savings Goal):** Thiết lập mục tiêu (VD: Mua xe - 50tr). Người dùng có thể "Nạp tiền" vào mục tiêu này. Hệ thống sẽ tính toán % hoàn thành và dự báo ngày hoàn thành dựa trên tốc độ tiết kiệm.

---
*Tài liệu được tạo tự động bởi Antigravity AI @ 2026*
