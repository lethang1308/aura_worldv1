<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentTransaction;
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

        $order = Order::with('orderDetails.variant')->find($orderId);

        if (!$order) {
            return redirect()->route('client.orders.failed')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($responseCode == '00') {
            // ✅ Cập nhật đơn hàng
            $order->update([
                'status_payment' => 'paid',
                'status_order' => 'pending',
                'vnpay_transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
            ]);

            // ✅ Ghi vào bảng payments
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'vnpay',
                'amount' => $order->total_price,
                'payment_date' => now(),
            ]);

            // ✅ Ghi vào bảng payment_transactions

            PaymentTransaction::create([
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'gateway' => 'vnpay',
                'transaction_status' => 'success',
                'amount' => $order->total_price,
                'currency' => 'VND',
                'transaction_date' => now(),
                'response_transaction' => json_encode($inputData),
            ]);

            // ✅ Cập nhật tồn kho
            foreach ($order->orderDetails as $detail) {
                $variant = $detail->variant;
                if ($variant) {
                    $variant->stock_quantity = max(0, $variant->stock_quantity - $detail->quantity);
                    $variant->save();

                    app(\App\Http\Controllers\ProductController::class)->autoTrashIfOutOfStock($variant->product_id);
                }
            }

            return redirect()->route('client.orders.success')->with([
                'success' => 'Thanh toán thành công!',
                'order_id' => $order->id,
                'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
            ]);
        } else {
            // ❌ Thanh toán thất bại
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

        return view('clients.orders.success', compact('categories', 'brands'));
    }

    public function paymentFailed()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('clients.orders.failed', compact('categories', 'brands'));
    }
}
