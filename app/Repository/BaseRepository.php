<?php

namespace App\Repository;

use App\DTO\PaginationDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepository
{
    /**
     * Get all Brand data
     */
    public function getAll(): Collection;

    public function findById(int $id, array $select = ['*']): ?Model;

    public function create(array $data): Model;

    public function updateById(int $id, array $data): ?Model;

    public function deleteById(int $id): void;

    // public function softDeleteById(int $id, ?string $reason = '', ?callable $callback = null): ?bool;

    public function pagination(
        array $fileters,
        array $select = ['*'],
        ?array $conditions = ['deleted_at' => null],
        int $limit = 100,
        bool $withTotal = true,
        string $rawSort = '',
        ?callable $callbackFunc = null,
        array $additionalResult = [],
        ?int $cacheMin = 10,
        array $catchTage = [],
        ?array $with = [],
        ?callable $beforeQuery = null
    ): PaginationDTO;

    public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model;

    public function checkDuplicateColumn(array $conditions, ?int $excludeId = null, bool $ignoreSoftDeleted = false): bool;
}
