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

        $eligibleSubtotal = 0.0;

        foreach ($items as $item) {
            $category = $item['category'] ?? null;

            if (! self::isEligibleCategory($category)) {
                continue;
            }

            $eligibleSubtotal += (float) $item['price'] * (int) $item['quantity'];
        }

        $minimum = (float) config('empire.free_delivery_minimum', 2500);

        if ($eligibleSubtotal >= $minimum) {
            return 0.0;
        }

        return (float) config('empire.standard_delivery_fee', 199);
    }

    public static function isEligibleCategory(?string $slug): bool
    {
        if ($slug === null || $slug === '') {
            return false;
        }

        $slug = strtolower($slug);

        if (in_array($slug, config('empire.free_delivery_category_slugs', []), true)) {
            return true;
        }

        foreach (config('empire.free_delivery_category_patterns', []) as $pattern) {
            if (str_contains($slug, strtolower((string) $pattern))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<string, mixed>
     */
    public static function frontendConfig(): array
    {
        return [
            'minimum' => (int) config('empire.free_delivery_minimum', 2500),
            'fee' => (int) config('empire.standard_delivery_fee', 199),
            'categorySlugs' => config('empire.free_delivery_category_slugs', []),
            'categoryPatterns' => config('empire.free_delivery_category_patterns', []),
        ];
    }
}
