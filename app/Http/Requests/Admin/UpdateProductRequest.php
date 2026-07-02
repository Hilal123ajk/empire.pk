<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    use ValidatesProductUploads;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description' => ['nullable', 'string'],
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image' => $this->imageMimeRules(required: false),
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'has_variants' => ['sometimes', 'boolean'],
        ], $this->galleryRules());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
            'has_variants' => $this->boolean('has_variants'),
            'brand_id' => $this->input('brand_id') ?: null,
        ]);
    }
}
