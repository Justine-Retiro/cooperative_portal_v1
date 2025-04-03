<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="padding: 1.5rem 0; max-width: 600px; margin: 0 auto; text-align: center;">
        <div style="margin: 0 auto; width: 50%;">
            <div style="padding: 1.5rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #CCCCCC;">
                            <td colspan="2" style="text-align: left; display: flex; align-items: center; gap: 1rem;"><img src="{{ asset('/assets/logo.png') }}" style="max-width: 100%; height: auto;" alt="Logo" width="100" height="25px"><h2 style="font-size: 24px;">Code Verification</h2></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left;">
                                <p style="margin-bottom: 0;">Hello, {{ $name }}</p>
                                <p style="margin-bottom: 0;">Please complete the change password process for the Cooperative Portal by entering the code provided below:</p>
                                <div style="text-align: center; display: flex; flex-direction: column; justify-content: center; width: auto; margin-top: 1.5rem; margin-bottom: 1.5rem;">
                                    <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                                        <span style="border: 1px solid #ccc; border-radius: 5px padding: 1.5rem; font-size: 2rem; width: auto;">{{ $verificationCode }}</span>
                                    </div>
                                </div>
                                <p style="margin-bottom: 0;">If you did not request this, no further action is required.</p>
                                <p style="margin-bottom: 0;">Best Regards,<br>Credit Cooperative Partners</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            <div style="text-align: left; margin-top: 1rem;">
                <small style="color: #6c757d;">This message was sent to <a href="mailto:{{ $email }}">{{ $email }}</a> and intended for {{ $name }}. <br>If you have questions or complaints, please contact us.</small>
                <br>
                <small style="color: #6c757d;">© {{ date('Y') }} Credit Cooperative Partners. All rights reserved.</small>
            </div>
        </div>
    </div>
</body>
</html>

