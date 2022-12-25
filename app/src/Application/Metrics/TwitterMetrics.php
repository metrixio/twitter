<?php

declare(strict_types=1);

namespace App\Application\Metrics;

use App\Application\TwitterCollectors;
use Spiral\RoadRunner\Metrics\MetricsInterface;

final class TwitterMetrics
{
    public function __construct(
        private readonly MetricsInterface $metrics
    ) {
    }

    public function setFollowers(float $count, string $username): void
    {
        $this->metrics->set(
            TwitterCollectors::FOLLOWERS,
            $count,
            [$username]
        );
    }

    public function setTweets(float $count, string $username): void
    {
        $this->metrics->set(
            TwitterCollectors::TWEETS,
            $count,
            [$username]
        );
    }

    public function setRetweetsCount(float $count, string $username, string $tweetId): void
    {
        $this->metrics->set(
            TwitterCollectors::RETWEETS_COUNT,
            $count,
            [$username, $tweetId]
        );
    }

    public function setRepliesCount(float $count, string $username, string $tweetId): void
    {
        $this->metrics->set(
            TwitterCollectors::REPLIES_COUNT,
            $count,
            [$username, $tweetId]
        );
    }

    public function setLikesCount(float $count, string $username, string $tweetId): void
    {
        $this->metrics->set(
            TwitterCollectors::LIKES_COUNT,
            $count,
            [$username, $tweetId]
        );
    }

    public function setQuotesCount(float $count, string $username, string $tweetId): void
    {
        $this->metrics->set(
            TwitterCollectors::QUOTES_COUNT,
            $count,
            [$username, $tweetId]
        );
    }
}
