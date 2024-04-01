<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
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
    </style>
</head>
<body>
    <div class="container py-3">
        <div class="card text-center mx-auto" style="width: 50%;">
            <div class="card-body">
                <div class="">
                    
                </div>
                <table class="table">
                    <tbody>
                        <tr id="header">
                            <td colspan="2" class="text-start d-flex align-items-center gap-3"><h2>Loan Application Received</h2></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-start">
                                <p class="mb-0">Hello, {{ $name }}</p>
                                <p style="font-size: 16px; line-height: 1.5;">We are happy to inform you that your loan application has been <strong>successfully received</strong>. Rest assured, it is now in the process of being reviewed by our dedicated team. We understand the importance of this matter to you and are giving it the careful attention it deserves.</p>
                                <p style="font-size: 16px; line-height: 1.5;">We will keep you updated on the status of your application and reach out with any updates or if additional information is needed. Your trust in us is greatly appreciated, and we are committed to assisting you with your financial needs.</p>
                                <p style="font-size: 16px; line-height: 1.5;">Thank you for choosing Credit Cooperative Partners.</p>
                                <br>
                                <p style="font-size: 16px; line-height: 1.5;">Warm Regards,<br>Credit Cooperative Partners</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            <div class="text-start mt-4">
                <small class="text-muted">This message was sent to <a href="mailto:{{ $email }}">{{ $email }}</a> and intended for {{ ucfirst($name) }}. <br>If you have questions or complaints, please contact us.</small>
                <br>
                <small class="text-muted">© {{ date('Y') }} Credit Cooperative Partners. All rights reserved.</small>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
