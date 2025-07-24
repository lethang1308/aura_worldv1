<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Services\VNPayService;
use Illuminate\Http\Request;

class VNPayController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function return(Request $request)
    {
        $inputData = $request->all();

        if (!$this->vnpayService->validateResponse($inputData)) {
            return redirect()->route('client.orders.failed')->with('error', 'Chữ ký không hợp lệ!');
        }

        $orderId = $inputData['vnp_TxnRef'];
        $responseCode = $inputData['vnp_ResponseCode'];

        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->route('client.orders.failed')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($responseCode == '00') {
            // Thanh toán thành công
            $order->update([
                'status_payment' => 'paid',
                'status_order' => 'paid',
                'vnpay_transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
            ]);

            return redirect()->route('client.orders.success')->with([
                'success' => 'Thanh toán thành công!',
                'order_id' => $orderId,
                'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
            ]);
        } else {
            // Thanh toán thất bại
            return redirect()->route('client.orders.failed')->with([
                'error' => 'Thanh toán thất bại! Mã lỗi: ' . $responseCode,
                'order_id' => $orderId,
                'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
            ]);
        }
    }

    public function paymentSuccess()
{
    $categories = Category::all();
    $brands = Brand::all();

    return view('clients.orders.success', [
        'categories' => $categories,
        'brands' => $brands,
        'success' => session('success'),
        'order_id' => session('order_id'),
        'transaction_id' => session('transaction_id'),
    ]);
}

public function paymentFailed()
{
    $categories = Category::all();
    $brands = Brand::all();

    return view('clients.orders.failed', [
        'categories' => $categories,
        'brands' => $brands,
        'error' => session('error'),
        'order_id' => session('order_id'),
        'transaction_id' => session('transaction_id'),
    ]);
}

}
