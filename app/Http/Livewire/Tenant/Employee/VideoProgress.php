<?php

namespace App\Http\Livewire\Tenant\Employee;

use App\Models\User;
use App\Services\VimeoService;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class VideoProgress extends Component
{
    public User $user;

    public function render(VimeoService $vimeoService): View
    {
        $videos = $this->getVimeoVideos($vimeoService);
        $progress = $this->getUserVideoProgress();

        $videos = $videos->map(function ($video) use ($progress) {
            $progressItem = $progress->where('video_id', $video['id'])->first();
            if ($progressItem && $progressItem['completed']) {
                $video['completed'] = true;
                $video['date'] = $progressItem['created_at'];
            } else {
                $video['completed'] = false;
            }

            return $video;
        });

        return view('livewire.tenant.employee.video-progress', [
            'videos' => $videos,
        ]);
    }

    private function getVimeoVideos(VimeoService $vimeoService): Collection
    {
        return collect($vimeoService->getVideos());
    }

    private function getUserVideoProgress(): Collection
    {
        return $this->user->videoProgress->select('video_id', 'completed', 'created_at');
    }
}
