<?php

declare(strict_types=1);

namespace App\Application\Repository;

use Spiral\Boot\EnvironmentInterface;

final class AccountEvnRepository implements AccountRepositoryInterface
{
    public function __construct(
        private readonly EnvironmentInterface $env
    ) {
    }

    public function all(): array
    {
        $data = $this->env->get('TWITTER_ACCOUNTS');

        if ($data === null) {
            return [];
        }

        return \array_filter(\explode(',', (string) $data));
    }
}
