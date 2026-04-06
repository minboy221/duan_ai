<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Giao dịch định kỳ đã được tạo</title>
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1d1a25; margin: 0; padding: 0; width: 100% !important; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        .card { background-color: #ffffff; border-radius: 24px; padding: 40px; box-shadow: 0 10px 30px rgba(36, 56, 156, 0.06); border: 1px solid #e2e7ff; }
        .header { text-align: center; margin-bottom: 30px; }
        .icon { font-size: 48px; margin-bottom: 15px; display: block; }
        .title { color: #24389c; font-size: 22px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { color: #757684; font-size: 15px; line-height: 1.6; }
        .stats-box { background: linear-gradient(135deg, #eaedff 0%, #f2f3ff 100%); border-radius: 16px; padding: 25px; margin: 25px 0; }
        .stat-item { display: flex; justify-content: space-between; margin-bottom: 12px; align-items: center; }
        .stat-item:last-child { margin-bottom: 0; }
        .stat-label { color: #454652; font-size: 14px; font-weight: 600; }
        .stat-value { color: #131b2e; font-size: 14px; font-weight: 700; font-variant-numeric: tabular-nums; }
        .amount-highlight { font-size: 28px; font-weight: 800; text-align: center; margin: 20px 0 10px; }
        .income { color: #006c49; }
        .expense { color: #8a0027; }
        .divider { height: 1px; background-color: #dae2fd; margin: 15px 0; }
        .footer { text-align: center; color: #757684; font-size: 12px; margin-top: 30px; line-height: 1.6; }
        .btn { display: inline-block; background-color: #24389c; color: #ffffff !important; padding: 14px 32px; border-radius: 14px; text-decoration: none; font-weight: 700; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="icon">🔄</span>
            <div class="title">Giao dịch định kỳ đã được tạo</div>
            <p class="subtitle">Chào <strong>{{ $ho_ten }}</strong>, hệ thống đã tự động tạo giao dịch theo lịch định kỳ của bạn.</p>
        </div>

        <div class="card">
            <div class="amount-highlight {{ $loai === 'Thu nhập' ? 'income' : 'expense' }}">
                {{ $loai === 'Thu nhập' ? '+' : '-' }}{{ $so_tien }}
            </div>

            <div class="stats-box">
                <div class="stat-item">
                    <span class="stat-label">Loại giao dịch</span>
                    <span class="stat-value">{{ $loai }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Danh mục</span>
                    <span class="stat-value">{{ $danh_muc }}</span>
                </div>
                <div class="divider"></div>
                <div class="stat-item">
                    <span class="stat-label">Ngày thực hiện</span>
                    <span class="stat-value">{{ $ngay_giao_dich }}</span>
                </div>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ url('/giao-dich') }}" class="btn">Xem chi tiết giao dịch →</a>
            </div>
        </div>

        <div class="footer">
            <p>Thông báo này được gửi tự động bởi <strong>Fiscal Curator</strong>.</p>
            <p>Nếu bạn muốn dừng, hãy vào mục <em>Giao dịch Định kỳ</em> và tắt trạng thái.</p>
            <p>© 2026 Fiscal Curator. Hành trình tài chính thịnh vượng.</p>
        </div>
    </div>
</body>
</html>
