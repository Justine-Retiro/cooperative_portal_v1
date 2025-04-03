<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- <style>
    #header{
        border-bottom: 1px solid #CCCCCC;
    }
    table, th, td {
            border: none;
        }
    @media (max-width: 768px) {
        .card {
            width: 90% !important; /* Adjust card width on smaller screens */
        }
        .img-fluid {
            max-width: 80px; /* Adjust logo size on smaller screens */
            height: auto;
        }
        h2 {
            font-size: 16px; /* Adjust heading size on smaller screens */
        }
        .btn-lg {
            padding: .5rem 1rem; /* Adjust button size on smaller screens */
            font-size: .875rem;
        }
    }
    </style> --}}
</head>
<body>
    <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
        <table role="presentation" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="background: #ffffff; padding: 20px;">
                    <table role="presentation" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px; text-align: center; font-size: 24px;">Email Verification</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; text-align: left;">
                                <p>Hello, {{ $name }}</p>
                                <p>Complete signing in for Cooperative Portal by entering the code below:</p>
                                <p style="text-align: center; border-radius: 5px; font-size: 18px; border: 1px solid #ccc; padding: 10px;">{{ $verificationCode }}</p>
                                <p style="text-align: center;">
                                    <a href="{{ $verificationUrl }}" style="background-color: #4CAF50; border-radius: 5px; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">Verify Email</a>
                                </p>
                                <br>
                                <p>If you did not create an account, no further action is required.</p>
                                <p>Best Regards,<br>Credit Cooperative Partners</p>
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
