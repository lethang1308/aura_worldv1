<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GHTKService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = config('services.ghtk.token'); // Thêm vào config/services.php
        $this->baseUrl = 'https://services.giaohangtietkiem.vn';
    }

    // Tạo đơn hàng
    public function createOrder($orderData)
    {
        $url = $this->baseUrl . '/services/shipment/order';
        $response = Http::withToken($this->token)
            ->acceptJson()
            ->post($url, ['order' => $orderData]);

        if ($response->successful() && isset($response['success']) && $response['success']) {
            return ['success' => true, 'data' => $response->json()];
        }
        return ['success' => false, 'message' => $response['message'] ?? 'GHTK API error'];
    }

    // Tra cứu vận đơn
    public function getOrder($label)
    {
        $url = $this->baseUrl . '/services/shipment/v2/' . $label;
        $response = Http::withToken($this->token)
            ->acceptJson()
            ->get($url);

        if ($response->successful() && isset($response['success']) && $response['success']) {
            return ['success' => true, 'data' => $response->json()];
        }
        return ['success' => false, 'message' => $response['message'] ?? 'GHTK API error'];
    }
}
