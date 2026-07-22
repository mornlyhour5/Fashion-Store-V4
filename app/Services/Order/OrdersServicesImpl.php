<?php

namespace App\Services\Order;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Exceptions\BadRequestExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Repository\Contracts\AddressRepository;
use App\Repository\Contracts\CouponRepository;
use App\Repository\Contracts\CustomerRepository;
use App\Repository\Contracts\OrderItemRepository;
use App\Repository\Contracts\OrderRepository;
use App\Repository\Contracts\ProductRepository;
use App\Repository\Contracts\ProductVariantRepository;
use App\Services\Contracts\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersServicesImpl implements OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected CustomValidator $validator,

        protected CustomerRepository $customerrepository,
        protected ProductRepository $productrepository,
        protected ProductVariantRepository $productvariantrepository,
        protected AddressRepository $addressrepository,
        protected CouponRepository $couponrepository
        ){}

    private function orderValidator(array $data)
    {
        $rules = [
            'customer_id'  => 'required',
            'order_date'   => 'nullable',


            'subtotal'     => 'nullable',
            'unit_price'   => 'required',
            'total_amount' => 'required',
            'order_status' => 'nullable',
            'payment_status' => 'nullable',
            'payment_method' => 'nullable',
            'shipping_fee' => 'nullable',
            'coupon_id'    => 'nullable',
            'tax'          => 'nullable',
            'shipping_address' => 'nullable',

            'items'                      => 'required|array|min:1',
            'items.*.order_id'           => 'required|integer',
            'items.*.product_variant_id' => 'required|integer',
            'items.*.product_id'         => 'required|integer',
            'items.*.address_id'         => 'required|integer',
            'items.*.quantity'           => 'required',
            'items.*.discount'           => 'nullable|numeric|min:0'

        ];
        return $this->validator->validate($data, $rules);
    }

    public function getOrderForuser(Request $request)
    {
        $userId = Auth::guard('api')->id();

        if (!$userId) {
            throw new \App\Exceptions\UnauthExcept();
        }

        return $this->orderRepository->pagination(
            fileters: $request->all(),
            conditions: ['user_id' => $userId],
            limit: (int) $request->input('per_page', 20),
            rawSort: $request->input('sort', '-created_at'),
        );
    }

    public function getAllOrders(): array
    {
        $orders = $this->orderRepository->findAllWithRelations();

        return $orders->map(function ($order) {
            $profile = $order->customer?->customerProfile;

            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $order->user_id,
                'customer' => $order->customer ? [
                    'id' => $order->customer->id,
                    'name' => $profile
                        ? trim($profile->first_name . ' ' . $profile->last_name)
                        : $order->customer->name,
                    'email' => $order->customer->email,
                    'phone' => $profile->phone ?? null,
                ] : null,
                'items_count' => $order->order_items_count,
                'subtotal' => $order->subtotal,
                'shipping_fee' => $order->shipping_fee,
                'discount' => $order->discount,
                'total_amount' => $order->total_amount,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'order_status' => $order->order_status,
                'created_at' => $order->created_at,
            ];
        })->toArray();
    }

    private function orderNumbergenerate()
    {
        $lastOrder = $this->orderRepository->lastId();
        if($lastOrder) {
            $lastNumber = (int) str_replace('CPS-', '', $lastOrder->order_number);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $orderNumber = 'CPS-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $orderNumber;

    }

    private function collectPrepareItemDistinctKeys(array $items)
    {
        $productIds = [];
        $unitIds = [];
        $variantIds = [];

        $productMap = [];
        $unitMap = [];
        $variantMap = [];

        foreach ($items as $item) {
            $productId = $item['product_id'];
            $unitId = $item['unit_id'];
            $variantId = $item['product_variant_id'];

            if (!isset($productMap[$productId])) {
                $productMap[$productId] = true;
                $productIds[] = $productId;
            }

            if (!isset($unitMap[$unitId])) {
                $unitMap[$unitId] = true;
                $unitIds[] = $unitId;
            }

            if ($variantId !== null && !isset($variantMap[$variantId])) {
                $variantMap[$variantId] = true;
                $variantIds[] = $variantId;
            }
        }
        return [
            $productIds,
            $variantIds,
            $unitIds
        ];
    }

    private function prepareOrderItems(array $items): array
    {
        [$productIds, $variantIds] =
            $this->collectPrepareItemDistinctKeys($items);

        $product = $this->productrepository->query(
            select: ['id', 'name', 'base_price' ]
        )
        ->whereIn('id', $productIds)
        ->whereIn('deleted_at', false)
        ->get()
        ->keyBy(fn($r) => $r->product_id . '-' . $r->product_id);

        if ($product->isEmpty()) {
            throw new BadRequestExcept(__('messages.not_found', [
                'info' => __('general.product')
            ]));
        }

        $variants = $this->productvariantrepository->query(
            select: ['id', 'product_id', 'sku', 'size', 'stock']
        )
        ->whereIn('product_id', $productIds)
        ->whereIn('id', $variantIds)
        ->where('deleted_at', false)
        ->get()
        ->keyBy('id');

        if($variants->isEmpty()) {
            throw new BadRequestExcept(__('messages.not_found', [
                'info' => __('general.product.variant')
            ]));
        }

        $validItems = [];
        $keys = [];

        foreach ($items as $item) {
            $qty = (float) ($item['quantity'] ?? 0);
            if($qty <= 0){
                throw new BadRequestExcept('Quantity must be bigger than 0');
            }
            $variantId = $item['product_variant_id'];
            $unitkey = $item['product_id'];

            if(!isset($variants[$variantId]) || !isset($product[$unitkey])) {
                throw new BadRequestExcept(__('messages.invalid_item'));
            }

            // $variant = $variants[$variantId];
            $salePrice = $variants->unit_price;

            if($salePrice > 0) {
                throw new BadRequestExcept('Price must be greater than 0');
            }
            $product = $product[$unitkey];
            $subtotal = $qty * $item->unit_price;

            $key = implode('-', [
                $variantId,
                $item['product_id'],
                $item['discount'] ?? 0,
            ]);

            if (isset($keys[$key])) {
                $validItems[$key]['quantity'] += $qty;
            } else {
                $validItems[$key] = [
                    'product_id'      => $item['product_id'],
                    'product_variant_id' => $variantId,
                    'quantity'        => $qty,
                    'cost'            => $item['cost'],
                    'unit_price'      => $item['unit_price'],
                    'discount'        => $item['discount'] ?? 0,
                    'subtotal'        => $subtotal,
                ];
                $keys[$key] = true;
            }
        }
        return array_values($validItems);
    }

    public function createOrder(array $data): mixed
    {
        $validated = $this->orderValidator($data);
        // $authUser  = $this->a;

        $customer = $this->customerrepository->findById($validated['customer_id']);
        if (!$customer) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.customer')
            ]));
        }

        $items = $this->prepareOrderItems(
            $validated['items'],
        );

        $subTotal = 0;
        $rows = [];

        foreach ($items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];

            $discountAmount = $lineTotal * ($item['discount'] / 100);
            $netAmount = max(0, $lineTotal - $discountAmount);
            $subTotal += $netAmount;

            $rows[] = [
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'],
                'quantity'   => $item['quantity'],
                'unit_price'      => $item['unit_price'],
                'discount'   => $item['discount'],
                'net_amount' => $netAmount,
                'tax_rate'   => 0,
                'tax_amount' => 0,
                'total'      => $lineTotal,
                'cost'       => $item['cost'],
                'subtotal'   => $lineTotal
            ];
        }

        $orderDiscount = $validated['discount'] ?? 0;
        $orderdiscountAmount = $subTotal * ($orderDiscount / 100);

        $taxRate = (float) ($validated['tax_rate'] ?? 0);
        $taxable = max(0, $subTotal - $orderdiscountAmount);
        $taxAmount = $taxable * ($taxRate / 100);

        $grandTotal = $taxable + $taxAmount;
        // $orderNumber = $this->orderNumbergenerate();

        DB::beginTransaction();
        try {
            unset($validated['items']);
            $validated['user_id']      = auth();
            $validated['address_id']   = $validated['address_id'];
            $validated['order_number'] = $this->orderNumbergenerate();
            $validated['subtotal']     = $subTotal;
            $validated['shipping_fee'] = $validated['shipping_fee'];
            $validated['discount']     = $validated['discount'];
            $validated['total_amount'] = $grandTotal;
            $validated['payment_method'] = $validated['payment_method'] ?? PaymentMethod::KHQR->value;
            $validated['payment_status'] = $validated['payment_status'] ?? PaymentStatus::UNPAID->value;
            $validated['shipping_address'] = $validated['shipping_address'];
            $validated['note'] = $validated['note'];

            $order = $this->orderRepository->create($validated);

            foreach ($rows as $row) {
                $row['order_id'] = $order->id;
            }

            // $this->orderItemRepository->setActingUser($authUser)->bulkInsert($rows);

            // $completed = $validated['']

            // if ($completed) {
            //     foreach ($rows as $row) {
            //         $this->;
            //     }
            // }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof BadRequestExcept) {
                throw new BadRequestExcept($e->getMessage());
            }
            Log::error($e->getMessage());
            throw new BadRequestExcept();
        }
    }
    // public function updateOrderById(array $data, int $id): mixed
    // {
    //     $validated = $this->orderValidator($data);

    //     $old = $this->orderRepository->query()
    //     ->with(['items' => function ($q) {
    //         $q->where('deleted_at', null);
    //     }])
    //     ->where('deleted_at', null)
    //     ->find($id);

    //     if (!$old) {
    //         throw new NotFoundExcept(__('messages.not_found', [
    //             'info' => __('general.product.order')
    //         ]));
    //     }

    //     $customer = $this->customerrepository->findById($validated['customer_id']);
    //     if(!$customer) {
    //         throw new NotFoundExcept(__('messages.not_found', [
    //             'info' => __('general.product.order')
    //         ]));
    //     }


    // }
}
