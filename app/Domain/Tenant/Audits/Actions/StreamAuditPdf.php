<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Enums\ViolationAuditType;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Store;
use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

class StreamAuditPdf
{
    public function handle(ViolationAuditType $type, ViolationAudit&Model $audit, bool $remediation = false): PdfBuilder
    {
        $audit->loadMissing([
            'violations',
            'violations.remediation',
            'violations.remediation.user',
            'violations.media',
            'auditComments',
            'auditComments.user',
            'store',
        ]);

        $referenceImages = $this->resolveReferenceImages($audit);
        $filename = $this->buildFilename($type, $audit, $remediation);
        $nodeBinary = $this->resolveNodeBinary();

        $builder = pdf()
            ->driver('browsershot')
            ->view($type->pdfViewName(), [
                'fileName' => $filename,
                'audit' => $audit,
                'remediation' => $remediation,
                'referenceImagesByStatementId' => $referenceImages,
            ])
            ->format(Format::A4)
            ->name($filename)
            ->withBrowsershot(static fn (Browsershot $browsershot) => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->scale(0.75)
                ->waitUntilNetworkIdle()
            );

        if (! $remediation) {
            $builder->footerView('pdf.audit-footer');
        }

        return $builder;
    }

    private function resolveNodeBinary(): string
    {
        $configured = env('BROWSERSHOT_NODE_BINARY');

        if (is_string($configured) && $configured !== '' && File::exists($configured)) {
            return $configured;
        }

        foreach (['/opt/homebrew/bin/node', '/usr/local/bin/node'] as $candidate) {
            if (File::exists($candidate)) {
                return $candidate;
            }
        }

        $home = $_SERVER['HOME'] ?? getenv('HOME') ?? '';
        if ($home !== '') {
            $herdNvm = $home.'/Library/Application Support/Herd/config/nvm/versions/node';
            if (is_dir($herdNvm)) {
                $versions = glob($herdNvm.'/v*/bin/node') ?: [];
                if ($versions !== []) {
                    rsort($versions);

                    return $versions[0];
                }
            }
        }

        return 'node';
    }

    /**
     * @return array<int, string|null>
     */
    private function resolveReferenceImages(ViolationAudit&Model $audit): array
    {
        $statementIds = $audit->violations
            ->where('show_reference_image', true)
            ->pluck('statement_id')
            ->filter()
            ->unique()
            ->values();

        if ($statementIds->isEmpty()) {
            return [];
        }

        return tenancy()->central(fn () => ViolationStatement::query()
            ->whereIn('id', $statementIds)
            ->get(['id', 'reference_image_url'])
        )->pluck('reference_image_url', 'id')->toArray();
    }

    private function buildFilename(ViolationAuditType $type, ViolationAudit&Model $audit, bool $remediation): string
    {
        $dealerName = Store::query()->count() > 1
            ? str_replace(' ', '-', (string) $audit->store?->name)
            : str_replace(' ', '-', (string) tenant('name'));

        $suffix = $type->pdfFilenameSuffix().($remediation ? '-remediation' : '');

        return mb_strtolower((string) $audit->uuid).'-'.mb_strtolower($dealerName).'-'.now()->format('Ymd').'-'.$suffix.'.pdf';
    }
}
