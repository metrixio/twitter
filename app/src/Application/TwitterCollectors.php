<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Metrics\CollectorsInterface;
use Spiral\RoadRunner\Metrics\Collector;

final class TwitterCollectors implements CollectorsInterface
{
    public const FOLLOWERS = 'twitter_followers';
    public const TWEETS = 'twitter_tweets';
    public const RETWEETS_COUNT = 'twitter_tweet_retweet_count';
    public const REPLIES_COUNT = 'twitter_tweet_reply_count';
    public const LIKES_COUNT = 'twitter_tweet_like_count';
    public const QUOTES_COUNT = 'twitter_tweet_quote_count';

    public function getIterator(): \Traversable
    {
        yield self::FOLLOWERS => Collector::gauge()
            ->withHelp('Twitter followers.')
            ->withLabels('username');

        yield self::TWEETS => Collector::gauge()
            ->withHelp('Twitter tweets.')
            ->withLabels('username');

        yield self::RETWEETS_COUNT => Collector::gauge()
            ->withHelp('Twitter tweet retweet statistics.')
            ->withLabels('username', 'id');

        yield self::REPLIES_COUNT => Collector::gauge()
            ->withHelp('Twitter tweet reply statistics.')
            ->withLabels('username', 'id');

        yield self::LIKES_COUNT => Collector::gauge()
            ->withHelp('Twitter likes reply statistics.')
            ->withLabels('username', 'id');

        yield self::QUOTES_COUNT => Collector::gauge()
            ->withHelp('Twitter likes quote statistics.')
            ->withLabels('username', 'id');
    }
}
