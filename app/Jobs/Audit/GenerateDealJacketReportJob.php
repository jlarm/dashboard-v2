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
        $fileName = $this->createFileName();
        $this->createPdf($path, $fileName);
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

    private function createFileName(): string
    {
        $storeName = str_replace(' ', '-', $this->dealJacketGroup->store->name);
        $date = $this->dealJacketGroup->created_at->format('Ymd-His');

        return "{$date}-{$storeName}-deal-jacket-report.pdf";
    }

    private function createPdf(string $path, string $fileName): void
    {
        $this->dealJacketGroup->loadSum('dealJackets as total_passed', 'total_passed');
        $this->dealJacketGroup->loadSum('dealJackets as total_failed', 'total_failed');

        $dealJackets = $this->dealJacketGroup->dealJackets()
            ->with(['user'])
            ->get();

        $issuesByUser = [];
        $dealJacketDetails = [];
        $dealJacketsByUser = [];

        foreach ($dealJackets as $dealJacket) {
            $userName = $dealJacket->user->name;
            $issueCount = 0;

            if (! isset($issuesByUser[$userName])) {
                $issuesByUser[$userName] = 0;
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
        ])->render();

        Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save("{$path}/{$fileName}");
    }

    private function sendNotification(string $fileName): void
    {
        Notification::make()
            ->title('Deal Jacket Report Ready')
            ->body('Your deal jacket report has been generated successfully. Click the button below to download it. This report will expire in 24 hours.')
            ->success()
            ->actions([
                Action::make('download')
                    ->label('Download Report')
                    ->url(route('dealer.audit.deal-jacket-reports.download', ['fileName' => $fileName]))
                    ->openUrlInNewTab()
                    ->button(),
            ])
            ->sendToDatabase($this->user);
    }
}
