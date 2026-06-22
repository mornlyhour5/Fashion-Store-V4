<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id'         => $this->product_id,
            'image_url'          => $this->image_url,
            'is_main'            => $this->is_main,
            'sort_order'         => $this->sort_order,
            'product_variant_id' => $this->product_variant_id
        ];
    }
}
