<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Form Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px;">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 100px; height: auto;">
            </td>
        </tr>

        <tr>
            <td align="center" style="text-align: center;">
                <h2 style="margin: 20px 0;">
                    @if(isset($forAdmin) && $forAdmin)
                        New Contact Form Submission
                    @else
                        Thank You for Contacting Us!
                    @endif
                </h2>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px; text-align: left;">
                @if(isset($forAdmin) && $forAdmin)
                    <p><strong>Name:</strong> {{ $data['name'] }}</p>
                    <p><strong>Email:</strong> {{ $data['email'] }}</p>
                    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
                    <p><strong>Message:</strong><br>{{ $data['message'] }}</p>
                @else
                    <p>Dear {{ $data['name'] }},</p>
                    <p>Thank you for contacting <strong>{{ get_setting('site_name') }}</strong>. We have received your message and will get back to you as soon as possible.</p>
                    <p><strong>Your Message:</strong><br>{{ $data['message'] }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <td align="center" style="font-size: 0.9em; text-align: center; padding: 20px 0;">
                Best regards,<br>
                <strong>{{ get_setting('site_name') }}</strong> Team
            </td>
        </tr>
    </table>
</body>
</html>
