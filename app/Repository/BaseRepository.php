<?php

namespace App\Repository;

use App\Domain\AuthUser;
use App\DTO\PaginationDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepository
{
    /**
     * Get all Brand data
     */
    public function getAll(): Collection;

    public function getUser(array $filters = []);

    public function getStaff(array $filters = []);

    public function findByIduser(int $id, array $with = []);

    public function setActingUser(?AuthUser $user): static;

    public function lastId();

    public function bulkInsert(array $rows): bool;

    public function findById(int $id, array $select = ['*']): ?Model;

    public function create(array $data): Model;

    public function updateById(int $id, array $data): ?Model;

    public function deleteById(int $id): void;

    public function findByEmail(string $email): ?User;

    public function query(array $select = ['*']): Builder;

    public function countByVariant(int $variantId);

    public function clearMainForVariant(int $variantId);

    public function getByVariant(int $id);

    public function updateProfileByUserId(int $userId, array $data);

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

    public function pagination_wish(
        array $fileters,
        array $select = ['*'],
        ?array $conditions = [],
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

    // public function findByEmailWithCondition(string $email, $select = ['*'], array $conditions = []);

    public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model;
    public function findByEmailWithConditions(string $email, array $select = ['*'], array $conditions = []): ?Model;
    public function findAllWithRelations(): Collection;
    public function checkDuplicateColumn(array $conditions, ?int $excludeId = null, bool $ignoreSoftDeleted = false): bool;
}
