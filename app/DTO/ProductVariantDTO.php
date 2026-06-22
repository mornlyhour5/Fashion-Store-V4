<?php

namespace App\DTO;

use Illuminate\Http\Request;

class ProductVariantDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $product_id,
        public readonly string $sku,
        public readonly string $color,
        public readonly string $size,
        public readonly float $price,
        public readonly int $stock,
        public readonly int $low_stock_threshold,
        public readonly ?string $image = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            product_id: $request['product_id'],
            sku:        $request['sku'],
            color:      $request['color'],
            size:       $request['size'],
            price:      $request['price'],
            stock:      $request['stock'] ?? 0,
            low_stock_threshold: $request['low_stock_threshold'] ?? 5,
            image:      $request['image'] ?? null
        );
    }
}
