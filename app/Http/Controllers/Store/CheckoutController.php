<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreCheckoutRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly OrderService $orders,
    ) {}

    public function store(StoreCheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orders->createFromCheckout($request->validated());
        } catch (\InvalidArgumentException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
        ]);
    }
}
