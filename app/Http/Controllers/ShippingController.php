<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GHTKService;

class ShippingController extends Controller
{
    protected $ghtk;

    public function __construct(GHTKService $ghtk)
    {
        $this->ghtk = $ghtk;
    }

    // Tạo đơn hàng GHTK
    public function createGHTKOrder(Request $request)
    {
        $orderData = $request->all();
        $response = $this->ghtk->createOrder($orderData);

        if ($response['success']) {
            return response()->json(['success' => true, 'data' => $response['data']]);
        } else {
            return response()->json(['success' => false, 'message' => $response['message']], 400);
        }
    }

    // Tra cứu vận đơn GHTK
    public function trackGHTKOrder($label)
    {
        $response = $this->ghtk->getOrder($label);

        if ($response['success']) {
            return response()->json(['success' => true, 'data' => $response['data']]);
        } else {
            return response()->json(['success' => false, 'message' => $response['message']], 400);
        }
    }
}
