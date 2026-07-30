<?php

namespace App\Services\Auth;

use App\Enums\NotificationType;
use App\Enums\Role;
use App\Helpers\CustomValidator;
use App\Models\User;
use App\Repository\Contracts\AuthRepository;
use App\Repository\Contracts\NotificationRepository;
use Illuminate\Http\Request;
use App\Services\Contracts\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService
//  implements AuthService
{
    public function __construct(
        protected AuthRepository $authRepository,
        protected NotificationRepository $notification,
        protected CustomValidator $validator
    ) {}

    private function notificationValidate(array $data)
    {
        $rules = [
            'user_id' => 'nullable',
            'type'    => 'nullable',
            'title'   => 'nullable',
            'body'    => 'nullable',
            'data'    => 'nullable',
        ];
        return $this->validator->validate($data, $rules);
    }

    public function register(Request $request): array
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => \App\Enums\Role::CUSTOMER,
        ]);

        // Find all admins
        // use App\Enums\Role;

        $receivers = User::whereIn('role', [
            Role::ADMIN,
            Role::STAFF,
        ])->get();

        foreach ($receivers as $receiver) {
            $this->notification->create([
                'user_id' => $receiver->id,
                'type'    => NotificationType::USER_REGISTERED->value,
                'title'   => 'New Customer Registered',
                'body'    => "{$user->name} has created a new account.",
                'data'    => json_encode([
                    'customer_id'    => $user->id,
                    'customer_name'  => $user->name,
                    'customer_email' => $user->email,
                ]),
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (!$token = Auth::guard('api')->attempt($attemptCredentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user = Auth::guard('api')->user();

        $blockedMessages = [
            \App\Enums\AccountStatus::SUSPENDED->value => 'Your account has been suspended. Contact support for assistance.',
            \App\Enums\AccountStatus::BANNED->value => 'Your account has been banned.',
            \App\Enums\AccountStatus::LOCKED->value => 'Your account is locked. Contact support to regain access.',
            \App\Enums\AccountStatus::DEACTIVATED->value => 'Your account has been deactivated. Contact support to reactivate.',
        ];

        if ($user->status && isset($blockedMessages[$user->status->value])) {
            Auth::guard('api')->logout();
            throw ValidationException::withMessages([
                'email' => [$blockedMessages[$user->status->value]],
            ]);
        }

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
