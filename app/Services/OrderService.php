<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function createFromCheckout(array $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $subtotal = 0.0;
            $lineItems = [];

            foreach ($data['items'] as $item) {
                $product = Product::query()
                    ->where('id', $item['product_id'])
                    ->where('is_active', true)
                    ->firstOrFail();

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \InvalidArgumentException("Insufficient stock for {$product->name}.");
                }

                $variantLabel = null;
                $variantImageUrl = null;
                $productImageId = null;

                if (! empty($item['variant_image_id'])) {
                    $image = ProductImage::query()
                        ->where('id', $item['variant_image_id'])
                        ->where('product_id', $product->id)
                        ->firstOrFail();

                    $variantLabel = $image->label;
                    $variantImageUrl = $image->image_public_url;
                    $productImageId = $image->id;
                } else {
                    $variantImageUrl = $product->image_public_url;
                    $variantLabel = 'Main';
                }

                $unitPrice = (float) $product->price;
                $quantity = (int) $item['quantity'];
                $lineTotal = $unitPrice * $quantity;
                $subtotal += $lineTotal;

                $lineItems[] = [
                    'product_id' => $product->id,
                    'product_image_id' => $productImageId,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'variant_label' => $variantLabel,
                    'variant_image_url' => $variantImageUrl,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                    'stock_product_id' => $product->id,
                    'stock_quantity' => $quantity,
                ];
            }

            $deliveryFee = $subtotal >= 2500 ? 0.0 : ($subtotal > 0 ? 199.0 : 0.0);

            $order = Order::query()->create([
                'order_number' => $this->generateOrderNumber(),
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'address' => $data['address'],
                'city' => $data['city'],
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment'],
                'status' => 'pending',
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $subtotal + $deliveryFee,
            ]);

            foreach ($lineItems as $lineItem) {
                $stockProductId = $lineItem['stock_product_id'];
                $stockQuantity = $lineItem['stock_quantity'];
                unset($lineItem['stock_product_id'], $lineItem['stock_quantity']);

                $order->items()->create($lineItem);

                Product::query()
                    ->where('id', $stockProductId)
                    ->decrement('stock_quantity', $stockQuantity);
            }

            return $order->load('items');
        });
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getOrdersForAdmin(): array
    {
        return Order::query()
            ->with('items')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Order $order) => $this->formatOrderForAdmin($order))
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function formatOrderForAdmin(Order $order): array
    {
        return [
            'id' => $order->order_number,
            'dbId' => $order->id,
            'customer' => $order->customer_name,
            'phone' => $order->phone,
            'email' => $order->email ?? '—',
            'city' => $order->city,
            'address' => $order->address,
            'notes' => $order->notes,
            'items' => $order->items->sum('quantity'),
            'total' => (float) $order->total_amount,
            'subtotal' => (float) $order->subtotal,
            'deliveryFee' => (float) $order->delivery_fee,
            'status' => $order->status,
            'payment' => strtoupper($order->payment_method),
            'paymentStatus' => $order->payment_status,
            'createdAt' => $order->created_at?->format('M j, Y g:i A') ?? '',
            'lineItems' => $order->items->map(fn ($item) => [
                'name' => $item->product_name,
                'qty' => $item->quantity,
                'price' => (float) $item->unit_price,
                'color' => $item->variant_label,
                'image' => $item->variant_image_url,
                'sku' => $item->product_sku,
            ])->all(),
        ];
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (! in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException('Invalid order status.');
        }

        $order->update(['status' => $status]);

        return $order->fresh(['items']);
    }

    private function generateOrderNumber(): string
    {
        $latestId = (int) Order::query()->max('id');

        return 'EMP-'.str_pad((string) ($latestId + 1), 5, '0', STR_PAD_LEFT);
    }
}
