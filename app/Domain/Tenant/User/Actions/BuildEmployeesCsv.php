<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Data\TrainingSummaryData;
use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class BuildEmployeesCsv
{
    public function __construct(private readonly GetEmployees $getEmployees) {}

    /**
     * @param  EloquentCollection<int, User>  $users
     */
    public function forSelection(EloquentCollection $users): string
    {
        $users->loadMissing(['stores:id,name', 'department:id,name']);
        $summaries = $this->getEmployees->summariesFor(collect($users));

        $header = 'Name,Email,Store,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon';

        $rows = $users->map(function (User $user) use ($summaries): string {
            $summary = $summaries->get($user->id);

            return implode(',', [
                $this->escape((string) $user->name),
                $this->escape((string) $user->email),
                $this->escape($user->stores->pluck('name')->join(', ')),
                $this->escape($user->department?->name ?? 'N/A'),
                $this->escape($this->statusLabel($summary)),
                (string) ($summary?->validCompleted ?? 0),
                (string) ($summary?->totalRequired ?? 0),
                (string) ($summary?->notCompleted ?? 0),
                (string) ($summary?->expired ?? 0),
                (string) ($summary?->expiringSoon ?? 0),
            ]);
        });

        return $header."\n".$rows->implode("\n")."\n";
    }

    /**
     * @param  EloquentCollection<int, User>  $users
     */
    public function forReport(EloquentCollection $users): string
    {
        $users->loadMissing(['department:id,name']);
        $summaries = $this->getEmployees->summariesFor(collect($users));

        $header = 'Name,Email,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon';

        $rows = $users
            ->filter(fn (User $user): bool => $this->shouldIncludeInReport($summaries, $user))
            ->map(function (User $user) use ($summaries): string {
                $summary = $summaries->get($user->id);

                return implode(',', [
                    $this->escape((string) $user->name),
                    $this->escape((string) $user->email),
                    $this->escape($user->department?->name ?? 'N/A'),
                    $this->escape($this->statusLabel($summary)),
                    (string) ($summary?->validCompleted ?? 0),
                    (string) ($summary?->totalRequired ?? 0),
                    (string) ($summary?->notCompleted ?? 0),
                    (string) ($summary?->expired ?? 0),
                    (string) ($summary?->expiringSoon ?? 0),
                ]);
            });

        return $header."\n".$rows->implode("\n")."\n";
    }

    /**
     * @param  Collection<int, TrainingSummaryData>  $summaries
     */
    private function shouldIncludeInReport(Collection $summaries, User $user): bool
    {
        $summary = $summaries->get($user->id);

        if ($summary instanceof TrainingSummaryData) {
            return $summary->notCompleted > 0 || $summary->expired > 0 || $summary->expiringSoon > 0;
        }

        return (int) $user->total_completed_courses !== (int) $user->total_user_courses;
    }

    private function statusLabel(?TrainingSummaryData $summary): string
    {
        return $summary instanceof TrainingSummaryData ? $summary->statusLabel() : 'Unknown';
    }

    private function escape(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (str_contains($value, ',') || str_contains($value, '"') || str_contains($value, "\n")) {
            return '"'.str_replace('"', '""', $value).'"';
        }

        return $value;
    }
}
