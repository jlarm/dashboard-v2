<?php

namespace App\Http\Controllers\Central\Role;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class EditController extends Controller
{
    public function __invoke(Role $role): View
    {
        return view('central.role.edit', compact('role'));
    }
}
