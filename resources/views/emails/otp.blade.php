<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px;">
                <!-- Logo goes here; ensure the URL is absolute and publicly accessible -->
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 100px; height: 100px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="text-align: center;">
                <h1 style="margin-top: 20px;">OTP Forgot Your Password?</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 20px;">
                <h2>Dear {{ $name }},</h2>
                <p>We received a request to reset your password for your account. If you did not make this request, please ignore this email.</p>
                <p>Your One-Time Password (OTP) is: <strong>{{ $otp }}</strong></p>
                <p>Please use this OTP to proceed with resetting your password. Remember, the OTP is valid only for a short period of time.</p>
                <p>If you did not request a password reset, please ignore this email or contact support.</p>
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size: 0.9em; text-align: center; margin-top: 20px;">
                Best regards,<br>{{ get_setting('site_name') }} Team
            </td>
        </tr>
    </table>
</body>
</html>
