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
            // Tổng số sản phẩm
            $totalProducts = \App\Models\Product::count();
            // Tổng số đơn hàng
            $totalOrders = Order::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->count();
            // Tổng số đơn bị hủy
            $cancelledOrders = Order::where('status_order', 'cancelled')
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->count();
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
        $topProducts = OrderDetail::whereHas('order', function ($q) use ($from, $to) {
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
        $bottomProducts = OrderDetail::whereHas('order', function ($q) use ($from, $to) {
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

        // === Thêm dữ liệu biểu đồ (KHÔNG xóa code cũ) ===
        $topProductsChartLabels = $topProducts->map(function ($item) {
            return $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A';
        });
        $topProductsChartData = $topProducts->pluck('total_sold');

        $bottomProductsChartLabels = $bottomProducts->map(function ($item) {
            return $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A';
        });
        $bottomProductsChartData = $bottomProducts->pluck('total_sold');
            // Tạo URL ảnh biểu đồ bằng QuickChart
            $topProductsChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
                'type' => 'bar',
                'data' => [
                    'labels' => $topProductsChartLabels,
                    'datasets' => [[
                        'label' => 'Số lượng bán',
                        'data' => $topProductsChartData,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.8)'
                    ]]
                ],
                'options' => [
                    'indexAxis' => 'y',
                    'plugins' => [
                        'legend' => ['display' => false]
                    ]
                ]
            ]));
            $bottomProductsChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
                'type' => 'bar',
                'data' => [
                    'labels' => $bottomProductsChartLabels,
                    'datasets' => [[
                        'label' => 'Số lượng bán',
                        'data' => $bottomProductsChartData,
                        'backgroundColor' => 'rgba(255, 206, 86, 0.8)'
                    ]]
                ],
                'options' => [
                    'indexAxis' => 'y',
                    'plugins' => [
                        'legend' => ['display' => false]
                    ]
                ]
            ]));
        // === Hết phần thêm ===

        // === Thêm dữ liệu biểu đồ doanh thu theo ngày ===
        $revenueByDate = Order::where('status_order', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueChartLabels = $revenueByDate->pluck('date');
        $revenueChartData = $revenueByDate->pluck('total');


        return view('admins.dashboard.index', compact(
            'totalRevenue',
            'totalProducts',
            'totalOrders',
            'cancelledOrders',
            'topUsers',
            'topProducts',
            'bottomProducts',
            'from',
            'to',
            'topProductsChartLabels',
            'topProductsChartData',
            'bottomProductsChartLabels',
            'revenueChartLabels',
            'revenueChartData',
            'bottomProductsChartData',
            'topProductsChartUrl',
            'bottomProductsChartUrl'
        ));
    }
}
