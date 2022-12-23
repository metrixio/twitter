<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter\Entities;

final class Tweets
{
    public readonly array $tweets;

    public function __construct(public readonly string $userId, object $data)
    {
        $tweets = [];
        if (isset($data->data)) {
            $tweets = \array_map(function (object $tweet): Tweet {
                return Tweet::fromArray($tweet);
            }, $data->data);
        }

        $this->tweets = $tweets;
    }
}
