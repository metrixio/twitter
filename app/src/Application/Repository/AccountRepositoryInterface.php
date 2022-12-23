<?php

declare(strict_types=1);

namespace App\Application\Repository;

interface AccountRepositoryInterface
{
    public function all(): array;
}
