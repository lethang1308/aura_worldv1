<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from_date', date('Y-m-d'));
        $to = $request->input('to_date', date('Y-m-d'));
        if ($to < $from) {
            $to = $from;
        }
        // Tổng doanh thu
        $totalRevenue = Order::where('status_order', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->sum('total_price');
        // Top 5 user mua nhiều nhất
        $topUsers = Order::where('status_order', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->selectRaw('user_id, SUM(total_price) as total_spent, COUNT(*) as order_count')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->with('user')
            ->take(5)
            ->get();
        // Top 5 sản phẩm bán chạy nhất
        $topProducts = OrderDetail::whereHas('order', function($q) use ($from, $to) {
                $q->where('status_order', 'completed')
                  ->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
            })
            ->selectRaw('variant_id, SUM(quantity) as total_sold')
            ->groupBy('variant_id')
            ->orderByDesc('total_sold')
            ->with(['variant.product'])
            ->take(5)
            ->get();
        // Top 5 sản phẩm bán ít nhất (có bán ra)
        $bottomProducts = OrderDetail::whereHas('order', function($q) use ($from, $to) {
                $q->where('status_order', 'completed')
                  ->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
            })
            ->selectRaw('variant_id, SUM(quantity) as total_sold')
            ->groupBy('variant_id')
            ->orderBy('total_sold', 'asc')
            ->with(['variant.product'])
            ->take(5)
            ->get();
        return view('admins.dashboard.index', compact('totalRevenue', 'topUsers', 'topProducts', 'bottomProducts', 'from', 'to'));
    }
} 