<?php

declare(strict_types=1);

namespace App\Http\Requests\Store;

use App\Models\ProductImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreCheckoutRequest extends FormRequest
{
    private const ALLOWED_CITIES = [
        'Lahore',
        'Islamabad',
        'Rawalpindi',
        'Karachi',
        'Faisalabad',
        'Multan',
        'Sialkot',
        'Gujranwala',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => $this->sanitizeString($this->input('first_name')),
            'last_name' => $this->sanitizeString($this->input('last_name')),
            'phone' => $this->normalizePakistaniPhone($this->input('phone', '')),
            'email' => $this->sanitizeString($this->input('email')),
            'address' => $this->sanitizeString($this->input('address')),
            'city' => $this->sanitizeString($this->input('city')),
            'notes' => $this->sanitizeString($this->input('notes')),
            'payment' => $this->sanitizeString($this->input('payment')),
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\-\'.]+$/u'],
            'last_name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\-\'.]+$/u'],
            'phone' => ['required', 'string', 'regex:/^03[0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'min:10', 'max:500', 'regex:/^[\p{L}\p{N}\s,\-.\/#]+$/u'],
            'city' => ['required', 'string', Rule::in(self::ALLOWED_CITIES)],
            'notes' => ['nullable', 'string', 'max:1000', 'regex:/^[\p{L}\p{N}\s,\-.\/#!?]*$/u'],
            'payment' => ['required', 'in:cod'],
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(function ($query): void {
                    $query->where('is_active', true)->whereNull('deleted_at');
                }),
            ],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'items.*.variant_image_id' => ['nullable', 'integer', 'exists:product_images,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $address = (string) $this->input('address', '');
            $wordCount = count(preg_split('/\s+/u', trim($address), -1, PREG_SPLIT_NO_EMPTY) ?: []);

            if ($wordCount < 4) {
                $validator->errors()->add(
                    'address',
                    'Please enter a complete address with at least 4 words (e.g. Chak 12, Tehsil Kasur, District Kasur, Lahore).'
                );
            }

            $items = $this->input('items', []);

            if (! is_array($items)) {
                return;
            }

            $lineKeys = [];

            foreach ($items as $index => $item) {
                if (! is_array($item)) {
                    $validator->errors()->add('items', 'Invalid cart item payload.');

                    return;
                }

                if (array_key_exists('price', $item) || array_key_exists('unit_price', $item) || array_key_exists('total', $item)) {
                    $validator->errors()->add('items', 'Cart prices are calculated on the server.');

                    return;
                }

                $productId = $item['product_id'] ?? null;
                $variantImageId = $item['variant_image_id'] ?? null;
                $lineKey = $productId.':'.($variantImageId ?? 'default');

                if (in_array($lineKey, $lineKeys, true)) {
                    $validator->errors()->add('items', 'Duplicate cart lines are not allowed.');

                    return;
                }

                $lineKeys[] = $lineKey;

                if ($variantImageId === null) {
                    continue;
                }

                $ownsVariant = ProductImage::query()
                    ->where('id', $variantImageId)
                    ->where('product_id', $productId)
                    ->exists();

                if (! $ownsVariant) {
                    $validator->errors()->add(
                        "items.{$index}.variant_image_id",
                        'The selected product variant is invalid.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Enter a valid Pakistani mobile number (e.g. 03001234567).',
            'address.required' => 'Delivery address is required.',
            'address.regex' => 'Address contains invalid characters.',
            'city.required' => 'City is required.',
            'city.in' => 'Please select a valid delivery city.',
            'items.required' => 'Your cart is empty.',
            'items.max' => 'Too many items in one order.',
        ];
    }

    private function sanitizeString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $clean = trim(strip_tags($value));
        $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $clean) ?? '';

        return $clean === '' ? null : $clean;
    }

    private function normalizePakistaniPhone(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value) ?? '';

        if (str_starts_with($digits, '92') && strlen($digits) === 12) {
            $digits = '0'.substr($digits, 2);
        }

        if (str_starts_with($digits, '3') && strlen($digits) === 10) {
            $digits = '0'.$digits;
        }

        return $digits === '' ? null : $digits;
    }
}
