<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\RedFlag;

use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $store;
    public $employeeList;
    public $store_id;
    public $qi;
    public $qip;
    public $sm;
    public $smp;
    public $pm;
    public $pmp;
    public $bsm;
    public $bsmp;
    public $gm;
    public $gmp;
    public $owner;
    public $ownerp;
    public $signature;
    public $pepn;
    public $pnepn;
    public $fepn;
    public $fnepn;
    public $alarmSystem;
    public $burglarSystem;
    protected $rules = [
        'signature' => 'required',
    ];

    public function mount(Request $request): void
    {
        $storeName = $request->get('store')->name ?? Store::query()->first()->name;
        $this->store = Store::query()->where('name', $storeName)->first();
        $this->employeeList = EmployeeList::query()->where('store_id', $this->store->id)->first();
        $this->qi = $this->employeeList->qualified_individual_name ?? '';
        $this->qip = $this->employeeList->qualified_individual_phone ?? '';
        $this->sm = $this->employeeList->service_manager_name ?? '';
        $this->smp = $this->employeeList->service_manager_phone ?? '';
        $this->pm = $this->employeeList->parts_manager_name ?? '';
        $this->pmp = $this->employeeList->parts_manager_phone ?? '';
        $this->bsm = $this->employeeList->body_shop_manager_name ?? '';
        $this->bsmp = $this->employeeList->body_shop_manager_phone ?? '';
        $this->gm = $this->employeeList->general_manager_name ?? '';
        $this->gmp = $this->employeeList->general_manager_phone ?? '';
        $this->owner = $this->employeeList->owner_name ?? '';
        $this->ownerp = $this->employeeList->owner_phone ?? '';
        $this->pepn = $this->store->police_emergency_phone ?? '';
        $this->pnepn = $this->store->police_non_emergency_phone ?? '';
        $this->fepn = $this->store->fire_emergency_phone ?? '';
        $this->fnepn = $this->store->fire_non_emergency_phone ?? '';
        $this->alarmSystem = $this->store->fire_alarm_type ?? '';
        $this->burglarSystem = $this->store->burglar_alarm_type ?? '';
    }

    public function submit(): void
    {
        $this->validate();

        $fName = Str::of(auth()->user()->name)->replace(' ', '')->lower();
        $cTime = now()->format('YmdHis');
        $fileName = $fName.$cTime.'.png';

        $manual = RedFlag::query()->create([
            'store_id' => $this->employeeList->store_id,
            'user_id' => auth()->user()->id,
            'qualified_individual_name' => $this->employeeList->qualified_individual_name ?? '',
            'qualified_individual_phone' => $this->employeeList->qualified_individual_phone ?? '',
            'service_manager_name' => $this->employeeList->service_manager_name ?? '',
            'service_manager_phone' => $this->employeeList->service_manager_phone ?? '',
            'parts_manager_name' => $this->employeeList->parts_manager_name ?? '',
            'parts_manager_phone' => $this->employeeList->parts_manager_phone ?? '',
            'body_shop_manager_name' => $this->employeeList->body_shop_manager_name ?? '',
            'body_shop_manager_phone' => $this->employeeList->body_shop_manager_phone ?? '',
            'general_manager_name' => $this->employeeList->general_manager_name ?? '',
            'general_manager_phone' => $this->employeeList->general_manager_phone ?? '',
            'owner_name' => $this->employeeList->owner_name ?? '',
            'owner_phone' => $this->employeeList->owner_phone ?? '',
            'police_emergency_phone' => $this->pepn,
            'police_non_emergency_phone' => $this->pnepn,
            'fire_emergency_phone' => $this->fepn,
            'fire_non_emergency_phone' => $this->fnepn,
            'fire_alarm_type' => $this->alarmSystem,
            'burglar_alarm_type' => $this->burglarSystem,
            'signature' => $fileName,
        ]);

        Storage::put('red-flag-signatures/'.$fileName, base64_decode((string) Str::of($this->signature)->after(',')));

        Bus::chain([
            new GenerateRedFlagManualJob($manual),
            new UploadRedFlagToDigitalOceanJob($manual),
        ])->dispatch();

        (tenant('locations')) ? $this->redirect(route('dealer.stores.manuals.red-flag.index', $this->store)) : $this->redirect(route('dealer.manual.red-flag.index', $this->store));

    }

    public function render()
    {
        return view('livewire.dealer.manual.red-flag.create')->layout('components.dealer-app');
    }
}
