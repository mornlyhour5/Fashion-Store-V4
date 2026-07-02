<?php

// namespace App\Repository\Auth;

// use App\Models\User;
// use App\Repository\BaseRepositoryImpl;
// use App\Repository\Contracts\LoginRepository;

// class LoginRepositoryImpl extends BaseRepositoryImpl implements LoginRepository
// {
//     public function __construct(User $user)
//     {
//         parent::__construct($user);
//     }


//     public function findByLoginNameWithCondition(string $name, $select = ['*'], array $conditions = [])
//     {
//         $query = $this->model->where('name', $name)->select($select);

//         foreach ($conditions as $column => $value) {
//             $query->where($column, $value);
//         }
//         $query->orderByDesc('id');
//         return $query->first();
//     }
// }



namespace App\Repository\Auth;

use App\Models\User;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\LoginRepository;

class LoginRepositoryImpl extends BaseRepositoryImpl implements LoginRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByLoginNameWithCondition(string $loginName, $select = ['*'], array $conditions = [])
    {
        $query = $this->model->where('email', $loginName)->select($select);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }
        $query->orderByDesc('id');
        return $query->first();
    }
}
