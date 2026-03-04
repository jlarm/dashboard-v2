<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

class GenerateIndividualAuditPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 240;
    public $audits;
    public int $count = 0;
    public $issueCountByManager;
    public $issuesByManager;

    /**
     * @var array<int, mixed>
     */
    public array $array = [];

    public $results = [];
    public $totals = [];
    public $grandTotal;
    public $managerIssueCount = [];
    protected $sum;
    protected IndividualAudit $parent;

    public function __construct(protected IndividualAudit $individualAudit)
    {
        $this->parent = $this->individualAudit;

        $this->audits = IndividualAudit::query()
            ->where('id', $this->individualAudit->id)
            ->orWhere('parent_id', $this->individualAudit->id)
            ->with('store')
            ->with('user')
            ->get();

        $this->issueCountByManager = $this->audits
            ->sortBy('manager.name')
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item): int {
                $this->array = [];
                $item->each(function ($item, $key): void {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (! ($key !== 'id' &&
                        $key !== 'parent_id' &&
                        $key !== 'user_id' &&
                        $key !== 'store_id' &&
                        $key !== 'manager_id' &&
                        $key !== 'mileage' &&
                        $key !== 'customer_number' &&
                        $key !== 'rating' &&
                        $key !== 'individual_q1_answer')) {
                            continue;
                        }
                        if ($key === 'individual_q2_answer') {
                            continue;
                        }
                        if ($value !== 2) {
                            continue;
                        }
                        $this->array[] = $value;
                    }
                });

                return count($this->array);
            });

        $this->issuesByManager = $this->audits
            ->sortBy('manager.name')
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key): void {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (! ($key !== 'id' &&
                        $key !== 'parent_id' &&
                        $key !== 'user_id' &&
                        $key !== 'store_id' &&
                        $key !== 'manager_id' &&
                        $key !== 'mileage' &&
                        $key !== 'customer_number' &&
                        $key !== 'rating' &&
                        $key !== 'individual_q1_answer')) {
                            continue;
                        }
                        if ($key === 'individual_q2_answer') {
                            continue;
                        }
                        if ($value !== 2) {
                            continue;
                        }
                        preg_match('/^[^_]*_q\K[^_]+/', $key, $matches);
                        $comment = $item->getAttributes()['individual_q'.$matches[0].'_comment'];
                        $this->array[] = [$key, $item->customer_number, $key, $comment];
                    }
                });

                return collect($this->array)->groupBy(fn ($item) => $item[0]);
            });

        $this->managerIssueCount = $this->audits
            ->sortBy('manager.name')
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item): array {
                $this->array = [];
                $item->each(function ($item, $key): void {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (! ($key !== 'id' &&
                        $key !== 'parent_id' &&
                        $key !== 'user_id' &&
                        $key !== 'store_id' &&
                        $key !== 'manager_id' &&
                        $key !== 'mileage' &&
                        $key !== 'customer_number' &&
                        $key !== 'rating' &&
                        $key !== 'individual_q1_answer')) {
                            continue;
                        }
                        if ($key === 'individual_q2_answer') {
                            continue;
                        }
                        if ($value !== 2) {
                            continue;
                        }
                        $this->array[] = $key;
                    }
                });

                return array_count_values($this->array);
            });

        foreach ($this->managerIssueCount as $name => $answers) {
            foreach ($answers as $question => $answer) {
                if (! isset($this->results[$question])) {
                    $this->results[$question] = [];
                }
                $this->results[$question][$name] = $answer;
                if (! isset($this->results[$question]['Total'])) {
                    $this->results[$question]['Total'] = 0;
                }
                $this->results[$question]['Total'] += $answer;
            }
        }

        // Fill in missing answers for each question
        $allNames = array_keys($this->managerIssueCount->toArray());
        foreach ($this->results as $question => $answers) {
            foreach ($allNames as $name) {
                if (! isset($answers[$name])) {
                    $this->results[$question][$name] = 0;
                }
            }
        }

        // Rearrange "Total" to be at the end of each sub-array
        foreach ($this->results as &$subArray) {
            // Check if "Total" key exists
            if (isset($subArray['Total'])) {
                // Remove "Total" key-value pair from array
                $total = $subArray['Total'];
                unset($subArray['Total']);
                ksort($subArray);
                // Add "Total" key-value pair to end of array
                $subArray['Total'] = $total;
            } else {
                ksort($subArray);
            }
        }

        foreach ($this->managerIssueCount as $name => $answers) {
            $total = array_sum($answers);
            $this->totals[$name] = $total;
            $this->grandTotal += $total;
        }
        $this->totals[] = $this->grandTotal;
    }

    public function handle(): void
    {
        $path = storage_path('app/individual-audits');
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        if ($this->individualAudit->store !== null && Store::query()->count() > 1) {
            $dealerName = str_replace(' ', '-', $this->individualAudit->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }

        $fileName = $this->individualAudit->audit_date->format('Ymd').'-'.$this->individualAudit->created_at->format('his').'-'.$dealerName.'-deal-jacket-audit.pdf';

        $html = view('dealer.audit.individual.download', [
            'audit' => $this->parent,
            'auditCount' => $this->issueCountByManager,
            'audits' => $this->audits,
            'managers' => $this->issuesByManager,
            'managerIssueCount' => $this->results,
            'totals' => $this->totals,
        ])->render();

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save(storage_path('app/individual-audits/'.$fileName));

        $this->parent->update([
            'pdf_path' => $fileName,
        ]);

        $this->rating();

    }

    private function rating(): void
    {

        foreach ($this->audits as $audit) {
            $sum = 0;
            for ($i = 3; $i <= 40; $i++) {
                if ($audit->{'individual_q'.$i.'_answer'} === 2) {
                    $sum += 1;
                }
            }
            $wrong = $sum;

            $audit->update([
                'rating' => number_format(100 * (40 - $wrong) / 40, 2, '.', ''),
            ]);
        }
    }
}
