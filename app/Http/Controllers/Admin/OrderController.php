<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Tìm kiếm theo mã đơn hàng (id)
        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }

        // Tìm kiếm theo tên tài khoản
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Lọc theo trạng thái đơn hàng
        if ($request->filled('status_order')) {
            $query->where('status_order', $request->status_order);
        }

        $orders = $query->orderByDesc('created_at')->paginate(15);

        // Lấy danh sách trạng thái để filter
        $statusList = [
            'pending' => 'Chưa xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao hàng',
            'shipped' => 'Đã giao hàng',
            'received' => 'Đã nhận hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã huỷ',
        ];

        return view('admins.orders.orderlist', compact('orders', 'statusList'));
    }

    // Xem chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['user', 'OrderDetail.variant.product'])->findOrFail($id);
        $statusList = [
            'pending' => 'Chưa xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao hàng',
            'shipped' => 'Đã giao hàng',
            'received' => 'Đã nhận hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã huỷ',
        ];
        return view('admins.orders.orderdetail', compact('order', 'statusList'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|string',
            'status_payment' => 'nullable|string',
        ]);
        $order = Order::findOrFail($id);
        // Không cho cập nhật nếu đã huỷ hoặc hoàn thành
        if (in_array($order->status_order, ['cancelled', 'completed'])) {
            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái đơn hàng đã huỷ hoặc đã hoàn thành.');
        }
        // Nếu trạng thái là cancelled thì phải dùng hàm cancel
        if ($request->status_order === 'cancelled') {
            return redirect()->back()->with('error', 'Vui lòng sử dụng chức năng huỷ đơn để huỷ đơn hàng.');
        }
        // Chỉ cho phép chuyển trạng thái tuần tự
        $statusSteps = ['pending', 'confirmed', 'shipping', 'shipped', 'completed'];
        $currentIndex = array_search($order->status_order, $statusSteps);
        $nextIndex = $currentIndex !== false ? $currentIndex + 1 : false;
        $nextStatus = $nextIndex !== false && isset($statusSteps[$nextIndex]) ? $statusSteps[$nextIndex] : null;
        if ($request->status_order !== $nextStatus) {
            return redirect()->back()->with('error', 'Chỉ được chuyển sang trạng thái tiếp theo, không được nhảy cóc.');
        }
        $order->status_order = $request->status_order;
        if ($request->filled('status_payment')) {
            $order->status_payment = $request->status_payment;
        }
        $order->save();
        // TODO: Lưu lịch sử thay đổi trạng thái nếu cần
        return redirect()->route('orders.show', $order->id)->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Huỷ đơn hàng (admin)
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|min:5',
        ]);
        $order = Order::findOrFail($id);
        if (in_array($order->status_order, ['cancelled', 'completed'])) {
            return redirect()->back()->with('error', 'Không thể huỷ đơn hàng đã huỷ hoặc đã hoàn thành.');
        }
        $order->status_order = 'cancelled';
        $order->cancel_reason = $request->cancel_reason;
        $order->cancelled_by_admin_id = Auth::id();
        $order->save();
        // TODO: Lưu lịch sử huỷ đơn nếu cần
        return redirect()->route('orders.show', $order->id)->with('success', 'Đã huỷ đơn hàng thành công!');
    }

    // Tìm kiếm/lọc đơn hàng
    public function search(Request $request)
    {
        // Tái sử dụng logic index để tìm kiếm/lọc
        return $this->index($request);
    }
} 