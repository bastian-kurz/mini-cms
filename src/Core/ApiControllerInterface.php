<?php

declare(strict_types=1);

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ApiControllerInterface
{
    public function get(int $id): Response;

    public function create(Request $request): Response;

    public function delete(int $id): Response;

    public function list(Request $request): Response;

    public function update(Request $request, int $id): Response;
}
