@extends('clients.layouts.default')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4" style="font-weight:700; font-size:2rem;">Chi tiết đơn hàng</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm rounded" style="background:#fff;">
            <thead style="background:#4cd964; color:#fff; font-weight:700; text-align:center;">
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->OrderDetail as $i => $detail)
                    <tr class="text-center align-middle">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $detail->variant->product->name ?? '-' }}</td>
                        <td>
                            @php
                                $image = $detail->variant->product->images->first();
                            @endphp
                            @if($image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image" style="width:80px; height:auto;">
                            @else
                                <span>No image</span>
                            @endif
                        </td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->variant_price, 0, ',', '.') }} vnd</td>
                        <td>{{ number_format($detail->total_price, 0, ',', '.') }} vnd</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 