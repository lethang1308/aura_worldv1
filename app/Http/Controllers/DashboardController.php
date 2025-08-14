<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from_date', date('Y-m-d'));
        $to = $request->input('to_date', date('Y-m-d'));
        if ($to < $from) {
            $to = $from;
        }
        $fromStart = $from . ' 00:00:00';
        $toEnd = $to . ' 23:59:59';
        // Tổng doanh thu
        $totalRevenue = Order::where('status_order', 'completed')
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->sum('total_price');

        // Thống kê KPI cơ bản
        $totalOrders = Order::whereBetween('created_at', [$fromStart, $toEnd])->count();
        $completedOrders = Order::where('status_order', 'completed')
            ->whereBetween('created_at', [$fromStart, $toEnd])->count();
        $pendingOrders = Order::where('status_order', 'pending')
            ->whereBetween('created_at', [$fromStart, $toEnd])->count();
        $cancelledOrders = Order::where('status_order', 'cancelled')
            ->whereBetween('created_at', [$fromStart, $toEnd])->count();
        $receivedOrders = Order::where('status_order', 'received')
            ->whereBetween('created_at', [$fromStart, $toEnd])->count();
        $newCustomers = User::whereBetween('created_at', [$fromStart, $toEnd])->count();
        $averageOrderValue = $completedOrders > 0 ? round($totalRevenue / max($completedOrders, 1)) : 0;

        // Doanh thu theo ngày (để vẽ biểu đồ)
        $revenueByDayRows = Order::selectRaw('DATE(created_at) as day, SUM(total_price) as revenue')
            ->where('status_order', 'completed')
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->groupBy('day')
            ->orderBy('day')
            ->get();
        $revenueLabels = $revenueByDayRows->pluck('day')->map(fn($d) => date('Y-m-d', strtotime($d)))->toArray();
        $revenueSeries = $revenueByDayRows->pluck('revenue')->map(fn($v) => (float)$v)->toArray();

        // Đơn hàng theo trạng thái
        $ordersByStatus = Order::select('status_order', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->groupBy('status_order')
            ->pluck('count', 'status_order')
            ->toArray();

        // Top danh mục theo doanh thu
        $topCategories = OrderDetail::query()
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('variants', 'order_details.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status_order', 'completed')
            ->whereBetween('orders.created_at', [$fromStart, $toEnd])
            ->selectRaw('categories.id, categories.category_name, SUM(order_details.total_price) as revenue, SUM(order_details.quantity) as total_quantity')
            ->groupBy('categories.id', 'categories.category_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Đơn hàng theo phương thức thanh toán
        $ordersByPayment = Order::select('type_payment', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->groupBy('type_payment')
            ->pluck('count', 'type_payment')
            ->toArray();
        // Top 5 user mua nhiều nhất
        $topUsers = Order::where('status_order', 'completed')
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->selectRaw('user_id, SUM(total_price) as total_spent, COUNT(*) as order_count')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->with('user')
            ->take(5)
            ->get();
        // Top 5 sản phẩm bán chạy nhất
        $topProducts = OrderDetail::whereHas('order', function ($q) use ($fromStart, $toEnd) {
            $q->where('status_order', 'completed')
                ->whereBetween('created_at', [$fromStart, $toEnd]);
        })
            ->selectRaw('variant_id, SUM(quantity) as total_sold')
            ->groupBy('variant_id')
            ->orderByDesc('total_sold')
            ->with(['variant.product'])
            ->take(5)
            ->get();
        // Top 5 sản phẩm bán ít nhất (có bán ra)
        $bottomProducts = OrderDetail::whereHas('order', function ($q) use ($fromStart, $toEnd) {
            $q->where('status_order', 'completed')
                ->whereBetween('created_at', [$fromStart, $toEnd]);
        })
            ->selectRaw('variant_id, SUM(quantity) as total_sold')
            ->groupBy('variant_id')
            ->orderBy('total_sold', 'asc')
            ->with(['variant.product'])
            ->take(5)
            ->get();
        return view('admins.dashboard.index', compact(
            'from',
            'to',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'receivedOrders',
            'cancelledOrders',
            'newCustomers',
            'averageOrderValue',
            'revenueLabels',
            'revenueSeries',
            'ordersByStatus',
            'ordersByPayment',
            'topUsers',
            'topProducts',
            'bottomProducts',
            'topCategories'
        ));
    }
}
