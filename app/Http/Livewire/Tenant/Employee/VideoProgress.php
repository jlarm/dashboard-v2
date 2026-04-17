<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Employee;

use App\Models\User;
use App\Services\VimeoService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class VideoProgress extends Component
{
    public User $user;
    public bool $autoload = false;
    public bool $isLoaded = false;
    public array $videos = [];

    #[Override]
    protected $listeners = ['employeeTabChanged' => 'handleTabChanged'];

    public function mount(): void
    {
        if ($this->autoload) {
            $this->loadVideos();
        }
    }

    public function handleTabChanged(string $tab): void
    {
        if ($tab !== 'video-progress' || $this->isLoaded) {
            return;
        }

        $this->loadVideos();
    }

    public function render(VimeoService $vimeoService): View
    {
        return view('livewire.tenant.employee.video-progress', [
            'videos' => collect($this->videos),
        ]);
    }

    private function loadVideos(): void
    {
        $cacheKey = sprintf('employee_video_progress_%s_%d', tenant('id') ?? 'no-tenant', $this->user->id);

        $this->videos = Cache::remember($cacheKey, now()->addMinutes(5), function (): array {
            $vimeoService = resolve(VimeoService::class);
            $videos = $this->getVimeoVideos($vimeoService);
            $progress = $this->getUserVideoProgress();

            return $videos->map(function (array $video) use ($progress): array {
                $progressItem = $progress->firstWhere('video_id', $video['id']);

                $video['completed'] = (bool) ($progressItem['completed'] ?? false);
                $video['date'] = $progressItem['created_at'] ?? null;

                return $video;
            })->values()->all();
        });

        $this->isLoaded = true;
    }

    private function getVimeoVideos(VimeoService $vimeoService): Collection
    {
        return collect($vimeoService->getVideos());
    }

    private function getUserVideoProgress(): Collection
    {
        return $this->user->videoProgress()
            ->select('video_id', 'completed', 'created_at')
            ->get();
    }
}
