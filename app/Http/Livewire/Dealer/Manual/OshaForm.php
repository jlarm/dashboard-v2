<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use Livewire\Component;

class OshaForm extends Component
{
    public $employeeList;
    public $store_id;
    public $qi;
    public $qit = 'Qualified Individual';
    public $qip;
    public $sm;
    public $smt = 'Service Manager';
    public $smp;
    public $pm;
    public $pmt = 'Parts Manager';
    public $pmp;
    public $bsm;
    public $bsmt = 'Body Shop Manager';
    public $bsmp;
    public $gm;
    public $gmt = 'General Manager';
    public $gmp;
    public $owner;
    public $ownert = 'Owner';
    public $ownerp;
    public $pepn;
    public $pnepn;
    public $fepn;
    public $fnepn;
    public $alarmSystem;
    public $burglarSystem;
    public $signature;

    public function mount()
    {
        $this->employeeList = EmployeeList::first();
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
        $this->pepn = Store::first()->police_emergency_phone ?? '';
        $this->pnepn = Store::first()->police_non_emergency_phone ?? '';
        $this->fepn = Store::first()->fire_emergency_phone ?? '';
        $this->fnepn = Store::first()->fire_non_emergency_phone ?? '';
        $this->alarmSystem = Store::first()->fire_alarm_type ?? '';
        $this->burglarSystem = Store::first()->burglar_alarm_type ?? '';
    }

    protected $rules = [
        'signature' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $fName = \Str::of(auth()->user()->name)->replace(' ', '')->lower();
        $cTime = now()->format('YmdHis');
        $fileName = $fName.$cTime.'.png';

        Osha::create([
            'store_id' => $this->employeeList->store_id,
            'user_id' => auth()->user()->id,
            'qualified_individual_name' =>  $this->employeeList->qualified_individual_name ?? '',
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

        \Storage::put('osha-signatures/'.$fileName, base64_decode(\Str::of($this->signature)->after(',')));

        $this->redirect(route('dealer.manual.index'));
    }
    public function render()
    {
        return view('livewire.dealer.manual.osha-form');
    }
}
