<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter;

use Spiral\Core\InjectableConfig;

final class TwitterConfig extends InjectableConfig
{
    public const CONFIG = 'twitter';

    public function __construct(
        protected array $config = [
            'consumer_key' => null,
            'consumer_secret' => null,
            'access_token' => null,
            'access_token_secret' => null,
            'accounts' => [],
        ]
    ) {
    }

    public function getAccounts(): array
    {
        return $this->config['accounts'] ?? [];
    }

    public function getConsumerKey(): string
    {
        return $this->config['consumer_key']
            ?? throw new \InvalidArgumentException('Consumer key is required.');
    }

    public function getConsumerSecret(): string
    {
        return $this->config['consumer_secret']
            ?? throw new \InvalidArgumentException('Consumer secret is required.');;
    }

    public function getAccessToken(): ?string
    {
        return $this->config['access_token'] ?? null;
    }

    public function getAccessTokenSecret(): ?string
    {
        return $this->config['access_token_secret'] ?? null;
    }
}
