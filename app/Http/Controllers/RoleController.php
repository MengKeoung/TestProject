<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('pages.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        return view('pages.roles.create', compact('permissions'));
    }

}
