<?php

namespace App\Repository\Contracts;

use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepository extends BaseRepository
{
    public function getTrending(int $limit = 10, int $days = 30): Collection;
}
