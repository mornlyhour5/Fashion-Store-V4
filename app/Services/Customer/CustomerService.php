<?php

namespace App\Services\Customer;

use App\Repository\Customer\CustomerRepo;

class CustomerService
{
    public function __construct(protected CustomerRepo $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getAll()
    {
        return $this->customerRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->customerRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'user_id'               => $data['user_id'],
            'full_name'             => $data['full_name'],
            'phone'                 => $data['phone'] ?? null,
            'gender'                => $data['gender'] ?? null,
            'date_of_birth'         => $data['date_of_birth'] ?? null,
            'preferred_language'    => $data['preferred_language'] ?? 'EN',
            'note'                  => $data['note'] ?? null
        ];

        return $this->customerRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $customer = $this->customerRepo->findId($id);

        $data = [
            'user_id'               => $data['user_id'],
            'full_name'             => $data['full_name'],
            'phone'                 => $data['phone'] ?? null,
            'gender'                => $data['gender'] ?? null,
            'date_of_birth'         => $data['date_of_birth'] ?? null,
            'preferred_language'    => $data['preferred_language'] ?? 'EN',
            'note'                  => $data['note'] ?? null
        ];

        return $this->customerRepo->update($customer, $data);
    }

    public function delete($id)
    {
        $customer = $this->customerRepo->findId($id);

        return $this->customerRepo->delete($customer);
    }
}
