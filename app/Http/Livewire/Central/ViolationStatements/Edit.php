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

class Edit extends Component
{
    use WithFileUploads;

    public ViolationStatement $violationStatement;
    public string $statement = '';
    public array $keywords = [];
    public ?int $weight = null;
    public array $categories = [];
    public $newImage;

    public function mount(): void
    {
        $this->statement = $this->violationStatement->statement;
        $this->keywords = $this->violationStatement->keywords ?? [];
        $this->weight = $this->violationStatement->weight;
        $this->categories = $this->violationStatement->categories;
    }

    public function delete(): void
    {
        $this->deleteStoredImage();

        $this->violationStatement->delete();

        $this->flushViolationStatementCache();

        $this->redirect(route('violation-statements.index'));
    }

    public function removeImage(): void
    {
        $this->deleteStoredImage();

        $this->violationStatement->update(['reference_image_url' => null]);
    }

    public function update(): void
    {
        $this->validate([
            'statement' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:1', 'max:10'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['string', Rule::in(ViolationStatementCategory::cases())],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:100'],
            'newImage' => ['nullable', 'image', 'max:4096'],
        ]);

        $referenceImageUrl = $this->violationStatement->reference_image_url;

        if ($this->newImage) {
            $path = $this->newImage->storePublicly('violation-statements', 'digitalocean');
            $referenceImageUrl = Storage::disk('digitalocean')->url($path);
        }

        $this->violationStatement->update([
            'statement' => $this->statement,
            'weight' => $this->weight,
            'categories' => $this->categories,
            'keywords' => $this->keywords ?: null,
            'reference_image_url' => $referenceImageUrl,
        ]);

        $this->flushViolationStatementCache();

        Notification::make()
            ->title('Violation statement updated.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.violation-statements.edit')
            ->layout('layouts.app');
    }

    private function deleteStoredImage(): void
    {
        $url = $this->violationStatement->reference_image_url;

        if ($url) {
            Storage::disk('digitalocean')->delete(ltrim(parse_url($url, PHP_URL_PATH), '/'));
        }
    }

    private function flushViolationStatementCache(): void
    {
        foreach (ViolationStatementCategory::cases() as $category) {
            Cache::forget('violation_statements.'.$category->value);
        }
    }
}
