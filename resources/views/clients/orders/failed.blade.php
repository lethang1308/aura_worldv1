    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Thanh toán thành công</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="bg-light">

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if (session('success'))
                        <div class="container">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <h4>{{ session('error') }}</h4>
                                    <p><strong>Mã đơn hàng:</strong> {{ session('order_id') }}</p>
                                    <p><strong>Mã giao dịch VNPay:</strong> {{ session('transaction_id') }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            Không có thông tin đơn hàng.
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
