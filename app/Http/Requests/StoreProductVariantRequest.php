<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id'            => 'required|exists:products,id',
            'sku'                   => 'required|string|max:150',
            'color'                 => 'required|string|max:50',
            'size'                  => 'required|string|max:20',
            'price'                 => 'required|numeric|min:0',
            'stock'                 => 'required|integer|min:0',
            'low_stock_threshold'   => 'required|integer|min:0',
            'image'                 => 'nullable|string|max:1000',
        ];
    }

    public function message(): array
    {
        return [
            'sku.required'              => 'Sku is required',
            'color.required'            => 'Color is required',
            'size.required'             => 'Size is required',
            'price.required'            => 'Price is required',
            'price.min'                 => 'Price must be greater than zero.',
            'stock.required'            => 'Stock is required',
            'stock.min'                 => 'Stock must be zero or greater.',
            'low_stock_threshold.required' => 'Low stock threshold is required',
            'low_stock_threshold.min'      => 'Low stock threshold must be zero or greater.',
        ];
    }
}
