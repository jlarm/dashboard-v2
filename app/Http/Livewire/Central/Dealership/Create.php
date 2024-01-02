<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public $initials;

    public $address;

    public $city;

    public $state;

    public $zip_code;

    public $phone;

    public $fax;

    public $domain;

    public $url;

    public $locations = false;

    public $password;

    public function mount()
    {
        // get initials of current users name
        $name = auth()->user()->name;
        $name = explode(' ', $name);
        $initials = '';
        foreach ($name as $n) {
            $initials .= $n[0];
        }
        $this->initials = strtoupper($initials);

    }

    protected $rules = [
        'name' => ['required', 'string', 'max:255', 'unique:dealerships'],
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'zip_code' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        'fax' => ['nullable', 'string', 'max:255'],
        'domain' => ['required', 'string', 'max:255', 'unique:domains'],
        'url' => ['required', 'string', 'max:255', 'url'],
        'locations' => ['nullable', 'boolean'],
        'password' => ['required'],
    ];

    public function create()
    {
        $validated = $this->validate();

        $tenantDomain = $validated['domain'].'.'.config('tenancy.central_domains')[0];

        try {
            $dealer = Dealership::create([
                'user_id' => auth()->user()->id,
                'name' => $validated['name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'phone' => $validated['phone'],
                'fax' => $validated['fax'],
                'domain' => $tenantDomain,
                'url' => $validated['url'],
                'locations' => $validated['locations'],
            ]);

            $dealer->createDomain($tenantDomain, $validated['url']);

            $name = $validated['name'];
            $address = $validated['address'];
            $city = $validated['city'];
            $state = $validated['state'];
            $zip_code = $validated['zip_code'];
            $phone = $validated['phone'];
            $fax = $validated['fax'];
            $url = $validated['url'];

            $dealer->run(function () use ($name, $address, $city, $state, $zip_code, $phone, $fax, $url) {

                Store::create([
                    'name' => $name,
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'postal_code' => $zip_code,
                    'phone' => $phone,
                    'fax' => $fax,
                    'website' => $url,
                ]);

                $user = User::create([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone,
                    'password' => bcrypt('Autorisknow'.$this->initials.'!'),
                ]);

                if ($user->name == 'Joe Lohr' || $user->name == 'Terry Dortch' || $user->name == 'Mike Backer') {
                    $user->assignRole('super-admin');
                } else {
                    $user->assignRole('Consultant');
                }

                if ($user->name != 'Joe Lohr') {
                    $joe = User::create([
                        'name' => 'Joe Lohr',
                        'email' => 'jlohr@autorisknow.com',
                        'phone' => '2243586930',
                        'password' => bcrypt('AutorisknowJL!'),
                    ]);
                    $joe->assignRole('super-admin');
                }

                if ($user->name != 'Terry Dortch') {
                    $terry = User::create([
                        'name' => 'Terry Dortch',
                        'email' => 'tdortch@autorisknow.com',
                        'phone' => '8156704651',
                        'password' => bcrypt('AutorisknowTD!'),
                    ]);
                    $terry->assignRole('super-admin');
                }

                if ($user->name != 'Mike Backer') {
                    $mike = User::create([
                        'name' => 'Mike Backer',
                        'email' => 'mbacker@autorisknow.com',
                        'phone' => '8043823021',
                        'password' => bcrypt('AutorisknowMB!'),
                    ]);
                    $mike->assignRole('super-admin');
                }

                ScanSetting::create([]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.central.dealership.create', [
            'users' => User::whereNot('id', auth()->user()->id)
                ->get(),
        ]);
    }
}
