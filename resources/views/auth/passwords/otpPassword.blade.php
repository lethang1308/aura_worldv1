<!DOCTYPE html>
<html>
<head>
    <title>Mã Xác Thực OTP Của Bạn</title>
</head>
<body>
    <h1>Mã Xác Thực OTP</h1>
    <p>Mã OTP (One-Time Password) của bạn là: <strong>{{ $otp }}</strong></p>
    <p>Mã này có hiệu lực trong vòng 10 phút.</p>
    <p>Nếu bạn không yêu cầu hành động này, vui lòng bỏ qua email này.</p>
    <p>Trân trọng,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
