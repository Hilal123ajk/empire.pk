<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ActivityLogService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orders,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        return view('admin.orders.index', [
            'adminOrders' => $this->orders->getOrdersForAdmin(),
        ]);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
        ]);

        $previousStatus = $order->status;

        $updated = $this->orders->updateStatus($order, $validated['status']);

        if ($previousStatus !== $updated->status) {
            $this->activityLog->log(
                action: 'status_changed',
                subjectType: 'order',
                subjectId: $updated->id,
                subjectLabel: $updated->order_number,
                properties: [
                    'from_status' => $previousStatus,
                    'to_status' => $updated->status,
                ],
            );
        }

        return response()->json([
            'success' => true,
            'order' => $this->orders->formatOrderForAdmin($updated),
        ]);
    }
}
