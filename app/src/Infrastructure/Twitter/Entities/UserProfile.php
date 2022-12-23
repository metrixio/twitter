<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter\Entities;

use App\Infrastructure\Twitter\TextParser;
use DateTimeImmutable;
use DateTimeInterface;

final class UserProfile
{
    public static function fromArray(object $data): self
    {
        return new self(
            $data->id,
            $data->name,
            $data->username,
            $data->description,
            $data->url ?? null,
            $data->profile_image_url ?? null,
            $data->location ?? null,
            $data->verified,
            TextParser::getTags($data->description),
            TextParser::getUrls($data->description),
            TextParser::getMentions($data->description),
            Metrics::fromArray($data->public_metrics),
            DateTimeImmutable::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $data->created_at),
        );
    }

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $username,
        public readonly string $description,
        public readonly ?string $url,
        public readonly ?string $avatarUrl,
        public readonly ?string $location,
        public readonly bool $verified,
        public readonly array $tags,
        public readonly array $urls,
        public readonly array $mentions,
        public readonly Metrics $metrics,
        public readonly DateTimeImmutable $createdAt
    ) {
    }
}
