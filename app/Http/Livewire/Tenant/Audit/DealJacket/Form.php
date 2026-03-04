<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use App\Models\DealJacketQuestion;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class Form extends Component
{
    public Store $store;
    public DealJacketGroup $dealJacketGroup;
    public ?DealJacket $dealJacket = null;
    public array $questions = [];
    public ?string $auditDate = null;
    public ?string $dateOfDealJacket = null;
    public string $customerName = '';
    public string $customerDealNumber = '';
    public ?string $financeManager = null;
    public string $mileage = '';
    public string $purchaseType = '';
    public string $vehicleType = '';
    public array $responses = [];

    public function mount(DealJacketGroup $dealJacketGroup, ?DealJacket $dealJacket = null): void
    {
        $this->store = Store::query()->find(app('currentStore'));
        $this->dealJacketGroup = $dealJacketGroup;
        $this->dealJacket = $dealJacket;

        if ($dealJacket?->exists) {
            $this->auditDate = $dealJacket->audit_date->format('Y-m-d');
            $this->dateOfDealJacket = $dealJacket->date_of_deal_jacket->format('Y-m-d');
            $this->customerName = $dealJacket->customer_name ?? '';
            $this->customerDealNumber = $dealJacket->customer_deal_number ?? '';
            $this->financeManager = $dealJacket->user_id === null ? 'house' : (string) $dealJacket->user_id;
            $this->mileage = $dealJacket->mileage ?? '';
            $this->purchaseType = $dealJacket->purchase_type ?? '';
            $this->vehicleType = $dealJacket->vehicle_type ?? '';

            $this->loadQuestions();

            $this->responses = $dealJacket->responses ?? [];
        }

        if (! $this->auditDate) {
            $this->auditDate = now()->format('Y-m-d');
        }
    }

    public function managers(): array
    {
        return User::query()->where('department_id', 6)
            ->role('Manager')
            ->get()
            ->toArray();
    }

    public function updated($property): void
    {
        if (in_array($property, ['purchaseType', 'vehicleType'])) {
            $this->loadQuestions();
        }
    }

    public function loadQuestions(): void
    {
        if ($this->purchaseType === '' || $this->purchaseType === '0' || ($this->vehicleType === '' || $this->vehicleType === '0')) {
            $this->questions = [];
            $this->responses = [];

            return;
        }

        $questions = tenancy()->central(fn () => DealJacketQuestion::query()
            ->get()
            ->filter(fn ($q): bool => in_array($this->purchaseType, $q->categories, true)
                && in_array($this->vehicleType, $q->categories, true)
            ));

        $this->questions = $questions->map(fn ($q): array => [
            'id' => $q->id,
            'question' => $q->question,
            'weight' => $q->weight ?? 1,
        ])->values()->toArray();

        $this->responses = $questions->map(fn ($question): array => [
            'statement' => $question->statement,
            'answer' => null,
            'high_risk' => false,
            'comment' => null,
        ])->values()->toArray();
    }

    public function submit(): void
    {
        Gate::authorize('create', DealJacket::class);

        $this->validate();

        $data = [
            'audit_date' => $this->auditDate,
            'date_of_deal_jacket' => $this->dateOfDealJacket,
            'customer_name' => $this->customerName,
            'customer_deal_number' => $this->customerDealNumber,
            'user_id' => $this->financeManager === 'house'
                ? null
                : ($this->financeManager !== null && $this->financeManager !== '' ? (int) $this->financeManager : null),
            'mileage' => $this->mileage,
            'purchase_type' => $this->purchaseType,
            'vehicle_type' => $this->vehicleType,
            'responses' => $this->responses,
            'total_passed' => $this->totalPassed(),
            'total_failed' => $this->totalFailed(),
            'total_high_risk' => $this->totalHighRisk(),
            'percentage' => $this->calculatePercentage(),
        ];

        if ($this->dealJacket?->exists) {
            $this->dealJacket->update($data);

            Notification::make()
                ->title('Deal Jacket Audit Updated')
                ->success()
                ->send();

            return;
        }

        $this->dealJacketGroup->dealJackets()->create($data);

        Notification::make()
            ->title('Deal Jacket Audit Created')
            ->success()
            ->send();

        $this->reset([
            'auditDate',
            'dateOfDealJacket',
            'customerName',
            'customerDealNumber',
            'financeManager',
            'mileage',
            'purchaseType',
            'vehicleType',
            'responses',
            'questions',
        ]);

        $this->auditDate = now()->format('Y-m-d');
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.form');
    }

    protected function rules(): array
    {
        return [
            'auditDate' => ['required', 'date'],
            'dateOfDealJacket' => ['required', 'date'],
            'customerName' => ['required', 'string'],
            'customerDealNumber' => ['required', 'string'],
            'financeManager' => ['required', 'string'],
            'mileage' => ['required', 'string'],
            'purchaseType' => ['required', 'string'],
            'vehicleType' => ['required', 'string'],
            'responses' => ['required', 'array', 'min:1'],
            'responses.*.answer' => ['required', 'in:yes,no,na'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'responses.*.answer' => 'question answer',
        ];
    }

    private function totalPassed(): int
    {
        if ($this->responses === []) {
            return 0;
        }

        $totalPassed = 0;

        foreach ($this->responses as $response) {
            if ($response['answer'] === 'yes') {
                $totalPassed++;
            }
        }

        return $totalPassed;
    }

    private function totalFailed(): int
    {
        if ($this->responses === []) {
            return 0;
        }

        $totalFailed = 0;

        foreach ($this->responses as $response) {
            if ($response['answer'] === 'no') {
                $totalFailed++;
            }
        }

        return $totalFailed;
    }

    private function totalHighRisk(): int
    {
        if ($this->responses === []) {
            return 0;
        }

        $totalHighRisk = 0;

        foreach ($this->responses as $response) {
            if ($response['high_risk'] === true) {
                $totalHighRisk++;
            }
        }

        return $totalHighRisk;
    }

    private function calculatePercentage(): int
    {
        if ($this->responses === []) {
            return 0;
        }

        $totalWeight = 0;
        $earnedWeight = 0;

        foreach ($this->responses as $index => $response) {
            $answer = $response['answer'] ?? null;

            // Exclude N/A responses from percentage calculation
            if ($answer === 'na') {
                continue;
            }

            $weight = $this->questions[$index]['weight'] ?? 1;
            $totalWeight += $weight;

            if ($answer === 'yes') {
                $earnedWeight += $weight;
            }

            if ($response['high_risk'] === true) {
                $earnedWeight -= $weight * 0.5;
            }
        }

        return $totalWeight > 0 ? (int) round(($earnedWeight / $totalWeight) * 100) : 0;
    }
}
