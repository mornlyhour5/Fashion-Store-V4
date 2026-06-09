<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService)
    {
        $this->addressService = $addressService;
    }



    public function index(Request $request)
{
    try {
        $userId    = $request->user()->id;
        $addresses = $this->addressService->getByUserId($userId);

        return response()->json([
            'message' => 'Addresses retrieved successfully',
            'data'    => $addresses
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}

// ✅ Get ONE address by ID
public function show(Request $request, $id)
{
    try {
        $address = $this->addressService->getWhereId($id);

        return response()->json([
            'message' => 'Address retrieved successfully',
            'data'    => $address
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}


//  public function getAddressBySession(Request $request)
//     {
//         $address = \App\Models\Addresses::where('user_id', $request->user()->id)->first();
//         // $address = \App\Models\Addresses::all();

//         if (!$address) {
//             return response()->json([
//                 'message' => 'Address not found'
//             ], 404);
//         }

//         return response()->json($address);
//     }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'user_id'         => 'required|exists:users,id',
                'label'           => 'nullable|string|max:255',
                'recipient_name'  => 'required|string|max:255',
                'phone'           => 'required|string|max:20',
                'address_line1'   => 'required|string',
                'address_line2'   => 'nullable|string',
                'city'            => 'required|string|max:255',
                'province'        => 'nullable|string|max:255',
                'postal_code'     => 'nullable|string|max:20',
                'country'         => 'nullable|string|max:10',
            ]);

            $address = $this->addressService->create($request->all());

            return response()->json([
                'message' => 'Data address create successfully',
                'data' => $address
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'user_id'         => 'required|exists:users,id',
                'label'           => 'nullable|string|max:255',
                'recipient_name'  => 'required|string|max:255',
                'phone'           => 'required|string|max:20',
                'address_line1'   => 'required|string',
                'address_line2'   => 'nullable|string',
                'city'            => 'required|string|max:255',
                'province'        => 'nullable|string|max:255',
                'postal_code'     => 'nullable|string|max:20',
                'country'         => 'nullable|string|max:10',
                'is_default'      => 'nullable|boolean',
            ]);

            $address = $this->addressService->update($request->all(), $id);

            return response()->json([
                'message' => 'Data address update successfully',
                'data' => $address
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $address = $this->addressService->delete($id);

            return response()->json([
                'message' => 'Data address delete successfully',
                'data' => $address
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
