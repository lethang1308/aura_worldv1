<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $orders = Order::with('payment.transaction')
            ->whereHas('payment')
            ->latest()
            ->paginate(10);

        return view('admins.purchases.purchaseslist', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['payment.transaction'])
            ->where('id', $id)
            ->firstOrFail();

        return view('admins.purchases.purchasesshow', compact('order'));
    }
}