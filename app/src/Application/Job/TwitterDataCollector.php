<?php

declare(strict_types=1);

namespace App\Application\Job;

use App\Application\Metrics\TwitterMetrics;
use App\Infrastructure\Twitter\ClientInterface;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use Spiral\Exceptions\ExceptionReporterInterface;
use Spiral\Queue\Exception\RetryException;
use Spiral\Queue\JobHandler;
use Spiral\Queue\Options;

final class TwitterDataCollector extends JobHandler
{
    /**
     * @throws RetryException
     */
    public function invoke(
        TwitterMetrics $metrics,
        LoggerInterface $logger,
        ClientInterface $client,
        ExceptionReporterInterface $reporter,
        array $payload,
        array $headers = []
    ): void {
        $userId = $payload['user_id'];

        $attempts = (int)($headers['attempts'] ?? 0);

        if ($attempts === 0) {
            $logger->warning('Attempt to fetch [%s] twitter data failed', $userId);
            return;
        }

        try {
            $user = $client->user($userId);

            $metrics->setFollowers(
                (float)$user->metrics->followers, $user->username
            );

            $metrics->setTweets(
                (float)$user->metrics->tweets, $user->username
            );

            // Get tweets from the last 2 days
            $tweets = $client->timeline(
                $userId,
                Carbon::now()->subDays(2)->startOfDay()->utc()
            );

            // Collect metrics for each found tweet
            foreach ($tweets->tweets as $tweet) {
                $metrics->setRetweetsCount($tweet->retweetCount, $user->username, $tweet->id,);
                $metrics->setRepliesCount($tweet->replyCount, $user->username, $tweet->id,);
                $metrics->setLikesCount($tweet->likeCount, $user->username, $tweet->id,);
                $metrics->setQuotesCount($tweet->quoteCount, $user->username, $tweet->id);
            }
        } catch (\Throwable $e) {
            $reporter->report($e);

            throw new RetryException(
                reason: $e->getMessage(),
                options: (new Options())->withDelay(5)->withHeader('attempts', (string)($attempts - 1))
            );
        }
    }
}
