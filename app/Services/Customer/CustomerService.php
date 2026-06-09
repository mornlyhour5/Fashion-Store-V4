<?php

namespace App\Services\Customer;

use App\Repository\Customer\CustomerRepo;
use App\Repository\Auth\RegisterRepo;
// use App\DTO\CreateUserDto;
// use Illuminate\Support\Facades\DB;
use App\Enums\Gender;
use App\Enums\Language;

class CustomerService
{
    public function __construct(
        protected CustomerRepo $customerRepo,
        protected RegisterRepo $registerRepo)
    {
        $this->customerRepo = $customerRepo;
        $this->registerRepo = $registerRepo;
    }

    public function getAll()
    {
        return $this->customerRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->customerRepo->findId($id);
    }

    public function register(array $data)
{
    return $this->customerRepo->create([
        'user_id'            => $data['user_id'],
        'full_name'          => null,
        'phone'              => $data['phone'] ?? null,
        'gender'             => isset($data['gender'])
                                    ? Gender::from($data['gender'])
                                    : null,
        'date_of_birth'      => $data['date_of_birth'] ?? null,
        'preferred_language' => Language::from($data['preferred_language'] ?? Language::EN->value),
        'note'               => $data['note'] ?? null,
    ]);
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
