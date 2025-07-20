    <!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
</head>
<body>
    <h1>Your OTP Code</h1>
    <p>Your One-Time Password (OTP) is: <strong>{{ $otp }}</strong></p>
    <p>This code is valid for 10 minutes.</p>
    <p>If you didn’t request this, ignore this email.</p>
    <p>Thank you,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>