<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function home()
    {
        $shipperId = auth()->id();

        if (!$shipperId) {
            return redirect()->route('login')->with('error', 'Bạn phải đăng nhập mới được vào trang shipper');
        }

        $stats = [
            'available' => Order::where('status_order', 'confirmed')->count(),
            'assigned' => Order::where('status_order', 'shipping')->where('shipper_id', $shipperId)->count(),
            'delivered' => Order::where('status_order', 'delivered')->where('shipper_id', $shipperId)->count(),
        ];

        $availableOrders = Order::whereNull('shipper_id')
            ->where('status_order', 'confirmed')
            ->orderByDesc('created_at')
            ->get();

        $myOrders = Order::where('shipper_id', $shipperId)
            ->orderByDesc('created_at')
            ->get();

        return view('shippers.home', compact('availableOrders', 'myOrders', 'stats'));
    }

    public function acceptOrder(Request $request, Order $order)
    {
        $shipperId = auth()->id();

        if ($order->status_order !== 'confirmed' || $order->shipper_id !== null) {
            return redirect()->back()->with('error', 'Đơn hàng không khả dụng để nhận.');
        }

        $order->shipper_id = $shipperId;
        $order->status_order = 'shipping';
        $order->save();

        return redirect()->back()->with('success', 'Bạn đã nhận đơn thành công!');
    }

    public function completeOrder(Request $request, Order $order)
    {
        $shipperId = auth()->id();

        if ($order->shipper_id !== $shipperId) {
            return redirect()->back()->with('error', 'Bạn không có quyền hoàn thành đơn này.');
        }

        if ($order->status_order !== 'shipping') {
            return redirect()->back()->with('error', 'Chỉ có thể hoàn thành đơn đang giao.');
        }

        $order->status_order = 'delivered';
        $order->save();

        return redirect()->back()->with('success', 'Bạn đã hoàn thành đơn hàng thành công!');
    }
}
