<?php

namespace App\Http\Controllers\Central\Role;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class EditController extends Controller
{
    public function __invoke(Role $role)
    {
        return view('central.role.edit', compact('role'));
    }
}
