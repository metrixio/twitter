<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Application\Repository\AccountCacheRepository;
use App\Application\Repository\AccountConfigRepository;
use App\Application\Repository\AccountEvnRepository;
use App\Application\TwitterAccountRegistry;
use App\Infrastructure\Twitter\Client;
use App\Infrastructure\Twitter\ClientInterface;
use App\Infrastructure\Twitter\TwitterConfig;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Cache\CacheStorageProviderInterface;
use Spiral\Config\ConfiguratorInterface;

final class TwitterBootloader extends Bootloader
{
    protected const SINGLETONS = [
        ClientInterface::class => [self::class, 'initClient'],
        TwitterAccountRegistry::class => [self::class, 'initTwitterAccountRegistry'],
    ];

    public function __construct(
        private readonly ConfiguratorInterface $config
    ) {
    }

    private function initTwitterAccountRegistry(
        AccountConfigRepository $configRepository,
        AccountEvnRepository $envRepository,
        AccountCacheRepository $cacheRepository
    ): TwitterAccountRegistry {
        $accounts = \array_merge(
            $configRepository->all(),
            $envRepository->all(),
            $cacheRepository->all(),
        );

        return new TwitterAccountRegistry(
            \array_unique($accounts)
        );
    }

    public function init(EnvironmentInterface $env): void
    {
        $this->config->setDefaults(
            TwitterConfig::CONFIG,
            [
                'consumer_key' => $env->get('TWITTER_CONSUMER_KEY'),
                'consumer_secret' => $env->get('TWITTER_CONSUMER_SECRET'),
                'access_token' => $env->get('TWITTER_ACCESS_TOKEN'),
                'access_token_secret' => $env->get('TWITTER_ACCESS_TOKEN_SECRET'),
            ]
        );
    }

    private function initClient(TwitterConfig $config): ClientInterface
    {
        return new Client(
            new TwitterOAuth(
                $config->getConsumerKey(), $config->getConsumerSecret(),
                $config->getAccessToken(), $config->getAccessTokenSecret()
            )
        );
    }
}
