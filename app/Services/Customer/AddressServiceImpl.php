<?php

namespace App\Services\Customer;


use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Repository\Contracts\AddressRepository;
use App\Services\Contracts\AddressService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Override;

class AddressServiceImpl implements AddressService
{
    public function __construct(
        protected AddressRepository $addressRepository,
        protected CustomValidator $validator
    ) {}

    private function AddressValidator(array $data)
    {
        $rules = [
            'user_id' => 'nullable',
            'label'   => 'nullable',
            'recipient_name' => 'nullable',
            'phone'   => 'nullable',
            'address' => 'nullable',
            'city'    => 'nullable',
            'province' => 'nullable',
            'postal_code' => 'nullable',
            'country' => 'nullable',
            'is_default' => 'nullable'
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAddressByUserId()
    {
        $userId = Auth::guard('api')->id();
        return $this->addressRepository->findByUserId($userId);
    }

    // #[Override]
    public function getAddressAdmin(Request $request)
    {
        return $this->addressRepository->getAll();
    }

    public function getAddress(Request $request)
    {
        $userId = Auth::guard('api')->id();

        if (!$userId) {
            throw new \App\Exceptions\UnauthExcept();
        }

        return $this->addressRepository->pagination(
            fileters: $request->all(),
            conditions: ['user_id' => $userId],
            limit: (int) $request->input('per_page', 20),
            rawSort: $request->input('sort', '-created_at'),
        );
    }

    // public function getAddressById(array $data, int $id): mixed
    // {
    //     $address = $this->addressRepository->findById($id, select: ['id', 'recipient_name', 'country']);

    //     if (!$address) {
    //         throw new NotFoundExcept(__('message.not_found', [
    //             'info' => __('general.address')
    //         ]));
    //     }

    //     return $address;
    // }

    public function create(Request $request): Model
    {
        $data = $request->all();

        if (empty($data['user_id'])) {
            $data['user_id'] = Auth::guard('api')->id();
        }

        $validated = $this->AddressValidator($data);

        return $this->addressRepository->create($validated);
    }

    public function update(Request $request, int $id): mixed
    {
        // $address = $this->addressRepository->findById($id);
        $validated = $this->AddressValidator($request->all());

        return $this->addressRepository->updateById($id, $validated);
    }

    public function delete(int $id): void
    {
        $address = $this->addressRepository->findById($id);

        if(!$address) {
            throw new NotFoundExcept(__('message.not_found', [
                'info' => __('general.address')
            ]));
        }

        $this->addressRepository->deleteById($id);
    }



    //this admin service


}
