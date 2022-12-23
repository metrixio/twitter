<?php

declare(strict_types=1);

namespace App\Api\GRPC;

use App\Application\Repository\AccountCacheRepository;
use App\Application\TwitterAccountRegistry;
use GRPC\Twitter\AddRequest;
use GRPC\Twitter\AddResponse;
use GRPC\Twitter\AllRequest;
use GRPC\Twitter\AllResponse;
use GRPC\Twitter\RemoveRequest;
use GRPC\Twitter\RemoveResponse;
use GRPC\Twitter\TwitterServiceInterface;
use Psr\SimpleCache\CacheInterface;
use Spiral\Cache\CacheStorageProviderInterface;
use Spiral\RoadRunner\GRPC;

final class TwitterService implements TwitterServiceInterface
{
    private readonly CacheInterface $cache;

    public function __construct(
        private readonly TwitterAccountRegistry $registry,
        CacheStorageProviderInterface $storageProvider
    ) {
        $this->cache = $storageProvider->storage(AccountCacheRepository::STORAGE_NAME);
    }

    public function Add(GRPC\ContextInterface $ctx, AddRequest $in): AddResponse
    {
        $this->registry->add($in->getId());
        $this->persist();

        return new AddResponse([
            'status' => true,
        ]);
    }

    public function Remove(GRPC\ContextInterface $ctx, RemoveRequest $in): RemoveResponse
    {
        $this->registry->add($in->getId());
        $this->persist();

        return new RemoveResponse([
            'status' => true,
        ]);
    }

    public function All(GRPC\ContextInterface $ctx, AllRequest $in): AllResponse
    {
        return new AllResponse([
            'ids' => $this->registry->getAccounts(),
        ]);
    }

    private function persist(): void
    {
        $this->cache->set(
            AccountCacheRepository::CACHE_KEY,
            $this->registry->getAccounts()
        );
    }
}
