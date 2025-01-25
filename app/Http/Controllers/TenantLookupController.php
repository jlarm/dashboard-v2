<?php

namespace App\Http\Controllers;

use App\Models\Dealership;
use DB;
use Illuminate\Http\Request;

class TenantLookupController extends Controller
{
    public function index()
    {
        return view('central.tenant-lookup.index');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $tenants = Dealership::with('domains')->get();

        foreach ($tenants as $tenant) {
            $found = $tenant->run(function () use ($email) {
                return DB::table('users')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->whereNull('roles.name')
                    ->orWhere(function($q) {
                        $q->whereNotIn('roles.name', ['super-admin', 'consultant']);
                    })
                    ->where('email', $email)->exists();
            });

            if ($found) {
                $domain = $tenant->domains->first()->domain;
                return redirect("https://{$domain}/login?email=" . urlencode($email));
            }
        }

        return back()->withErrors([
            'email' => 'The provided email address does not exist in our records.',
        ]);
    }
}
