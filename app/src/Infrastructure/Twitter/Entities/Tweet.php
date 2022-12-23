<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter\Entities;

final class Tweet
{
    public static function fromArray(object $data): self
    {
        return new self(
            $data->id,
            (float) $data->public_metrics->retweet_count,
            (float) $data->public_metrics->reply_count,
            (float) $data->public_metrics->like_count,
            (float) $data->public_metrics->quote_count,
        );
    }

    private function __construct(
        public readonly string $id,
        public readonly float $retweetCount,
        public readonly float $replyCount,
        public readonly float $likeCount,
        public readonly float $quoteCount,
    ) {
    }
}
