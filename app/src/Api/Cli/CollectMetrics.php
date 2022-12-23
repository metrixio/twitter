<?php

declare(strict_types=1);

namespace App\Api\Cli;

use App\Application\Job\TwitterDataCollector;
use App\Application\Metrics\Collector;
use App\Application\TwitterAccountRegistry;
use App\Application\TwitterCollectors;
use Psr\Log\LoggerInterface;
use Spiral\Console\Command;
use Spiral\Queue\Options;
use Spiral\Queue\QueueInterface;

final class CollectMetrics extends Command
{
    protected const SIGNATURE = <<<CMD
        collect:start
        {--i|interval=60 : Interval in seconds}
    CMD;

    protected const DESCRIPTION = 'Collect twitter metrics';

    public function __invoke(
        LoggerInterface $logger,
        TwitterAccountRegistry $registry,
        Collector $metrics,
        QueueInterface $queue,
    ): int {
        $interval = $this->getInterval();

        while (true) {
            $metrics->declare(new TwitterCollectors());

            foreach ($registry->getAccounts() as $userId) {
                $logger->debug('Collecting metrics', ['user_id' => $userId]);

                $queue->push(
                    TwitterDataCollector::class,
                    ['user_id' => $userId],
                    (new Options())->withQueue('twitter')->withHeader('attempts', '3')
                );
            }

            \sleep($interval);
        }

        return self::SUCCESS;
    }

    public function getInterval(): int
    {
        return \max(
            (int)$this->option('interval'),
            10
        );
    }
}
