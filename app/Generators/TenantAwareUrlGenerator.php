<?php

namespace App\Generators;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class TenantAwareUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = asset($this->getPathRelativeToRoot());

        return $this->versionUrl($url);
    }
}
