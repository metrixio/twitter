<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter\Entities;

final class Metrics
{
    public static function fromArray(object $data): self
    {
        return new self(
            $data->followers_count,
            $data->following_count,
            $data->tweet_count,
        );
    }

    private function __construct(
        public readonly int $followers,
        public readonly int $following,
        public readonly int $tweets,
    ) {
    }
}
