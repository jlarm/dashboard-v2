<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\StoreSettings;
use App\Models\User;
use Livewire\Component;

class IspForm extends Component
{
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
        $this->owner = User::role('Owner')->first()->name ?? '';
        $this->ownerp = User::role('Owner')->first()->phone ?? '';
        $this->gm = User::role('General Manager')->first()->name ?? '';
        $this->gmp = User::role('General Manager')->first()->phone ?? '';
        $this->bsm = User::role('Body Shop Manager')->first()->name ?? '';
        $this->bsmp = User::role('Body Shop Manager')->first()->phone ?? '';
        $this->pm = User::role('Parts Manager')->first()->name ?? '';
        $this->pmp = User::role('Parts Manager')->first()->phone ?? '';
        $this->sm = User::role('Service Manager')->first()->name ?? '';
        $this->smp = User::role('Service Manager')->first()->phone ?? '';
        $this->qi = User::role('Qualified Individual')->first()->name ?? '';
        $this->qip = User::role('Qualified Individual')->first()->phone ?? '';
        $this->pepn = StoreSettings::first()->police_emergency_phone ?? '';
        $this->pnepn = StoreSettings::first()->police_non_emergency_phone ?? '';
        $this->fepn = StoreSettings::first()->fire_emergency_phone ?? '';
        $this->fnepn = StoreSettings::first()->fire_non_emergency_phone ?? '';
        $this->alarmSystem = StoreSettings::first()->fire_alarm_type ?? '';
        $this->burglarSystem = StoreSettings::first()->burglar_alarm_type ?? '';
    }

    protected $rules = [
        'qi' => 'required',
        'qip' => 'required',
        'sm' => 'required',
        'smp' => 'required',
        'pm' => 'required',
        'pmp' => 'required',
        'bsm' => 'required',
        'bsmp' => 'required',
        'gm' => 'required',
        'gmp' => 'required',
        'owner' => 'required',
        'ownerp' => 'required',
        'pepn' => 'required',
        'pnepn' => 'required',
        'fepn' => 'required',
        'fnepn' => 'required',
        'alarmSystem' => 'required',
        'burglarSystem' => 'required',
        'signature' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $fName = \Str::of($this->qi)->replace(' ', '')->lower();
        $cTime = now()->format('YmdHis');
        $fileName = $fName.$cTime.'.png';

        Isp::create([
            'logged_in_user' => auth()->user()->id,
            'qualified_individual_name' => $this->qi,
            'qualified_individual_phone' => $this->qip,
            'service_manager_name' => $this->sm,
            'service_manager_phone' => $this->smp,
            'parts_manager_name' => $this->pm,
            'parts_manager_phone' => $this->pmp,
            'body_shop_manager_name' => $this->bsm,
            'body_shop_manager_phone' => $this->bsmp,
            'general_manager_name' => $this->gm,
            'general_manager_phone' => $this->gmp,
            'owner_name' => $this->owner,
            'owner_phone' => $this->ownerp,
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
        return view('livewire.dealer.manual.isp-form');
    }
}
