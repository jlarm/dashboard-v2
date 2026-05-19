<?php

declare(strict_types=1);

namespace App\Pdf;

use Spatie\LaravelPdf\Drivers\CloudflareDriver as SpatieCloudflareDriver;
use Spatie\LaravelPdf\PdfOptions;

class CloudflareDriver extends SpatieCloudflareDriver
{
    protected function buildRequestBody(string $html, ?string $headerHtml, ?string $footerHtml, PdfOptions $options): array
    {
        $body = parent::buildRequestBody($html, $headerHtml, $footerHtml, $options);

        $body['gotoOptions'] = [
            'waitUntil' => 'networkidle0',
            'timeout' => 30000,
        ];

        return $body;
    }
}
