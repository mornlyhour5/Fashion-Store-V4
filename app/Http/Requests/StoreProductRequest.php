<?php

namespace App\Http\Requests;

use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            //'slug'        => 'required|string|max:150|unique:products,slug',
            'description' => 'nullable|string|max:500',
            'brand'       => 'nullable|string|max:50',
            'base_price'  => 'required|numeric|min:0',
            'gender'      => 'required|numeric' ?? GenderProduct::UNISEX->value,
            'status'      => 'required|numeric' ?? ProductStatus::ACTIVE->value,
            'image'       => 'nullable|string|max:1000',
            'views_count' => 0

        ];
    }

    public function message(): array
    {
        return [
            'name.required'       => 'Product name is required.',
            'base_price.required' => 'Price is required.',
            'base_price.min'      => 'Price must be greater than zero.'
        ];
    }
}
