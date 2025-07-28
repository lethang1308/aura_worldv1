<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use DB;
use Log;
use Exception;

class VNPayController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function return(Request $request)
    {
        try {
            $inputData = $request->all();

            $responseCode = $inputData['vnp_ResponseCode'] ?? null;

            if ($responseCode === '504') {
                return redirect()->route('client.orders.failed')
                    ->with('error', 'VNPay hiện không phản hồi. Tạm thời không thể thanh toán bằng phương thức này.');
            }

            // Validate response
            if (!$this->vnpayService->validateResponse($inputData)) {
                return redirect()->route('client.orders.failed')
                    ->with('error', 'Chữ ký không hợp lệ!');
            }

            $orderId = $inputData['vnp_TxnRef'] ?? null;
            $responseCode = $inputData['vnp_ResponseCode'] ?? null;

            if (!$orderId) {
                Log::error('Order ID not found in VNPay response', $inputData);
                return redirect()->route('client.orders.failed')
                    ->with('error', 'Không tìm thấy mã đơn hàng!');
            }

            $order = Order::with('orderDetails.variant.product')->find($orderId);

            if (!$order) {
                Log::error('Order not found', ['order_id' => $orderId]);
                return redirect()->route('client.orders.failed')
                    ->with('error', 'Không tìm thấy đơn hàng!');
            }

            // Kiểm tra nếu đã xử lý rồi
            if ($order->status_payment === 'paid') {
                return redirect()->route('client.orders.success')
                    ->with([
                        'success' => 'Đơn hàng đã được thanh toán!',
                        'order_id' => $order->id,
                    ]);
            }

            if ($responseCode == '00') {
                // Sử dụng transaction để đảm bảo tính nhất quán
                DB::transaction(function () use ($order, $inputData) {
                    // Cập nhật đơn hàng
                    $order->update([
                        'status_payment' => 'paid',
                        'status_order' => 'pending',
                        'vnpay_transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
                    ]);

                    // Tạo payment record
                    $payment = Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => 'vnpay',
                        'amount' => $order->total_price,
                        'payment_date' => now(),
                    ]);

                    // Tạo transaction record
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

                    // Cập nhật tồn kho (chỉ cập nhật, không gọi autoTrash)
                    foreach ($order->orderDetails as $detail) {
                        $variant = $detail->variant;
                        if ($variant && $variant->stock_quantity >= $detail->quantity) {
                            $variant->decrement('stock_quantity', $detail->quantity);
                        }
                    }
                });

                // Gọi autoTrash sau khi transaction hoàn tất
                try {
                    foreach ($order->orderDetails as $detail) {
                        if ($detail->variant && $detail->variant->product) {
                            app(\App\Http\Controllers\ProductController::class)
                                ->autoTrashIfOutOfStock($detail->variant->product_id);
                        }
                    }
                } catch (Exception $e) {
                    Log::error('Error in autoTrashIfOutOfStock', ['error' => $e->getMessage()]);
                    // Không làm gián đoạn flow chính
                }

                Log::info('VNPay payment successful', [
                    'order_id' => $order->id,
                    'transaction_id' => $inputData['vnp_TransactionNo'] ?? null
                ]);

                try {
                    Cart::where('user_id', $order->user_id)->delete();
                    session()->forget('applied_coupon');
                } catch (Exception $e) {
                    Log::warning('Không thể xoá giỏ hàng sau thanh toán VNPay', [
                        'user_id' => $order->user_id,
                        'error' => $e->getMessage()
                    ]);
                }

                return redirect()->route('client.orders.success')->with([
                    'success' => 'Thanh toán thành công!',
                    'order_id' => $order->id,
                    'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
                ]);
            } else {
                Log::warning('VNPay payment failed', [
                    'order_id' => $orderId,
                    'response_code' => $responseCode
                ]);

                return redirect()->route('client.orders.failed')->with([
                    'error' => 'Thanh toán thất bại! Mã lỗi: ' . $responseCode,
                    'order_id' => $orderId,
                    'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
                ]);
            }
        } catch (Exception $e) {
            Log::error('VNPay callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('client.orders.failed')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán!');
        }
    }

    public function paymentSuccess()
    {
        try {
            $categories = Category::all();
            $brands = Brand::all();

            return view('clients.orders.success', compact('categories', 'brands'));
        } catch (Exception $e) {
            Log::error('Payment success page error', ['error' => $e->getMessage()]);
            return redirect()->route('home')->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function paymentFailed()
    {
        try {
            $categories = Category::all();
            $brands = Brand::all();

            return view('clients.orders.failed', compact('categories', 'brands'));
        } catch (Exception $e) {
            Log::error('Payment failed page error', ['error' => $e->getMessage()]);
            return redirect()->route('home')->with('error', 'Có lỗi xảy ra!');
        }
    }
}
