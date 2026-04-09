<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\ViolationStatements;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $statement = '';
    public array $keywords = [];
    public ?int $weight = null;
    public array $categories = [];
    public $image;

    public function store(): void
    {
        $this->validate([
            'statement' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:1', 'max:10'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['string', Rule::in(ViolationStatementCategory::cases())],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:100'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $referenceImageUrl = null;

        if ($this->image) {
            $path = $this->image->storePublicly('violation-statements', 'digitalocean');
            $referenceImageUrl = Storage::disk('digitalocean')->url($path);
        }

        ViolationStatement::query()->create([
            'statement' => $this->statement,
            'weight' => $this->weight,
            'categories' => $this->categories,
            'keywords' => $this->keywords ?: null,
            'reference_image_url' => $referenceImageUrl,
        ]);

        $this->flushViolationStatementCache();

        Notification::make()
            ->title('Violation statement created.')
            ->success()
            ->send();

        $this->redirect(route('violation-statements.index'));
    }

    public function render(): View
    {
        return view('livewire.central.violation-statements.create');
    }

    private function flushViolationStatementCache(): void
    {
        foreach (ViolationStatementCategory::cases() as $category) {
            Cache::forget('violation_statements.'.$category->value);
        }
    }
}
