<?php

namespace App\Http\Controllers\Central\Dealership;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealership\CreateRequest;
use App\Models\Dealership;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $tenantDomain = $validated['domain'].'.'.config('tenancy.central_domains')[0];

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

//        $dealer->run(function () use ($pass) {
//            $user = User::create([
//                'name' => auth()->user()->name,
//                'email' => auth()->user()->email,
//                'phone' => auth()->user()->phone,
//                'password' => bcrypt($pass),
//            ]);
//            $user->assignRole('Consultant');
//        });

        return redirect(route('dealerships.index'));
    }
}
