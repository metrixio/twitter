<?php

declare(strict_types=1);

namespace App\Application\Repository;

use Psr\SimpleCache\CacheInterface;
use Spiral\Cache\CacheStorageProviderInterface;

final class AccountCacheRepository implements AccountRepositoryInterface
{
    public const STORAGE_NAME = 'accounts';
    public const CACHE_KEY = 'twitter.accounts';

    private readonly CacheInterface $cache;

    public function __construct(
        CacheStorageProviderInterface $provider,
    ) {
        $this->cache = $provider->storage(self::STORAGE_NAME);
    }

    public function all(): array
    {
        return $this->cache->get(self::CACHE_KEY) ?? [];
    }
}
