<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Infrastructure\Twitter\Entities\Tweets;
use App\Infrastructure\Twitter\Entities\UserProfile;

final class Client implements ClientInterface
{
    public function __construct(
        private readonly TwitterOAuth $oauth,
        /**
         * Allowed values: attachments,author_id,context_annotations,conversation_id,created_at,entities,geo,id,
         * in_reply_to_user_id,lang,non_public_metrics,organic_metrics,possibly_sensitive,promoted_metrics,
         * public_metrics,referenced_tweets,reply_settings,source,text,withheld
         * @var non-empty-string[]
         */
        private readonly array $tweetFields = ['id', 'public_metrics'],
        /**
         * Allowed values: attachments.poll_ids, attachments.media_keys, author_id, entities.mentions.username,
         * geo.place_id, in_reply_to_user_id, referenced_tweets.id, referenced_tweets.id.author_id
         * @var string[]
         */
        private readonly array $expansions = ['author_id', 'referenced_tweets.id', 'referenced_tweets.id.author_id'],
    ) {
        $oauth->setApiVersion('2');
    }

    public function user(string $userId): UserProfile
    {
        return UserProfile::fromArray(
            $this->oauth->get('users/' . $userId, [
                'user.fields' => \implode(',', [
                    'created_at',
                    'description',
                    'id',
                    'location',
                    'name',
                    'url',
                    'profile_image_url',
                    'public_metrics',
                    'username',
                    'verified',
                ]),
            ])->data
        );
    }

    public function timeline(string $userId, \DateTimeInterface $start, ?string $paginationToken = null): Tweets
    {
        return new Tweets(
            $userId,
            $this->oauth->get(\sprintf('users/%s/tweets', $userId), [
                'tweet.fields' => $this->getTweetFields(),
                'start_time' => $start->format(\DateTimeInterface::RFC3339),
                'max_results' => 100,
            ])
        );
    }

    private function getTweetFields(): string
    {
        return \implode(',', $this->tweetFields);
    }

    private function getExpansions(): string
    {
        return \implode(',', $this->expansions);
    }
}
