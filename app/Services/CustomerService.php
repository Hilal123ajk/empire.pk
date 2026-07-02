<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;

class CustomerService
{
    /**
     * Guest customers derived from checkout orders (grouped by phone).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getCustomersForAdmin(): array
    {
        $orders = Order::query()
            ->orderByDesc('created_at')
            ->get([
                'id',
                'first_name',
                'last_name',
                'phone',
                'email',
                'city',
                'total_amount',
                'status',
                'created_at',
            ]);

        return $orders
            ->groupBy('phone')
            ->map(function ($phoneOrders, string $phone) {
                /** @var \Illuminate\Support\Collection<int, Order> $phoneOrders */
                $latest = $phoneOrders->first();
                $firstOrderAt = $phoneOrders->min('created_at');

                return [
                    'id' => md5($phone),
                    'name' => trim("{$latest->first_name} {$latest->last_name}"),
                    'email' => $latest->email ?: '—',
                    'phone' => $phone,
                    'city' => $latest->city,
                    'orders' => $phoneOrders->count(),
                    'spent' => (float) $phoneOrders
                        ->where('status', '!=', 'cancelled')
                        ->sum('total_amount'),
                    'joined' => $firstOrderAt?->toDateString() ?? now()->toDateString(),
                ];
            })
            ->sortByDesc('spent')
            ->values()
            ->all();
    }
}
