<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
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
            'product_id'         => 'required|exists:products,id',
            'image_url'          => 'required|string|max:1000',
            'is_main'            => 'nullable',
            'sort_order'         => 'required|integer|min:0',
            'product_variant_id' => 'nullable|exists:product_variants,id'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.exists'   => 'The specified product does not exist.',
            'image_url.required'  => 'Image URL is required.',
            'is_main.required'    => 'Is Main field is required.',
            'is_main.boolean'     => 'Is Main field must be a boolean value.',
            'sort_order.required' => 'Sort Order is required.',
            'sort_order.integer'  => 'Sort Order must be an integer.',
            'sort_order.min'      => 'Sort Order must be at least 0.',
            'product_variant_id.exists' => 'The specified product variant does not exist.'
        ];
    }
}
