<?php

declare(strict_types=1);

namespace App\Core;

interface ListServiceInterface
{
    public function fetchList(): string;

    public function convert(string $data): array;
}
