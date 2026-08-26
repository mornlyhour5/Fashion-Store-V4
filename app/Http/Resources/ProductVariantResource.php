<?php

namespace App\Http\Resources;

use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Helpers\HelperMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'sku'        => $this->sku,
            'color'      => $this->color,
            'size'       => $this->size,
            'unit_price' => $this->unit_price,
            'quantity'   => $this->quantity,
            'status'     => $this->status,
            'images'     => $this->whenLoaded('images', fn() => $this->images->map(fn($img) => [
                'id'      => $img->id,
                'is_main' => $img->is_main,
                'url'     => HelperMedia::getImageUrl(
                    ImageBuket::COMPANY->value,
                    ImageDirectory::PRODUCT->value,
                    $img->image
                ),
            ])),
        ];
    }
}
