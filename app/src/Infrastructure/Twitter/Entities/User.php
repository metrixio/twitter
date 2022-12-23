<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter\Entities;

final class User
{
    public static function fromArray(object $data): self
    {
        return new self(
            $data->id,
            $data->name,
            $data->username,
        );
    }

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $username,
    ) {
    }
}
