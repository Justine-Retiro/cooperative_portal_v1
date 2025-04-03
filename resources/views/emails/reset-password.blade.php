<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
        <table role="presentation" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="background: #ffffff; padding: 20px;">
                    <table role="presentation" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px; text-align: center; font-size: 24px;">Reset Password Successfully</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; text-align: left;">
                                <p>Hello, {{ $name }}</p>
                                <p>Your password has been successfully reset.<br>Your account number and password, which is your birthdate, will be provided and format below:</p>
                                <p class="mb-0"><strong>Account Number:</strong> {{ $account_number }} </p>
                                <p class="mb-0"><strong>Default Password:</strong> YYYY-MM-DD </p>
                                <p class="mb-0">Best Regards,<br>Credit Cooperative Partners</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p style="font-size: 12px; color: #666; text-align: center;">
            This message was sent to <a href="mailto:{{ $email }}">{{ $email }}</a> and intended for {{ $name }}.<br>
            If you have questions or complaints, please contact us.<br>
            © {{ date('Y') }} Credit Cooperative Partners. All rights reserved.
        </p>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

