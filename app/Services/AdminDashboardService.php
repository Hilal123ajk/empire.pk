<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    private const LOW_STOCK_THRESHOLD = 10;

    public function __construct(
        private readonly OrderService $orders,
        private readonly ActivityLogService $activityLog,
    ) {}

    /**
     * @return array<string, float|int>
     */
    public function getStats(): array
    {
        $totalOrders = Order::query()->count();
        $deliveredOrders = Order::query()->where('status', 'delivered')->count();
        $pendingOrders = Order::query()->where('status', 'pending')->count();

        return [
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'totalCustomers' => $this->countTotalCustomers(),
            'completedRevenue' => (float) Order::query()->where('status', 'delivered')->sum('total_amount'),
            'completedOrderCount' => $deliveredOrders,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecentOrders(int $limit = 5): array
    {
        return Order::query()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (Order $order) => $this->orders->formatOrderForAdmin($order))
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getLowStockProducts(int $limit = 5): array
    {
        return \App\Models\Product::query()
            ->where('is_active', true)
            ->where('stock_quantity', '<=', self::LOW_STOCK_THRESHOLD)
            ->orderBy('stock_quantity')
            ->orderBy('name')
            ->limit($limit)
            ->get(['name', 'sku', 'stock_quantity'])
            ->map(fn ($product) => [
                'name' => $product->name,
                'sku' => $product->sku,
                'stock' => $product->stock_quantity,
            ])
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getBestsellers(int $limit = 5): array
    {
        return OrderItem::query()
            ->select([
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as sold'),
                DB::raw('SUM(line_total) as revenue'),
            ])
            ->whereNotNull('product_id')
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('sold')
            ->limit($limit)
            ->get()
            ->map(fn ($row) => [
                'name' => $row->product_name,
                'sold' => (int) $row->sold,
                'revenue' => (float) $row->revenue,
            ])
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecentActivity(int $limit = 20): array
    {
        return $this->activityLog->getRecentForDashboard($limit);
    }

    private function countTotalCustomers(): int
    {
        return (int) Order::query()->distinct()->count('phone');
    }
}
