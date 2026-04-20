<?php

declare(strict_types=1);

namespace App\Concerns;

trait BuildsVimeoEmbedUrl
{
    protected function buildVimeoEmbedUrl(?string $url, array $parameters = []): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        $fragment = parse_url($url, PHP_URL_FRAGMENT);
        $urlWithoutFragment = $fragment === null ? $url : mb_substr($url, 0, -1 * (mb_strlen($fragment) + 1));
        $query = [];
        $baseUrl = $urlWithoutFragment;

        if (is_string(parse_url($urlWithoutFragment, PHP_URL_QUERY))) {
            parse_str(parse_url($urlWithoutFragment, PHP_URL_QUERY), $query);
        }

        $questionMarkPosition = mb_strpos($urlWithoutFragment, '?');

        if ($questionMarkPosition !== false) {
            $baseUrl = mb_substr($urlWithoutFragment, 0, $questionMarkPosition);
        }

        $mergedQuery = array_merge($query, $parameters);
        $embedUrl = $baseUrl;

        if ($mergedQuery !== []) {
            $embedUrl .= '?'.http_build_query($mergedQuery);
        }

        if (is_string($fragment) && $fragment !== '') {
            $embedUrl .= '#'.$fragment;
        }

        return $embedUrl;
    }
}
