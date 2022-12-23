<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter;

use App\Infrastructure\Twitter\Entities\Tweets;
use App\Infrastructure\Twitter\Entities\UserProfile;

interface ClientInterface
{
    /**
     * Returns information about a user by id.
     */
    public function user(string $userId): UserProfile;

    /**
     * Returns Tweets composed by a single user, specified by the requested user ID. By default, the most recent ten
     * Tweets are returned per request. Using pagination, the most recent 3,200 Tweets can be retrieved.
     */
    public function timeline(string $userId, \DateTimeInterface $start, ?string $paginationToken = null): Tweets;

}
