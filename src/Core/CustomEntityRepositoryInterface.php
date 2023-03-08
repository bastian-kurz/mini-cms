<?php

declare(strict_types=1);

namespace App\Core;

use App\Entity\EntityInterface;

interface CustomEntityRepositoryInterface
{
    /**
     * @param array<string,mixed>|null $payload
     * @param int|null $id
     * @return iterable<EntityInterface>|EntityInterface
     */
    public function read(?array $payload, ?int $id): iterable|EntityInterface;

    /**
     * @param array<string, mixed> $payload
     */
    public function create(array $payload): int;

    /**
     * @param array<string, mixed> $payload
     */
    public function update(array $payload, int $id): int;

    public function delete(int $id): void;
}
