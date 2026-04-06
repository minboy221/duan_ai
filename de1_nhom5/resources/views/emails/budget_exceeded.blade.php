<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cảnh báo vượt ngân sách</title>
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #fcf7ff; color: #1d1a25; margin: 0; padding: 0; width: 100% !important; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        .card { background-color: #ffffff; border-radius: 24px; padding: 40px; box-shadow: 0 10px 30px rgba(79, 55, 138, 0.05); border: 1px solid #f1efff; }
        .header { text-align: center; margin-bottom: 30px; }
        .icon { font-size: 48px; margin-bottom: 15px; display: block; }
        .title { color: #4f378a; font-size: 24px; font-weight: 800; margin-bottom: 10px; }
        .subtitle { color: #79747e; font-size: 16px; line-height: 1.5; }
        .stats-box { background-color: #f1efff; border-radius: 16px; padding: 25px; margin: 30px 0; }
        .stat-item { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .stat-label { color: #49454f; font-size: 14px; font-weight: 600; }
        .stat-value { color: #1d1a25; font-size: 14px; font-weight: 700; font-variant-numeric: tabular-nums; }
        .highlight { color: #b3261e; font-size: 20px; font-weight: 800; border-top: 2px solid #e0dbff; padding-top: 15px; margin-top: 15px; }
        .advice { background-color: #f9dedc; border-left: 4px solid #b3261e; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px; }
        .advice-text { color: #410e0b; font-size: 14px; line-height: 1.6; margin: 0; }
        .footer { text-align: center; color: #79747e; font-size: 12px; margin-top: 30px; }
        .btn { display: inline-block; background-color: #4f378a; color: #ffffff !important; padding: 14px 30px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; text-align: center; transition: background-color 0.2s; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="icon">⚠️</span>
            <div class="title">Cảnh báo vượt chi tiêu</div>
            <p class="subtitle">Chào <strong>{{ $ho_ten }}</strong>, kế hoạch tài chính cho tháng này của bạn cần được điều chỉnh.</p>
        </div>

        <div class="card">
            <p style="margin: 0; font-size: 18px; font-weight: 700;">Hạng mục: <span style="color: #4f378a;">{{ $danh_muc }}</span></p>

            <div class="stats-box">
                <div class="stat-item">
                    <span class="stat-label">Hạn mức ngân sách</span>
                    <span class="stat-value">{{ number_format($han_muc, 0, ',', '.') }} VNĐ</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Số tiền đã chi tiêu</span>
                    <span class="stat-value">{{ number_format($da_chi_tieu, 0, ',', '.') }} VNĐ</span>
                </div>
                <div class="stat-item highlight">
                    <span class="stat-label" style="color: #b3261e;">Số tiền vượt mức</span>
                    <span class="stat-value" style="color: #b3261e;">{{ number_format($da_chi_tieu - $han_muc, 0, ',', '.') }} VNĐ</span>
                </div>
            </div>

            <div class="advice">
                <p class="advice-text"><strong>💡 Lời khuyên Fiscal Curator:</strong> Bạn đã sử dụng hết ngân sách tháng này cho "{{ $danh_muc }}". Hãy cân nhắc cắt giảm các khoản chi tiêu không cần thiết ở các hạng mục khác để cân bằng lại tài chính cá nhân.</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/transactions') }}" class="btn">Xem chi tiết giao dịch</a>
            </div>
        </div>

        <div class="footer">
            <p>Thông báo này được gửi tự động bởi Fiscal Curator vào lúc {{ $ngay }}.</p>
            <p>© 2026 Fiscal Curator. Hành trình tài chính thịnh vượng của bạn.</p>
        </div>
    </div>
</body>
</html>
