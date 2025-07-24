@section('content')
    <div class="alert alert-danger">
        <h3>{{ $error ?? 'Thanh toán thất bại!' }}</h3>
        @if($order_id)
            <p>Mã đơn hàng: {{ $order_id }}</p>
        @endif
        @if($transaction_id)
            <p>Mã giao dịch: {{ $transaction_id }}</p>
        @endif
    </div>
@endsection
