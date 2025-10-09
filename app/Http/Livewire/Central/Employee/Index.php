<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render(): \Illuminate\View\View
    {
        return view('livewire.central.employee.index', [
            'users' => $this->getUsers(),
        ]);
    }

    private function getUsers()
    {
        // Include user count in cache key to ensure it refreshes when users are added
        $userCount = User::count();
        $cacheKey = 'user_index_'.$this->page.'_search_'.$this->search.'_count_'.$userCount;

        try {
            return Cache::store('redis')->tags(['user_index'])->remember($cacheKey, 3600, function () {
                return User::query()
                    ->search('name', $this->search)
                    ->orderBy('name')
                    ->with(['roles', 'courses'])
                    ->paginate(20);
            });
        } catch (Exception $e) {
            // Fallback if Redis tags fail
            return User::query()
                ->search('name', $this->search)
                ->orderBy('name')
                ->with(['roles', 'courses'])
                ->paginate(20);
        }
    }
}
