<?php

namespace App\Repository\Contracts;

use App\Repository\BaseRepository;

interface LoginRepository extends BaseRepository
{
    public function findByLoginNameWithCondition(string $loginName, $select = ['*'], array $conditions = []);
}
