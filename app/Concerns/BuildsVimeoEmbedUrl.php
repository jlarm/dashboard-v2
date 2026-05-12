<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Support\Uri;

trait BuildsVimeoEmbedUrl
{
    /**
     * @param  array<string, scalar>  $parameters
     */
    protected function buildVimeoEmbedUrl(?string $url, array $parameters = []): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        $uri = Uri::of($url);

        return (string) $uri->withQuery(array_merge($uri->query()->all(), $parameters));
    }
}
