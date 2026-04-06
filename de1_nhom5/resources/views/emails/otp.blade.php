<!DOCTYPE html>
<html>
<head>
    <title>Mã xác thực OTP</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4F46E5;">The Fiscal Curator</h2>
        @if($type === 'reset')
            <p>Chào bạn,</p>
            <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Dưới đây là mã xác thực OTP của bạn:</p>
        @else
            <p>Chào mừng bạn đến với The Fiscal Curator,</p>
            <p>Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã xác thực OTP dưới đây:</p>
        @endif
        
        <div style="background-color: #F3F4F6; padding: 15px; text-align: center; margin: 20px 0; border-radius: 8px;">
            <h1 style="margin: 0; color: #111827; letter-spacing: 5px;">{{ $otp }}</h1>
        </div>
        
        <p>Mã này có hiệu lực trong vòng 5 phút.</p>
        <p>Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,</p>
        <p><strong>Đội ngũ The Fiscal Curator</strong></p>
    </div>
</body>
</html>
