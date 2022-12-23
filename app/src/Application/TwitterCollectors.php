<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Metrics\CollectorsInterface;
use Spiral\RoadRunner\Metrics\Collector;

final class TwitterCollectors implements CollectorsInterface
{
    public function getIterator(): \Traversable
    {
        yield 'twitter_followers' => Collector::gauge()
            ->withHelp('Twitter followers.')
            ->withLabels('username');

        yield 'twitter_tweets' => Collector::gauge()
            ->withHelp('Twitter tweets.')
            ->withLabels('username');

        yield 'twitter_tweet_retweet_count' => Collector::gauge()
            ->withHelp('Twitter tweet retweet statistics.')
            ->withLabels('username', 'id');

        yield 'twitter_tweet_reply_count' => Collector::gauge()
            ->withHelp('Twitter tweet reply statistics.')
            ->withLabels('username', 'id');

        yield 'twitter_tweet_like_count' => Collector::gauge()
            ->withHelp('Twitter likes reply statistics.')
            ->withLabels('username', 'id');

        yield 'twitter_tweet_quote_count' => Collector::gauge()
            ->withHelp('Twitter likes quote statistics.')
            ->withLabels('username', 'id');
    }
}
