<?php

namespace App\Http\Livewire\Dealer\Manual\Cms;

use App\Jobs\Manuals\GenerateCmsManualJob;
use App\Jobs\Manuals\UploadCmsToDigitalOceanJob;
use App\Models\CmsManual;
use App\Models\Dealer\Store;
use App\Models\Role;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Livewire\Component;

class Create extends Component
{
    public $store;

    public $qi;

    public $qiRole;

    public $standard_dpp_rate;

    public $adoption_approval_name_one;

    public $adoption_approval_signature_one;

    public $adoption_approval_name_two;

    public $adoption_approval_signature_two;

    public $adoption_approval_name_three;

    public $adoption_approval_signature_three;

    public $dealer_participation_name;

    public $dealer_participation_signature;

    public $appointment_program_name_one;

    public $appointment_program_signature_one;

    public $appointment_program_name_two;

    public $appointment_program_signature_two;

    public $appointment_program_name_three;

    public $appointment_program_signature_three;

    public $acknowledgement_name;

    public $acknowledgement_signature;

    public function mount(Request $request)
    {

        $storeName = $request->get('store')->name ?? Store::first()->name;
        $this->store = Store::where('name', $storeName)->first();

        $this->qiRole = Role::where('name', 'Qualified Individual')->first();

        $this->loadQi();

        $this->standard_dpp_rate = $this->store->standard_dpp_rate;

        if ($this->standard_dpp_rate === null) {
            $this->sendStandardDppRateMissingNotification();
        }
    }

    private function loadQi()
    {
        if (tenant('locations')) {
            $this->qi = User::whereHas('roles', function ($query) {
                $query->where('name', 'Qualified Individual');
            })->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })->pluck('name')->first();
        } else {
            $this->qi = User::role('Qualified Individual')->pluck('name')->first() ?? null;
        }

        if (! $this->qi) {
            $this->sendQiMissingNotification();
        }
    }

    private function sendQiMissingNotification()
    {
        $route = (! tenant('locations')) ? route('dealer.employees.index') : route('dealer.stores.employees', $this->store);
        Notification::make()
            ->title('Qualified Individual Missing')
            ->body('Please assign an employee the Qualified Individual role.')
            ->warning()
            ->persistent()
            ->actions([
                Action::make('view')
                    ->button()
                    ->url($route),
            ])
            ->send();
    }

    private function sendStandardDppRateMissingNotification()
    {
        $route = (! tenant('locations')) ? route('dealer.dealer.settings') : route('dealer.stores.settings', $this->store);
        Notification::make()
            ->title('Standard DPP Rate Missing')
            ->body('Please set the standard DPP rate in the Dealer Settings.')
            ->warning()
            ->persistent()
            ->actions([
                Action::make('view')
                    ->button()
                    ->url($route),
            ])
            ->send();
    }

    protected $rules = [
        'qi' => 'required',
        'standard_dpp_rate' => 'required',
        'adoption_approval_name_one' => 'nullable',
        'adoption_approval_signature_one' => 'nullable',
        'adoption_approval_name_two' => 'nullable',
        'adoption_approval_signature_two' => 'nullable',
        'adoption_approval_name_three' => 'nullable',
        'adoption_approval_signature_three' => 'nullable',
        'dealer_participation_name' => 'nullable',
        'dealer_participation_signature' => 'nullable',
        'appointment_program_name_one' => 'nullable',
        'appointment_program_signature_one' => 'nullable',
        'appointment_program_name_two' => 'nullable',
        'appointment_program_signature_two' => 'nullable',
        'appointment_program_name_three' => 'nullable',
        'appointment_program_signature_three' => 'nullable',
        'acknowledgement_name' => 'required',
        'acknowledgement_signature' => 'required',
    ];

    public function create()
    {

        $this->validate();

        if ($this->adoption_approval_name_one) {
            $aanOne = \Str::of($this->adoption_approval_name_one)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }
        if ($this->adoption_approval_name_two) {
            $aanTwo = \Str::of($this->adoption_approval_name_two)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }
        if ($this->adoption_approval_name_three) {
            $aanThree = \Str::of($this->adoption_approval_name_three)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }

        if ($this->dealer_participation_name) {
            $dpn = \Str::of($this->dealer_participation_name)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }

        if ($this->appointment_program_name_one) {
            $apnOne = \Str::of($this->appointment_program_name_one)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }
        if ($this->appointment_program_name_two) {
            $apnTwo = \Str::of($this->appointment_program_name_two)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }
        if ($this->appointment_program_name_three) {
            $apnThree = \Str::of($this->appointment_program_name_three)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }

        if ($this->acknowledgement_name) {
            $an = \Str::of($this->acknowledgement_name)->replace(' ', '_')->lower().'_'.now()->format('YmdHis').'.png';
        }

        $manual = CmsManual::create([
            'user_id' => auth()->user()->id,
            'store_id' => $this->store->id,
            'qi_name' => $this->qi,
            'standard_dpp_rate' => $this->standard_dpp_rate[0],
            'adoption_approval_name_one' => $this->adoption_approval_name_one,
            'adoption_approval_signature_one' => $aanOne ?? '',
            'adoption_approval_name_two' => $this->adoption_approval_name_two,
            'adoption_approval_signature_two' => $aanTwo ?? '',
            'adoption_approval_name_three' => $this->adoption_approval_name_three,
            'adoption_approval_signature_three' => $aanThree ?? '',
            'dealer_participation_program_name' => $this->dealer_participation_name,
            'dealer_participation_program_signature' => $dpn ?? '',
            'appointment_program_name_one' => $this->appointment_program_name_one,
            'appointment_program_signature_one' => $apnOne ?? '',
            'appointment_program_name_two' => $this->appointment_program_name_two,
            'appointment_program_signature_two' => $apnTwo ?? '',
            'appointment_program_name_three' => $this->appointment_program_name_three,
            'appointment_program_signature_three' => $apnThree ?? '',
            'acknowledgement_name' => $this->acknowledgement_name,
            'acknowledgement_signature' => $an ?? '',
        ]);

        if ($this->adoption_approval_signature_one) {
            \Storage::put('cms-signatures/'.$aanOne, base64_decode(\Str::of($this->adoption_approval_signature_one)->after(',')));
        }
        if ($this->adoption_approval_signature_two) {
            \Storage::put('cms-signatures/'.$aanTwo, base64_decode(\Str::of($this->adoption_approval_signature_two)->after(',')));
        }
        if ($this->adoption_approval_signature_three) {
            \Storage::put('cms-signatures/'.$aanThree, base64_decode(\Str::of($this->adoption_approval_signature_three)->after(',')));
        }

        if ($this->dealer_participation_signature) {
            \Storage::put('cms-signatures/'.$dpn, base64_decode(\Str::of($this->dealer_participation_signature)->after(',')));
        }

        if ($this->appointment_program_signature_one) {
            \Storage::put('cms-signatures/'.$apnOne, base64_decode(\Str::of($this->appointment_program_signature_one)->after(',')));
        }
        if ($this->appointment_program_signature_two) {
            \Storage::put('cms-signatures/'.$apnTwo, base64_decode(\Str::of($this->appointment_program_signature_two)->after(',')));
        }
        if ($this->appointment_program_signature_three) {
            \Storage::put('cms-signatures/'.$apnThree, base64_decode(\Str::of($this->appointment_program_signature_three)->after(',')));
        }

        if ($this->acknowledgement_signature) {
            \Storage::put('cms-signatures/'.$an, base64_decode(\Str::of($this->acknowledgement_signature)->after(',')));
        }

        \Bus::chain([
            new GenerateCmsManualJob($manual),
            new UploadCmsToDigitalOceanJob($manual),
        ])->dispatch();

        (! tenant('locations')) ? $this->redirect(route('dealer.manual.cms.index', $this->store)) : $this->redirect(route('dealer.stores.manuals.cms.index', $this->store));
    }

    public function render()
    {
        return view('livewire.dealer.manual.cms.create')->layout('components.dealer-app');
    }
}
