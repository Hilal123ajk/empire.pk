<?php

declare(strict_types=1);

namespace App\Support;

final class DeliveryPolicy
{
    /**
     * @param  array<int, array{price: float|int, quantity: int, category?: string|null}>  $items
     */
    public static function calculateFee(array $items): float
    {
        if ($items === []) {
            return 0.0;
        }

        return (float) config('empire.standard_delivery_fee', 199);
    }

    /**
     * @return array<string, mixed>
     */
    public static function frontendConfig(): array
    {
        return [
            'fee' => (int) config('empire.standard_delivery_fee', 199),
        ];
    }
}
