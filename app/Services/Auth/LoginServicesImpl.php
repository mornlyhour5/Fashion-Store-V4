<?php

// namespace App\Services\Auth;

// use App\DTO\LoginDTO;
// // use App\Enums\AccountStatus;
// // use App\Enums\LoginAccountType;
// use App\Exceptions\UnauthExcept;
// use App\Repository\Contracts\LoginRepository;
// use App\Services\Contracts\LoginService;
// use Illuminate\Support\Facades\Hash;
// // use Illuminate\Validation\Rules\Enum;
// use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
// use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

// // use Illuminate\Auth\AuthenticationException;
// // use Illuminate\Support\Facades\Auth;

// class LoginServicesImpl implements LoginService
// {
//     public function __construct(protected LoginRepository $loginRepository) {}

//     public function login(array $credentials): LoginDTO
//     {
//         $validator = validator($credentials, [
//             'email'    => 'required|string',
//             'password' => 'required|string|min:8|max:20'
//         ]);

//         if($validator->fails()) {
//             throw new UnauthExcept($validator->errors()->first());
//         }
//         $inputs  = $validator->validated();
//         $user = $this->loginRepository->findByLoginNameWithCondition($inputs['email'], ['*'], [
//             'is_active' => true
//         ]);
//         dd($user, $inputs['email']);

//         if (!$user) {
//             throw new UnauthExcept(__('validation.invalid_credentials'));
//         }
//         if(!Hash::check($credentials['password'], $user->password)){
//             throw new UnauthExcept(__('validation.invalid_credentials'));
//         }
//         // try {
//         //     // $exp = now()->addMinute((int)config('auth.jwt_ttl.admin'))->timestamp;
//         //     // $token = JWTAuth::customClaims([
//         //     //     'id'   => $user->uuid,
//         //     //     'exp'  => $exp,
//         //     //     'type' => 'access',
//         //     //     'iss'  => env('JWT_ISSUER', '')
//         //     // ])->fromUser($user);
//         // } catch (JWTException $e) {
//         //     throw new UnauthExcept(__('validation.invalid_credentials'));
//         // }
//         // $profile = HelperMedia::getImageUrl(ImageBucket::USER->value,ImageDirectory::PROFILE->value,$user->photo_file_name);
//         return new LoginDTO($user->id, $user->name,$user->password);
//     }
// }

//     // public function changePassword($user,$currentPassword,$newPassword)
//     // {
//     //     if (!Auth::check() || !Auth::attempt(['email' => $user->email, 'password' => $currentPassword])) {
//     //         throw new AuthenticationException('Current password is incorrect');
//     //     }

//     //     return $this->loginRepo->updatePassword($user, $newPassword);
//     // }


namespace App\Services\Auth;

use App\DTO\LoginDTO;
use App\Exceptions\UnauthExcept;
use App\Repository\Contracts\LoginRepository;
use App\Services\Contracts\LoginService;
use Illuminate\Support\Facades\Hash;

class LoginServicesImpl implements LoginService
{
    public function __construct(protected LoginRepository $loginRepository) {}

    public function login(array $credentials): LoginDTO
    {
        $validator = validator($credentials, [
            'email'    => 'required|string',
            'password' => 'required|string|min:8|max:20'
        ]);

        if ($validator->fails()) {
            throw new UnauthExcept($validator->errors()->first());
        }

        $inputs = $validator->validated();

        $user = $this->loginRepository->findByLoginNameWithCondition($inputs['email'], ['*'], [
            'is_active' => true
        ]);

        if (!$user) {
            throw new UnauthExcept(__('validation.invalid_credentials'));
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw new UnauthExcept(__('validation.invalid_credentials'));
        }

        return new LoginDTO($user->id, $user->email, $user->password);
    }
}
