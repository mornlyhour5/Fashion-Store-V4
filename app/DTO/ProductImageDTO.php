<?php

namespace App\DTO;

use Illuminate\Http\Request;

class ProductImageDTO
{
    public function __construct(
        public readonly int     $product_id,
        public readonly string  $image_url,
        public readonly string  $is_main,
        public readonly int     $sort_order,
        public readonly int     $product_variant_id
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            product_id:          $request->input('product_id'),
            image_url:           $request->input('image_url'),
            is_main:             $request->input('is_main'),
            sort_order:          $request->input('sort_order'),
            product_variant_id:  $request->input('product_variant_id')
        );
    }

}
