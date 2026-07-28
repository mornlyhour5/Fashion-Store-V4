<?php

namespace App\Services\Customer;

use App\Enums\AccountStatus;
use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Repository\Contracts\CustomerProfileRepository;
use App\Repository\Contracts\CustomerRepository;
use App\Repository\Contracts\UserRepository;
use App\Services\Contracts\CustomerService;
use Illuminate\Http\UploadedFile;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class CustomerServiceImpl implements CustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerProfileRepository $customerProfileRepository,
        protected UserRepository $userRepository,
        protected CustomValidator $validator
    ) {}

    private function userValidator(array $data): array
    {
        $rules = [
            'avata'  => 'nullable',
            'status' => ['required', new Enum(AccountStatus::class)],
            'reason' => ['nullable', 'string', 'max:500'],
        ];

        return $this->validator->validate($data, $rules);
    }

    public function customerProfile(int $id)
    {
        $id = Auth::guard('api')->id();
        return $this->customerRepository->findById(
            $id,
            select: [
                'user_id',
                'first_name',
                'last_name',
                'phone',
                'gender',
                'date_of_birth',
                'preferred_language',
                'note'
            ]);
    }

    public function userProfile(int $id)
    {
        $id = Auth::guard('api')->id();

        return $this->userRepository->findById(
            $id,
            select: [
                'name',
                'email',
                'password',
                'avata',
                'status',
                'role'
            ]);
    }

    public function getAllcustomer() //get customer from table user where role customer
    {
        return $this->customerRepository->getAll();
    }

    public function getAllUser(array $filters = []) // get data from repisitory customer where role
    {
        return $this->userRepository->getUser($filters);// get user only where role customer
    }

    public function customerProfileDetail(int $id)
    {
        return $this->customerProfileRepository->findByUserId($id);
    }

    public function getAllStaff(array $filters = []) // get data from repisitory staff where role
    {
         return $this->customerRepository->getStaff();
    }

    public function updateProfile(int $id, array $data)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new NotFoundExcept(__('messages.not_found', ['info' => 'general.user']));
        }

        $rules = [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'preferred_language' => ['nullable', 'string', 'max:10'],
        ];

        $validated = $this->validator->validate($data, $rules);

        return DB::transaction(function () use ($id, $validated) {
            return $this->customerRepository->updateProfileByUserId($id, $validated);
        });
    }

    public function updateAvatar(int $id, UploadedFile $avatarFile)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new NotFoundExcept(__('messages.not_found', ['info' => 'general.user']));
        }

        $oldAvatar = $user->userProfile->avata ?? null;

        if (!empty($oldAvatar)) {
            HelperMedia::deleteUploadedFile(
                'image',
                ImageBuket::USER->value,
                ImageDirectory::AVATAR->value,
                $oldAvatar
            );
        }

        $result = HelperMedia::saveUploadedFile(
            $avatarFile,
            'image',
            ImageBuket::USER->value,
            ImageDirectory::AVATAR->value
        );

        return DB::transaction(function () use ($id, $result) {
            return $this->userRepository->updateProfileByUserId($id, [
                'avata' => $result->filename ?? null,
            ]);
        });
    }

    public function getUserById(int $id)
    {
        $user = $this->userRepository->findByIduser($id, with: ['customerProfile']);

        if (!$user) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.user.customer'
            ]));
        }

        return $user;
    }

    public function updatecustomerStatus(array $data, int $id)
    {
        $validated = $this->userValidator($data);

        $customer = $this->userRepository->findById($id);

        if (!$customer) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.user.customer'
            ]));
        }

        $newStatus = AccountStatus::from((int) $validated['status']);

        if (!in_array($newStatus, AccountStatus::adminAssignable(), true)) {
            throw new \InvalidArgumentException('That status cannot be set manually.');
        }

        $adminId = Auth::guard('api')->id();

        $blockingStatuses = [
            AccountStatus::SUSPENDED,
            AccountStatus::BANNED,
            AccountStatus::LOCKED,
            AccountStatus::DEACTIVATED,
        ];

        if ($customer->id === $adminId && in_array($newStatus, $blockingStatuses, true)) {
            throw new \InvalidArgumentException('You cannot disable your own account.');
        }

        return DB::transaction(function () use ($id, $newStatus) {
            return $this->userRepository->updateById($id, [
                'status' => $newStatus,
            ]);
        });
    }
}
