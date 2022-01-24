<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->paginate(10);
        return Inertia::render('Setup/Roles/Index' , compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::select('id', 'name')->orderBy('id' , 'asc')->get();
        return Inertia::render('Setup/Roles/Create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $this->validateInput($request);
        \DB::transaction(function() use ($request) {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'guard_name' => 'web'
            ]);
            $role->syncPermissions($request->permissions);
            // $role->givePermissionTo([1,2,3]);
        });

        return redirect(route('roles.index'))->with('type', 'success')->with('message', 'New Role added successfully !!');
    }

    public function edit($role)
    {
        $role = Role::select('id','name', 'description')->with('permissions:id,name,description')->where('id', $role)->first();
        $permissions = Permission::select('id', 'name')->orderBy('id' , 'asc')->get();
        return Inertia::render('Setup/Roles/Create', compact('permissions', 'role'));
    }

    public function update(Request $request, $role)
    {
        $role = Role::findorFail($role);
        $this->validateInputforUpdate($request, $role);
        $role->update($request->only('name', 'description'));
        $role->syncPermissions($request->permissions);
        return redirect(route('roles.index'))->with('type', 'success')->with('message', 'Role Updated successfully !!');
    }

     private function validateInput($request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ],
        [
            'name.required' => 'Name of role is empty.',
            'name.unique' => 'Name of role is taken please add unique.',
        ]

        );
    }

    private function validateInputforUpdate($request, $role )
    {
        $request->validate([
            'name' => 'required',
            'name' => [Rule::unique('roles')->ignore($role->id)],
        ],
        [
            'name.required' => 'Name of role is empty.',
            'name.unique' => 'Name of role is taken please add unique.',
        ]

        );
    }
}
