<?php

namespace App\Http\Controllers\Central\Dealership;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealership\CreateRequest;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use App\Notifications\NewDealershipNotification;
use Illuminate\Support\Facades\DB;
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
            'locations' => $validated['locations'],
        ]);

        auth()->user()->dealerships()->attach($dealer->id);

        $dealer->createDomain($tenantDomain);

        $dealer->run(function () use ($validated) {
            $this->createStoreAndSettings($validated);
            $this->createUserAndAssignRole($validated);
            $this->syncCentralCourses();
        });

        $this->sendNotification($validated['name']);

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Dealership Created');
        session()->flash('flash.message', $validated['name'].' has successfully been created.');

        return redirect()->route('dealerships.index');
    }

    private function sendNotification($dealerName)
    {
        $user = User::where('email', 'jlohr@autorisknow.com')->firstOrFail();
        $user->notify(new NewDealershipNotification($dealerName));
    }

    private function createStoreAndSettings($validated)
    {
        if (! $validated['locations']) {
            $store = Store::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['zip_code'],
                'phone' => $validated['phone'],
                'fax' => $validated['fax'],
            ]);

            ScanSetting::create(['store_id' => $store->id]);
            EmployeeList::create(['store_id' => $store->id]);
        }
    }

    private function createUserAndAssignRole($validated)
    {
        $initials = $this->getInitialsFromName();

        $user = User::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone,
            'password' => bcrypt('Autorisknow'.$initials.'!'),
        ]);

        $this->assignRoleToUser($user);

        $this->createSuperAdmins($user);
    }

    private function getInitialsFromName()
    {
        $words = explode(' ', auth()->user()->name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }

        return $initials;
    }

    private function assignRoleToUser($user)
    {
        if ($user->name == 'Joe Lohr' || $user->name == 'Terry Dortch' || $user->name == 'Mike Backer') {
            $user->assignRole('super-admin');
        } else {
            $user->assignRole('Consultant');
        }
    }

    private function createSuperAdmins($user)
    {
        $superAdmins = [
            'Joe Lohr' => ['email' => 'jlohr@autorisknow.com', 'phone' => '2243586930', 'password' => 'AutorisknowJL!'],
            'Terry Dortch' => ['email' => 'tdortch@autorisknow.com', 'phone' => '8156704651', 'password' => 'AutorisknowTD!'],
            'Mike Backer' => ['email' => 'mbacker@autorisknow.com', 'phone' => '8043823021', 'password' => 'AutorisknowMB!'],
        ];

        foreach ($superAdmins as $name => $details) {
            if ($user->name != $name) {
                $superAdmin = User::create([
                    'name' => $name,
                    'email' => $details['email'],
                    'phone' => $details['phone'],
                    'password' => bcrypt($details['password']),
                ]);
                $superAdmin->assignRole('super-admin');
            }
        }
    }

    private function syncCentralCourses(): void
    {
        // Get central courses first
        $centralCourses = tenancy()->central(function () {
            return \App\Models\Course::query()
                ->select(['id', 'slug', 'slides', 'questions'])
                ->get();
        });

        // Now we're in tenant context since we're inside dealer->run()
        foreach ($centralCourses as $centralCourse) {

            $tenantCourse = \App\Models\Dealer\Course::where('slug', $centralCourse->slug)->first();

            if ($tenantCourse) {
                try {
                    // Force decode/encode to ensure proper JSON serialization
                    $slides = json_decode(json_encode($centralCourse->slides), true);
                    $questions = json_decode(json_encode($centralCourse->questions), true);

                    DB::statement('UPDATE courses SET slides = ?, questions = ? WHERE id = ?', [
                        json_encode($slides),
                        json_encode($questions),
                        $tenantCourse->id,
                    ]);

                } catch (\Exception $e) {
                    \Log::error('Failed to update tenant course: '.$e->getMessage());
                }
            } else {
                \Log::info('No matching tenant course found for slug: '.$centralCourse->slug);
            }
        }
    }
}
