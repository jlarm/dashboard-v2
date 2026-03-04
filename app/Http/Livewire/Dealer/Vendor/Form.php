<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    private const QUESTION_COUNT = 22;

    public Vendor $vendor;
    public string $name = '';
    public string $contact_name = '';
    public ?string $signature = null;
    public ?string $q1a = null;
    public ?string $q1c = null;
    public ?string $q2a = null;
    public ?string $q2c = null;
    public ?string $q3a = null;
    public ?string $q3c = null;
    public ?string $q4a = null;
    public ?string $q4c = null;
    public ?string $q5a = null;
    public ?string $q5c = null;
    public ?string $q6a = null;
    public ?string $q6c = null;
    public ?string $q7a = null;
    public ?string $q7c = null;
    public ?string $q8a = null;
    public ?string $q8c = null;
    public ?string $q9a = null;
    public ?string $q9c = null;
    public ?string $q10a = null;
    public ?string $q10c = null;
    public ?string $q11a = null;
    public ?string $q11c = null;
    public ?string $q12a = null;
    public ?string $q12c = null;
    public ?string $q13a = null;
    public ?string $q13c = null;
    public ?string $q14a = null;
    public ?string $q14c = null;
    public ?string $q15a = null;
    public ?string $q15c = null;
    public ?string $q16a = null;
    public ?string $q16c = null;
    public ?string $q17a = null;
    public ?string $q17c = null;
    public ?string $q18a = null;
    public ?string $q18c = null;
    public ?string $q19a = null;
    public ?string $q19c = null;
    public ?string $q20a = null;
    public ?string $q20c = null;
    public ?string $q21a = null;
    public ?string $q21c = null;
    public ?string $q22a = null;
    public ?string $q22c = null;

    public function mount(Vendor $vendor): void
    {
        if ($vendor->signature) {
            $this->redirectToThankYou();
        }

        $this->vendor = $vendor;
        $this->name = $vendor->name;
        $this->contact_name = $vendor->contact_name;
    }

    public function submit(): RedirectResponse
    {
        $this->validate();

        $this->vendor->update($this->buildUpdateData());

        $this->storeSignature();

        return $this->redirectToThankYou();
    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.form');
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'signature' => ['required', 'string'],
        ];

        for ($i = 1; $i <= self::QUESTION_COUNT; $i++) {
            $rules["q{$i}a"] = ['required', 'string', 'in:yes,no,na'];
            $rules["q{$i}c"] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }

    /**
     * @return array<string, string|null>
     */
    private function buildUpdateData(): array
    {
        $data = [];

        for ($i = 1; $i <= self::QUESTION_COUNT; $i++) {
            $data["q{$i}a"] = $this->{"q{$i}a"};
            $data["q{$i}c"] = $this->{"q{$i}c"};
        }

        $data['signature'] = $this->generateSignatureFilename();

        return $data;
    }

    private function generateSignatureFilename(): string
    {
        $sanitizedName = Str::of($this->contact_name)->replace(' ', '')->lower();

        return $sanitizedName.now()->format('YmdHis').'.png';
    }

    private function storeSignature(): void
    {
        $filename = $this->vendor->signature;
        $signatureData = Str::of($this->signature)->after(',')->toString();

        Storage::put("signatures/{$filename}", base64_decode($signatureData));
    }

    private function redirectToThankYou(): RedirectResponse
    {
        return to_route('dealer.vendors.thankyou');
    }
}
