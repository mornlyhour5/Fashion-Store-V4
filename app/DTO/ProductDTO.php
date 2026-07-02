<?php

namespace App\DTO;

use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly ?int    $category_id,
        public readonly string  $name,
        public readonly ?string $slug        = null,
        public readonly ?float  $base_price  = null,
        public readonly ?string $description = null,
        public readonly ?string $brand       = null,
        public readonly int     $gender      = GenderProduct::UNISEX->value,
        public readonly ?string $image       = null,
        public readonly int     $status      = ProductStatus::ACTIVE->value,
        public readonly ?int    $views_count = null,
    ) {}

    public static function formRequest(Request $request): self
    {
        return new self(
            category_id:  $request->input('category_id')
                            ? (int) $request->input('category_id')
                            : null,
            name:         $request->input('name'),
            slug:         $request->input('slug'),
            base_price:   $request->input('base_price')
                            ? (float) $request->input('base_price')
                            : null,
            description:  $request->input('description'),
            brand:        $request->input('brand'),

            // gender arrives as int string from select ("1","2","3","4")
            gender:       (int) ($request->input('gender') ?? GenderProduct::UNISEX->value),

            image:        $request->input('image'),

            // status arrives as string ('active','inactive') — cast via enum
            status:       ProductStatus::fromString($request->input('status'))
                            ?? ProductStatus::ACTIVE->value,

            views_count:  $request->input('views_count')
                            ? (int) $request->input('views_count')
                            : null,
        );
    }
}
