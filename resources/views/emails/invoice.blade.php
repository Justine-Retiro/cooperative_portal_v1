<!DOCTYPE html>
<html>
<head>
    <title>Invoice Email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div id="header" class="text-start d-flex align-items-center gap-3">
                    <h2>Invoice Details</h2>
                </div>
                <hr>
                <h1 class="card-title">Payment Confirmation</h1>
                <p class="card-text">Dear Customer, {{ $name }}</p>
                <p class="card-text">Your payment has been successfully received. We sincerely appreciate your timely payment and are grateful for your trust in our services. For more details, please check your account.</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Payment Date</th>
                                <td>{{ $paymentDate }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Transaction Occurred</th>
                                <td>{{ $transaction }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Biller Name</th>
                                <td>Credit Cooperative</td>
                            </tr>
                            <tr>
                                <th scope="row">Payment Reference Number</th>
                                <td>{{ $referenceNumber }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Amount Paid</th>
                                <td>Php {{ $amountPaid }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Payment Remarks</th>
                                <td>{{ $remarks }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="text-start mt-4">
                    <small class="text-muted">This message was sent to <a href="mailto:{{ $email }}">{{ $email }}</a> and intended for {{ ucfirst($name) }}. <br>If you have questions or complaints, please contact us.</small>
                    <br>
                    <small class="text-muted">© {{ date('Y') }} Credit Cooperative Partners. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

