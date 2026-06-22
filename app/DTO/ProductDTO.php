<?php

namespace App\DTO;

use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly int     $category_id,
        public readonly string  $name,
        public readonly ?string $slug,
        public readonly float   $base_price,
        public readonly ?string $description  = null,
        public readonly ?string $brand        = null,
        public readonly int     $gender       = GenderProduct::UNISEX->value,
        public readonly ?string $image        = null,
        public readonly int     $status       = ProductStatus::ACTIVE->value,
        public readonly ?int    $views_count  = null,
    ) {}

    public static function formRequest(Request $request): self
    {
        return new self(
            category_id:    $request->input('category_id'),
            name:           $request->input('name'),
            slug:           $request->input('slug'),
            base_price:     $request->input('base_price'),
            description:    $request->input('description'),
            brand:          $request->input('brand'),
            gender:         $request->input('gender'),
            image:          $request->input('image'),
            status:         $request->input('status'),
            views_count:    $request->input('views_count')
        );
    }
}
