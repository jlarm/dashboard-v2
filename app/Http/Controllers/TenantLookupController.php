<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealership;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantLookupController extends Controller
{
    public function index(): Factory|View
    {
        return view('central.tenant-lookup.index');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->email;
        /** @var Collection<int, Dealership> $tenants */
        $tenants = Dealership::with('domains')->get();

        foreach ($tenants as $tenant) {
            /** @var Dealership $tenant */
            $found = $tenant->run(fn () => DB::table('users')
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->whereNull('roles.name')
                ->orWhere(function ($q): void {
                    $q->whereNotIn('roles.name', ['super-admin', 'consultant']);
                })
                ->where('email', $email)->exists());

            if ($found) {
                $domain = $tenant->domain();

                return redirect("https://{$domain}/login?email=".urlencode($email));
            }
        }

        return back()->withErrors([
            'email' => 'The provided email address does not exist in our records.',
        ]);
    }
}
