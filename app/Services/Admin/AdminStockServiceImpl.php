<?php

namespace App\Services\Admin;

use App\Enums\StockEvent;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Repository\Contracts\AddressRepository;
use App\Repository\Contracts\ProductRepository;
use App\Repository\Contracts\ProductVariantRepository;
use App\Services\Contracts\AdminStockService;

class AdminStockServiceImpl extends AbstrackStockServices implements AdminStockService
{
    protected array $stockActions = [

    ];

    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        AddressRepository $addressRepository,

        protected CustomValidator $validator
    ) {
        parent::__construct(
            $productVariantRepository,
            $productRepository,
            $addressRepository
        );
    }

    public function receivePurchaseItem(
        int $productId,
        int $variantId,
        int $addressId,
        float $stockafter,
        float $stockbefore,
        float $unit_price,
        string $size,
        string $color,
        float $qty,
        ?string $sku,
        ?string $note,
        ?array $meta = [],
    ): void //add product to stockv
    {
        $products = $this->productRepository->findById($productId);
        if ($products) {
            $products->load('id');
        }
        $address = $this->addressRepository->findById($addressId);
        if ($address) {
            $address->load('user');
        }
        $this->apply(
            productId: $productId,
            variantId: $variantId,
            locationId: $addressId,
            stockafter: $stockafter,
            stockbefore: $stockbefore,
            convertedQty: $qty,
            color: $color,
            unit_price: $unit_price,
            size: $size,
            sku: $sku,
            note: $note,
            event:StockEvent::RECEIVE_PO_ITEM,
        );
    }

    public function reverseReceivePurchaseItem(
        int $productId,
        int $variantId,
        int $addressId,
        float $stockafter,
        float $stockbefore,
        float $unit_price,
        string $size,
        string $color,
        float $qty,
        ?string $sku,
        ?string $note,
        ?array $meta = [],
    ): void // sell product
    {
        $variant = $this->productVariantRepository->findById($variantId);
        if (!$variant) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.product.variants'
            ]));
        }
        $variant->load('id');
        $this->apply(
            productId: $productId,
            variantId: $variantId,
            locationId: $addressId,
            stockafter: $stockafter,
            stockbefore: $stockbefore,
            convertedQty: $qty,
            color: $color,
            unit_price: $unit_price,
            size: $size,
            sku: $sku,
            note: $note,
            event:StockEvent::TRANSFER_IN,
        );


    }

    public function initialStock(
        int $productId,
        int $variantId,
        int $addressId,
        float $stockafter,
        float $stockbefore,
        float $unit_price,
        string $size,
        string $color,
        float $qty,
        ?string $sku,
        ?string $note,
        ?array $meta = [],
    ) //add new product don't have in stock
    {
        $variant = $this->productVariantRepository->findById($variantId);
        $this->apply(
            productId: $productId,
            variantId: $variantId,
            locationId: $addressId,
            stockafter: $stockafter,
            stockbefore: $stockbefore,
            convertedQty: $qty,
            color: $color,
            unit_price: $unit_price,
            size: $size,
            sku: $sku,
            note: $note,
            event:StockEvent::INITIAL_QTY,
        );
    }

    public function deductStock( //decrease stock
        int $productId,
        int $variantId,
        int $addressId,
        float $stockafter,
        float $stockbefore,
        float $unit_price,
        string $size,
        string $color,
        float $qty,
        ?string $sku,
        ?string $note,
        ?array $meta = [],
    ): void {

    $product = $this->productRepository->findById($productId);
    if($product){
        $product->load('id');
    }

    $variant = $this->productVariantRepository->findById($variantId);
    if($variant) {
        $variant->load('product_id');
    }
    $this->apply(
            productId: $productId,
            variantId: $variantId,
            locationId: $addressId,
            stockafter: $stockafter,
            stockbefore: $stockbefore,
            convertedQty: $qty,
            color: $color,
            unit_price: $unit_price,
            size: $size,
            sku: $sku,
            note: $note,
            event:StockEvent::POS_ORDER,
        );
    }

}
