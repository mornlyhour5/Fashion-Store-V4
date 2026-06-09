<?php

namespace App\Services\Customer;

use App\Repository\Customer\AddressRepo;

class AddressService
{
    public function __construct(protected AddressRepo $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function getAll()
    {
        return $this->addressRepo->getAll();
    }

    public function getByUserId(int $userId)
    {
        return $this->addressRepo->getByUserId($userId);
    }

    public function getWhereId($id)
    {
        return $this->addressRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'user_id' => $data['user_id'],
            'label' => $data['label'] ?? null,
            'recipient_name' => $data['recipient_name'],
            'phone' => $data['phone'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'] ?? null,
            'city' => $data['city'],
            'province' => $data['province'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'country' => $data['country'] ?? 'KH',
            'is_default' => $data['is_default'] ?? false
        ];

        return $this->addressRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $address = $this->addressRepo->findId($id);
        $data = [
            'user_id' => $data['user_id'],
            'label' => $data['label'] ?? null,
            'recipient_name' => $data['recipient_name'],
            'phone' => $data['phone'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'city' => $data['city'],
            'province' => $data['province'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
            'is_default' => $data['is_default'] ?? false
        ];

        return $this->addressRepo->update($address, $data);
    }

    public function delete($id)
    {
        $address = $this->addressRepo->findId($id);

        return $this->addressRepo->delete($address);
    }
}
