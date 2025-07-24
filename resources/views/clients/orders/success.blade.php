@section('content')
    <div class="alert alert-success">
        <h3>{{ $success ?? 'Thanh toán thành công!' }}</h3>
        <p>Mã đơn hàng: {{ $order_id }}</p>
        <p>Mã giao dịch: {{ $transaction_id }}</p>
    </div>
@endsection
