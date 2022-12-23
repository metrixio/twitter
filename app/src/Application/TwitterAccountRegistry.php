<?php

declare(strict_types=1);

namespace App\Application;

/**
 * @psalm-type TAccount = string
 */
final class TwitterAccountRegistry
{
    /**
     * @param TAccount[] $accounts
     */
    public function __construct(
        private array $accounts = []
    ) {
    }

    /**
     * @param TAccount $account
     */
    public function add(string $account): void
    {
        $this->accounts[] = $account;
    }

    /**
     * @param TAccount $account
     */
    public function remove(string $account): void
    {
        $this->accounts = \array_filter(
            $this->accounts,
            static fn(string $item): bool => $item !== $account
        );
    }

    /**
     * @return TAccount[]
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }
}
