<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitter;

class TextParser
{
    /**
     * @return non-empty-string[]
     */
    public static function getMentions(string $text): array
    {
        $mentions = [];
        \preg_match_all("/@(\w+)/u", $text, $matches);

        if ($matches) {
            $hashtagsArray = \array_count_values($matches[1]);
            $mentions = \array_keys($hashtagsArray);
        }

        return \array_filter($mentions);
    }

    /**
     * @return non-empty-string[]
     */
    public static function getTags(string $text): array
    {
        $hashtags = [];
        \preg_match_all("/#(\w+)/u", $text, $matches);

        if ($matches) {
            $hashtagsArray = \array_count_values($matches[1]);
            $hashtags = \array_keys($hashtagsArray);
        }

        return \array_filter($hashtags);
    }

    /**
     * @return non-empty-string[]
     */
    public static function getUrls(string $text, bool $unShort = false): array
    {
        $pattern = '~[a-z]+://\S+~';

        if ($num_found = \preg_match_all($pattern, $text, $out)) {
            if (! $unShort) {
                return $out[0];
            }

            return \array_filter(
                \array_map(function (string $link): ?string {
                    $headers = \get_headers($link, true);

                    return $headers['location'] ?? null;
                }, $out[0])
            );
        }

        return [];
    }
}
