<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class ResettableUserData implements Arrayable
{
    public const string STATUS_COMPLETED = 'completed';

    public const string STATUS_IN_PROGRESS = 'in-progress';

    public const string STATUS_NOT_STARTED = 'not-started';

    /**
     * @param  list<string>  $stores
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public array $stores,
        public string $status,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: (int) $user->id,
            name: (string) $user->name,
            email: (string) $user->email,
            stores: array_values($user->stores->pluck('name')->map(static fn (mixed $name): string => (string) $name)->all()),
            status: self::deriveStatus($user),
        );
    }

    /**
     * @return array{id: int, name: string, email: string, stores: list<string>, status: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $this->stores,
            'status' => $this->status,
        ];
    }

    private static function deriveStatus(User $user): string
    {
        $totalUserCourses = (int) ($user->total_user_courses ?? 0);
        $totalCompletedCourses = (int) ($user->total_completed_courses ?? 0);
        $resultsCount = (int) ($user->results_count ?? 0);

        if ($totalUserCourses > 0 && $totalCompletedCourses === $totalUserCourses) {
            return self::STATUS_COMPLETED;
        }

        if ($resultsCount > 0) {
            return self::STATUS_IN_PROGRESS;
        }

        return self::STATUS_NOT_STARTED;
    }
}
