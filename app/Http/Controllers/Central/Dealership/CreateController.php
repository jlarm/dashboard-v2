<?php

namespace App\Http\Controllers\Central\Dealership;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealership\CreateRequest;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

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

            $pass = $validated['password'];
            $name = $validated['name'];
            $address = $validated['address'];
            $city = $validated['city'];
            $state = $validated['state'];
            $zip_code = $validated['zip_code'];
            $phone = $validated['phone'];
            $fax = $validated['fax'];
            $url = $validated['url'];
            $locations = $validated['locations'];

            $dealer->run(function () use ($pass, $name, $address, $city, $state, $zip_code, $phone, $fax, $url, $locations) {

                if(!$locations) {
                    $store = Store::create([
                        'name' => $name,
                        'address' => $address,
                        'city' => $city,
                        'state' => $state,
                        'postal_code' => $zip_code,
                        'phone' => $phone,
                        'fax' => $fax,
                        'website' => $url,
                    ]);

                    ScanSetting::create(['store_id' => $store->id]);
                    EmployeeList::create(['store_id' => $store->id]);
                }

                $user = User::create([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone,
                    'password' => bcrypt($pass),
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

            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('dealerships.index'));
    }
}
