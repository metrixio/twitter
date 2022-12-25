<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Infrastructure\Twitter\TwitterConfig;

final class AccountConfigRepository implements AccountRepositoryInterface
{
    public function __construct(
        private readonly TwitterConfig $config,
    ) {
    }

    public function all(): array
    {
        return $this->config->getAccounts();
    }
}
