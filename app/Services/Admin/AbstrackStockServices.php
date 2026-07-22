<?php

namespace App\Services\Admin;

use App\Enums\StockActionType;
use App\Enums\StockEvent;
use App\Exceptions\ValidationExcept;
use App\Repository\Contracts\AddressRepository;
use App\Repository\Contracts\ProductRepository;
// use App\Repository\Contracts\ProductRepository;
use App\Repository\Contracts\ProductVariantRepository;
use App\Repository\Contracts\StockMovementRepository;
use Illuminate\Support\Facades\DB;

abstract class AbstrackStockServices
{
    protected StockMovementRepository $stockMovementRepository;

    public function __construct(
        protected ProductVariantRepository $productVariantRepository,
        protected ProductRepository $productRepository,
        protected AddressRepository $addressRepository
    ){
        $this->stockMovementRepository = app(StockMovementRepository::class);
    }

    protected function apply(
        int $productId,
        int $variantId,
        int $locationId,
        float $stockafter,
        float $stockbefore,
        float $convertedQty,
        string $color,
        float $unit_price,
        string $size,
        string $sku,
        string $note,
        StockEvent $event
    ): void {
        $operation = $event->action();

        DB::transaction(function () use (
            $productId,
            $variantId,
            $locationId,
            $operation,
            $sku,
            $color,
            $unit_price,
            $size,
            $convertedQty,
            $stockafter,
            $note,
            $stockbefore,
            $event
        ) {
            $variant = $this->productVariantRepository->query()->lockForUpdate()
                ->where('id', $variantId)
                ->where('product_id', $productId)
                ->first();
            if(!$variant) {
                if ($operation !== StockActionType::ADD) {
                    throw new ValidationExcept('Variant not found');
                }

                $variant = $this->productVariantRepository->create([
                    'product_id' => $productId,
                    'sku' => $sku,
                    'color' => $color,
                    'size' => $size,
                    'unit_price' => $unit_price,
                    'stock' => 0,
                    'low_stock_threshold' => 5,
                    'quantity' => 0,
                ]);
            }

            if ($operation === StockActionType::DEDUCT && $variant->quantity < $convertedQty){
                throw new ValidationExcept('Insufficient stock');
            }

            $variant->quantity += ($operation === StockActionType::ADD) ? $convertedQty : + $convertedQty;
            $variant->save();
            $stockafter = $stockbefore - $convertedQty;

            $this->stockMovementRepository->create([
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'action' => $event->value,
                'quantity' => $convertedQty,
                'stock_before' => $stockbefore,
                'stock_after' => $stockafter,
                'reference_id' => $stockafter,
                'action_uid' => now(),
                'location_id' => $locationId,
                'note' => $note,
                // 'meta' =>
            ]);
        });
    }
}
