<?php

declare(strict_types=1);

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\DealJacketQuestion;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

class GenerateDealJacketReportJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly DealJacketGroup $dealJacketGroup,
        private readonly User $user
    ) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->dealJacketGroup)];
    }

    public function handle(): void
    {
        $path = $this->createDirectory();
        $storeName = $this->dealJacketGroup->store->name;
        $fileNameStoreName = str_replace(' ', '-', $storeName);
        $fileName = $this->createFileName($fileNameStoreName);
        $this->createPdf($path, $fileName, $storeName);
        $this->sendNotification($fileName);
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
            $userName = $dealJacket->user->name;
            $issueCount = 0;

            if (! isset($issuesByUser[$userName])) {
                $issuesByUser[$userName] = 0;
            }

            if (! in_array($userName, $allUsers)) {
                $allUsers[] = $userName;
            }

            $dealJacketIssues = [];

            if (is_array($dealJacket->responses)) {
                foreach ($dealJacket->responses as $questionId => $response) {
                    if (isset($response['answer']) && $response['answer'] === 'no') {
                        $issueCount++;

                        $question = tenancy()->central(fn () => DealJacketQuestion::find($questionId));
                        $statement = $question?->statement ?? "Question {$questionId}";

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

            if (count($dealJacketIssues) > 0) {
                if (! isset($dealJacketsByUser[$userName])) {
                    $dealJacketsByUser[$userName] = [];
                }

                $dealJacketsByUser[$userName][] = $detail;
            }
        }

        $html = view('dealer.audit.deal-jacket.pdf-report', [
            'dealJacketGroup' => $this->dealJacketGroup,
            'user' => $this->user,
            'issuesByUser' => $issuesByUser,
            'dealJacketDetails' => $dealJacketDetails,
            'dealJacketsByUser' => $dealJacketsByUser,
            'totalIssues' => $this->dealJacketGroup->total_failed,
            'issuesByStatementAndUser' => $issuesByStatementAndUser,
            'allUsers' => $allUsers,
        ])->render();

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

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->showBrowserHeaderAndFooter()
            ->hideHeader()
            ->footerHtml($footerHtml)
            ->save("{$path}/{$fileName}");
    }

    private function sendNotification(string $fileName): void
    {
        $notification = Notification::make()
            ->title('Deal Jacket Report Ready')
            ->body('Your deal jacket report has been generated successfully. Click the button below to view it. This report will expire in 24 hours.')
            ->success()
            ->actions([
                Action::make('download')
                    ->label('View Report')
                    ->url(route('dealer.audit.deal-jacket-reports.download', ['fileName' => $fileName]))
                    ->openUrlInNewTab()
                    ->button(),
            ]);

        $notification->sendToDatabase($this->user);
        $notification->send();
    }
}
