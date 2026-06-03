<?php

namespace App\Http\Controllers;


use App\Models\Products;
use App\Services\Order\MainOrderServices;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(protected MainOrderServices $mainOrderServices)
    {
        $this->mainOrderServices = $mainOrderServices;
    }
    public function index()
    {
        $product = Products::with(['variants', 'images'])->get();

        return view('index', compact('product'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    // public function store(Request $request)
    // {
    //     try{
    //         $request->validate([
    //             //------------------------------------------------------------------------
    //             //                          Data validate for order
    //             //------------------------------------------------------------------------
    //             // 'user_id' => 'required|exists:users,id',
    //             'address_id' => 4, // 'address_id' => 'required|exists:addresses,id', --- IGNORE ---
    //             // 'order_number' => ' Data auto put in service '
    //             'product_id' => 'required|exists:products,id',
    //             'shipping_fee' => 'nullable|numeric|min:0',
    //             'discount' => 'nullable|numeric|min:0',
    //             'payment_method' => 'required|string|max:255',
    //             'payment_status' => 'nullable|string|max:255',
    //             'order_status' => 'nullable|string|max:255',
    //             'shipping_address' => 'required|string|max:255',
    //             'note' => 'nullable|string',
    //             //------------------------------------------------------------------------
    //             //                          Data validate for order items
    //             //------------------------------------------------------------------------
    //             // 'order_id' => 'required|exists:orders,id',
    //             'product_variant_id' => 'required|exists:product_variants,id',
    //             'quantity' => 'required|integer|min:1',
    //             // 'price' => 'required|numeric|min:0',
    //         ]);

    //         return $this->mainOrderServices->create($request->all());

    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }



    // }

    public function store(Request $request)
{
    try {

        $validated = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',

            'product_variant_id' => 'required|array',
            'product_variant_id.*' => 'exists:product_variants,id',

            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',

            'payment_method' => 'required|string|max:255',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        $items = [];

        foreach ($request->product_id as $index => $productId) {
            $items[] = [
                'product_id' => $productId,
                'product_variant_id' => $request->product_variant_id[$index],
                'quantity' => $request->quantity[$index],
            ];
        }

        $data = [
            'address_id' => 4,
            'payment_method' => $request->payment_method,
            'shipping_address' => "Street B, Home 16",
            'shipping_fee' => 5,
            'items' => $items,
        ];

        return $this->mainOrderServices->create($data);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ]);
    }
}
}
