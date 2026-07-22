<?php

namespace App\Services\Auth;

// use App\DTO\LoginDTO;
// use App\Enums\AccountStatus;
// use App\Enums\Gender;
// use App\Enums\ImageBuket;
// use App\Enums\ImageDirectory;
// use App\Enums\Language;
// use App\Exceptions\UnauthExcept;
// use App\Exceptions\ValidationExcept;
// use App\Helpers\HelperMedia;
// use App\Models\Customers;

// use App\Exceptions\ValidationExcept;

// use App\Enums\Role;
// use App\Http\Controllers\Controller;
// use App\Http\Requests\LoginRequest;
// use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\Contracts\AuthRepository;
use Illuminate\Http\Request;
use App\Services\Contracts\AuthService;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules\Enum;
// use Illuminate\Validation\ValidationException;
// use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService
//  implements AuthService
{
    public function __construct(
        protected AuthRepository $authRepository
    ) {}

    /**
     * Register
     */
    // public function register(Request $request): array
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:8',

    //         'first_name' => 'nullable|string|max:100',
    //         'last_name' => 'nullable|string|max:100',
    //         'phone' => 'nullable|string|max:20',
    //         'gender' => ['nullable', new Enum(Gender::class)],
    //         'date_of_birth' => 'nullable|date',
    //         'preferred_language' => ['nullable', new Enum(Language::class)],
    //         'note' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new ValidationExcept($validator);
    //     }

    //     $data = $validator->validated();

    //     // Fields that belong on the `users` table only
    //     $userData = [
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ];

    //     // Everything else belongs on `customer_profile`
    //     $profileData = collect($data)
    //         ->only(['first_name', 'last_name', 'phone', 'gender', 'date_of_birth', 'preferred_language', 'note'])
    //         ->filter(fn ($value) => $value !== null)
    //         ->toArray();

    //     $user = DB::transaction(function () use ($userData, $profileData) {
    //         $user = $this->authRepository->create($userData);

    //         if (!empty($profileData)) {
    //             Customers::create(array_merge(['user_id' => $user->id], $profileData));
    //         }

    //         return $user;
    //     });

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return [
    //         'user' => $user->load('customerProfile'), // see note below
    //         'token' => $token,
    //     ];
    // }

    // public function login(array $credentials): array
    // {
    //     $validator = Validator::make($credentials, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new ValidationExcept($validator);
    //     }

    //     $user = $this->authRepository->findByEmail($credentials['email']);

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Invalid email or password.']
    //         ]);
    //     }

    //     // optional: delete old tokens so user only keeps one active login
    //     $user->tokens()->delete();

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return [
    //         'user' => $user,
    //         'token' => $token,
    //     ];
    // }

    // public function login(array $credentials): array
    // {
    //     $validator = Validator::make($credentials, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new ValidationExcept($validator);
    //     }

    //     $user = $this->authRepository->findByEmail($credentials['email']);

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Invalid email or password.']
    //         ]);
    //     }

    //     Auth::login($user);

    //     return [
    //         'user' => $user,
    //     ];
    // }

    // public function login(array $credentials): LoginDTO
    // {
    //     $validator = validator($credentials, [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if($validator->fails()) {
    //         throw new UnauthExcept($validator->errors()->first());
    //     }
    //     $inputs = $validator->validate();
    //     $user = $this->authRepository->findByIdWithConditions($inputs['email'], ['*'], [
    //         'active' => AccountStatus::ACTIVE->value,
    //         'deleted_at' => null
    //     ]);

    //     if(!$user){
    //         throw new UnauthExcept(__('validation.invalid_credentials'));
    //     }
    //     if(!Hash::check($credentials['password'],$user->password)){
    //         throw new UnauthExcept(__('validation.invalid_credentials'));
    //     }
    //     try {
    //         $exp = now()->addMinute((int)config('auth.jwt_ttl.admin'))->timespan;
    //         $token = JWTAuth::customClaims([
    //             'id' => $user->uuid,
    //             'exp' => $exp,
    //             'type' => 'access',
    //             'iss' => env('JWT_ISSUER', '')
    //         ])->formUser($user);
    //     } catch (JWTException $e) {
    //         Log::error($e->getMessage());
    //         throw new UnauthExcept(__('validation.invalid_credentials'));
    //     }
    //     $profile = HelperMedia::getImageUrl(ImageBuket::USER->value,ImageDirectory::PROFILE->value, $user->avata);
    //     return new LoginDTO($user->id, $user->name, $profile, $token, [], []);
    // }

//     public function login(array $credentials): LoginDTO
// {
//     $validator = validator($credentials, [
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     if ($validator->fails()) {
//         throw new UnauthExcept($validator->errors()->first());
//     }
//     $inputs = $validator->validated();

//     $user = $this->authRepository->findByEmailWithConditions($inputs['email'], ['*'], [
//         'active' => AccountStatus::ACTIVE->value,
//         'deleted_at' => null
//     ]);

//     if (!$user) {
//         Log::info('Login failed: user not found or inactive', ['email' => $inputs['email']]);
//         throw new UnauthExcept(__('validation.invalid_credentials'));
//     }
//     if (!Hash::check($credentials['password'], $user->password)) {
//         Log::info('Login failed: password mismatch', ['email' => $inputs['email']]);
//         throw new UnauthExcept(__('validation.invalid_credentials'));
//     }

//     try {
//         $exp = now()->addMinutes((int)config('auth.jwt_ttl.admin'))->timestamp;
//         $token = JWTAuth::customClaims([
//             'id' => $user->uuid,
//             'exp' => $exp,
//             'type' => 'access',
//             'iss' => env('JWT_ISSUER', '')
//         ])->fromUser($user);
//     } catch (JWTException $e) {
//         Log::error($e->getMessage());
//         throw new UnauthExcept(__('validation.invalid_credentials'));
//     }

//     $profile = HelperMedia::getImageUrl(ImageBuket::USER->value, ImageDirectory::PROFILE->value, $user->photo_file_name);
//     return new LoginDTO($user->id, $user->name, $profile, $token, [], []);
// }

    // public function logout(Request $request): void
    // {
    //     $request->user()?->currentAccessToken()?->delete();
    // }

    public function register(Request $request): array
{
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => \App\Enums\Role::CUSTOMER,
    ]);

    $token = JWTAuth::fromUser($user);

    return ['user' => $user, 'token' => $token];
}

    // public function login(array $credentials): array
    // {
    //     if (!$token = Auth::guard('api')->attempt($credentials)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['អ៊ីមែល ឬលេខសម្ងាត់មិនត្រឹមត្រូវទេ'],
    //         ]);
    //     }

    //     $user = Auth::guard('api')->user();

    //     if ($user->active === 0) {
    //         Auth::guard('api')->logout(); // បិទ token ចោលវិញ
    //         throw ValidationException::withMessages([
    //             'email' => ['គណនីរបស់អ្នកត្រូវបានផ្អាកដំណើរការជាបណ្ដោះអាសន្ន'],
    //         ]);
    //     }

    //     return [
    //         'user'  => new UserResource($user),
    //         'token' => $token,
    //     ];
    // }

    // public function login(array $credentials): array
    // {
    //     try {
    //         // កែប្រែមកប្រើ ValidationException វិញដើម្បីកុំឱ្យជល់ Type
    //         if (!$token = Auth::guard('api')->attempt($credentials)) {
    //             throw \Illuminate\Validation\ValidationException::withMessages([
    //                 'email' => ['អ៊ីមែល ឬលេខសម្ងាត់មិនត្រឹមត្រូវទេ'],
    //             ]);
    //         }

    //         $user = Auth::guard('api')->user();

    //         return [
    //             'user'  => $user,
    //             'token' => $token,
    //         ];

    //     } catch (\Throwable $e) {
    //         // 🚨 ទុកឱ្យ dd() នេះដើរតួនាទីចាប់កំហុសពិតប្រាកដមកបង្ហាញលើ Browser
    //         dd([
    //             'message' => $e->getMessage(),
    //             'file'    => $e->getFile(),
    //             'line'    => $e->getLine(),
    //             'trace'   => $e->getTraceAsString()
    //         ]);
    //     }
    // }
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

    return [
        'user' => Auth::guard('api')->user(),
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
