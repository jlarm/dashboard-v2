<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use App\Models\User;
use Livewire\Component;

class SingleStoreOshaForm extends Component
{
    public Store $store;

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

    public $pepn;

    public $pnepn;

    public $fepn;

    public $fnepn;

    public $alarmSystem;

    public $burglarSystem;

    public $signature;

    public function mount()
    {
        $settings = StoreSettings::where('store_id', $this->store->id)->first();

        $this->qi = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Qualified Individual');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->qip = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Qualified Individual');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->sm = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Service Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->smp = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Service Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->pm = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Parts Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->pmp = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Parts Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->bsm = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Body Shop Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->bsmp = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Body Shop Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->gm = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'General Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->gmp = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'General Manager');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->owner = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Owner');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->name ?? '';
        $this->ownerp = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Owner');
            })
            ->whereHas('stores', function ($query) {
                $query->where('store_id', $this->store->id);
            })
            ->first()->phone ?? '';

        $this->pepn = $settings->police_emergency_phone ?? '';
        $this->pnepn = $settings->police_non_emergency_phone ?? '';
        $this->fepn = $settings->fire_emergency_phone ?? '';
        $this->fnepn = $settings->fire_non_emergency_phone ?? '';
        $this->alarmSystem = $settings->fire_alarm_type ?? '';
        $this->burglarSystem = $settings->burglar_alarm_type ?? '';
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

        Osha::create([
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
        return view('livewire.dealer.store.single-store-osha-form')->layout('components.dealer-app');
    }
}
