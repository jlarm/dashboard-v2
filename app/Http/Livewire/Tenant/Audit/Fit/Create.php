<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\Fit;

use App\Models\Dealer\Store;
use App\Models\FitTestDoc;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Store $store;
    public $search = '';
    public $selectedUser;
    public $date;
    public $file;

    public function mount(): void
    {
        $this->store = (app()->bound('currentStoreModel') ? app('currentStoreModel') : null)
            ?? Store::query()->find(app('currentStore'));
    }

    public function searchUsers(): void
    {
        if (mb_strlen((string) $this->search) >= 2) {
            $users = $this->baseQuery()
                ->whereDoesntHave('roles', function ($query): void {
                    $query->where('name', 'super-admin')
                        ->orWhere('name', 'Consultant');
                })
                ->where('name', 'like', '%'.$this->search.'%')
                ->select('id', 'name')
                ->limit(10)
                ->get()
                ->toArray();

            $this->dispatchBrowserEvent('search-updated', ['users' => $users]);
        } else {
            $this->dispatchBrowserEvent('search-updated', ['users' => []]);
        }
    }

    public function selectUser($userId): void
    {
        $this->selectedUser = [
            'id' => $userId,
            'name' => User::query()->where('id', $userId)->value('name'),
        ];
        $this->search = $this->selectedUser['name'];

        // Hide dropdown
        $this->dispatchBrowserEvent('search-updated', ['users' => []]);
    }

    public function save(): void
    {
        try {
            $this->validate([
                'selectedUser' => [
                    'required',
                    function ($attribute, $value, $fail): void {
                        if (! is_array($value) || ! isset($value['id'])) {
                            $fail('Please select a valid employee from the dropdown.');
                        }
                    },
                ],
                'date' => 'required|date',
                'file' => 'required|mimes:pdf|max:2048',
            ],
                [
                    'selectedUser.required' => 'Please select an employee from the dropdown.',
                    'selectedUser.array' => 'Please select an employee from the dropdown.',
                    'file.required' => 'Please upload a file.',
                ]
            );

            $filePath = $this->file->store(tenant()->id.'/fits', 'dealer-docs');

            FitTestDoc::query()->create([
                'store_id' => $this->store->id,
                'user_id' => $this->selectedUser['id'],
                'employee_name' => $this->selectedUser['name'],
                'date' => $this->date,
                'file_path' => $filePath,
            ]);

            $this->reset(['search', 'selectedUser', 'date', 'file']);

            $this->dispatchBrowserEvent('reset-file-input');

            $this->dispatch('saved');

            Notification::make()
                ->title('File Uploaded Successfully')
                ->success()
                ->send();

        } catch (ValidationException $e) {
            $this->dispatchBrowserEvent('search-updated', ['users' => []]); // Clear the dropdown
            throw $e; // Re-throw to let Livewire handle the validation error
        }

    }

    public function render(): View
    {
        return view('livewire.tenant.audit.fit.create');
    }

    private function baseQuery()
    {
        return app('multipleStoresExist') ? $this->store->users() : User::query();
    }
}
