<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Throwable;

class GenerateDealJacketReportJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly DealJacketGroup $dealJacketGroup,
        private readonly User $user
    ) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->dealJacketGroup->getKey())];
    }

    public function handle(): void
    {
        $path = $this->createDirectory();
        $storeName = $this->dealJacketGroup->store->name;
        $fileNameStoreName = str_replace(' ', '-', $storeName);
        $fileName = $this->createFileName($fileNameStoreName);
        $this->createPdf($path, $fileName, $storeName);
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }

    private function createDirectory(): string
    {
        $path = storage_path('app/deal-jacket-reports');

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    private function createFileName(string $storeName): string
    {
        $date = $this->dealJacketGroup->created_at->format('Ymd-His');

        return "{$date}-{$storeName}-deal-jacket-report.pdf";
    }

    private function createPdf(string $path, string $fileName, string $storeName): void
    {
        $this->dealJacketGroup->loadSum('dealJackets as total_passed', 'total_passed');
        $this->dealJacketGroup->loadSum('dealJackets as total_failed', 'total_failed');

        $dealJackets = $this->dealJacketGroup->dealJackets()
            ->with(['user'])
            ->get();

        $issuesByUser = [];
        $dealJacketDetails = [];
        $dealJacketsByUser = [];
        $issuesByStatementAndUser = [];
        $allUsers = [];

        foreach ($dealJackets as $dealJacket) {
            $userName = $dealJacket->user->name ?? 'House';
            $issueCount = 0;

            if (! isset($issuesByUser[$userName])) {
                $issuesByUser[$userName] = 0;
            }

            if (! in_array($userName, $allUsers)) {
                $allUsers[] = $userName;
            }

            $dealJacketIssues = [];

            if (is_array($dealJacket->responses)) {
                foreach ($dealJacket->responses as $response) {
                    if (isset($response['answer']) && $response['answer'] === 'no') {
                        $issueCount++;

                        $statement = $response['statement'] ?? 'Unknown question';

                        $dealJacketIssues[] = [
                            'statement' => $statement,
                            'comment' => $response['comment'] ?? '',
                        ];

                        // Track issues by statement and user
                        if (! isset($issuesByStatementAndUser[$statement])) {
                            $issuesByStatementAndUser[$statement] = [];
                        }

                        if (! isset($issuesByStatementAndUser[$statement][$userName])) {
                            $issuesByStatementAndUser[$statement][$userName] = 0;
                        }

                        $issuesByStatementAndUser[$statement][$userName]++;
                    }
                }
            }

            $issuesByUser[$userName] += $issueCount;

            $detail = [
                'customer_name' => $dealJacket->customer_name,
                'customer_deal_number' => $dealJacket->customer_deal_number,
                'user_name' => $userName,
                'purchase_type' => $dealJacket->purchase_type,
                'vehicle_type' => $dealJacket->vehicle_type,
                'mileage' => $dealJacket->mileage,
                'date_of_deal_jacket' => $dealJacket->date_of_deal_jacket,
                'issues' => $dealJacketIssues,
            ];

            $dealJacketDetails[] = $detail;

            if ($dealJacketIssues !== []) {
                if (! isset($dealJacketsByUser[$userName])) {
                    $dealJacketsByUser[$userName] = [];
                }

                $dealJacketsByUser[$userName][] = $detail;
            }
        }

        $footerHtml = '
             <div style="width: 100%; font-size: 10px;">
                 <script>
                     const pageNum = document.querySelector(".pageNumber");
                     if (pageNum && parseInt(pageNum.textContent) > 1) {
                         document.write(\'<div style="display: flex; justify-content: space-between; padding: 0 20px;"><span>'.$storeName.' | Automotive Risk Management Partners</span><span>Page \' + pageNum.textContent + \'</span></div>\');
                     }
                 </script>
             </div>
         ';

        $nodeBinary = $this->resolveNodeBinary();

        Pdf::view('dealer.audit.deal-jacket.pdf-report', [
            'dealJacketGroup' => $this->dealJacketGroup,
            'user' => $this->user,
            'issuesByUser' => $issuesByUser,
            'dealJacketDetails' => $dealJacketDetails,
            'dealJacketsByUser' => $dealJacketsByUser,
            'totalIssues' => $this->dealJacketGroup->total_failed,
            'issuesByStatementAndUser' => $issuesByStatementAndUser,
            'allUsers' => $allUsers,
        ])
            ->driver('browsershot')
            ->margins(top: 10, right: 10, bottom: 10, left: 10)
            ->footerHtml($footerHtml)
            ->withBrowsershot(static fn (Browsershot $browsershot): Browsershot => $browsershot
                ->setNodeModulePath(base_path('node_modules'))
                ->setNodeBinary($nodeBinary)
                ->showBackground()
                ->scale(0.75)
                ->waitUntilNetworkIdle()
            )
            ->save("{$path}/{$fileName}");
    }

    private function resolveNodeBinary(): string
    {
        $configured = config('services.browsershot.node_binary');

        if (is_string($configured) && $configured !== '' && File::exists($configured)) {
            return $configured;
        }

        $candidates = [
            '/opt/homebrew/bin/node',
            '/usr/local/bin/node',
        ];

        foreach ($candidates as $candidate) {
            if (File::exists($candidate)) {
                return $candidate;
            }
        }

        return 'node';
    }
}
