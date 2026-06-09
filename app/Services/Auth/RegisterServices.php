<?php

namespace App\Services\Auth;

use App\Repository\Auth\RegisterRepo;
// use Illuminate\Support\Facades\Hash;
// use App\Domain\AuthUser;
use App\DTO\CreateUserDto;
use Illuminate\Support\Facades\DB;
use App\Repository\Customer\CustomerRepo;
use App\Enums\Gender;
use App\Enums\Language;

class RegisterServices
{
    public function __construct(
        protected RegisterRepo $registerRepo,
        protected CustomerRepo $customerRepo,
    ) {}

    public function register(CreateUserDto $dto): array
    {
        return DB::transaction(function () use ($dto) {

            // Step 1: Create user
            $user = $this->registerRepo->create($dto);

            // Step 2: Auto-create customer profile
            $customer = $this->customerRepo->create([
                'user_id'            => $user->id,
                'full_name'          => $dto->name,
                'phone'              => $dto->phone ?? null,
                'gender'             => isset($dto->gender)
                                            ? Gender::from($dto->gender)
                                            : null,
                'date_of_birth'      => $dto->date_of_birth ?? null,
                'preferred_language' => Language::from($dto->preferred_language ?? Language::EN->value),
                'note'               => $dto->note ?? null,
            ]);

            return compact('user', 'customer');
        });
    }
}
