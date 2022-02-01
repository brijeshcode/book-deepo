<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:access users']);
        $this->middleware(['can:create users'])->only(['create', 'store']);
        $this->middleware(['can:edit users'])->only(['edit', 'update']);
    }

    public function index()
    {
        $users = User::when($request->search, function ($query, $search){
                $query->where('name', 'like', '%'. $search . '%');
                $query->orWhere('email', 'like', '%'. $search . '%');
                $query->orWhere('note', 'like', '%'. $search . '%');
            })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString()
        ;
        return Inertia::render('Setup/Users/Index' , compact('users'));
    }

    public function create()
    {
        $schools = School::select('id', 'name')->whereActive(1)->get();
        $roles = Role::select('id', 'name')->with('permissions:id')->orderBy('name')->get();
        $permissions = Permission::select('id', 'name')->orderBy('id' , 'asc')->get();
        return Inertia::render('Setup/Users/Create', compact('roles', 'permissions','schools'));
    }

    public function store(Request $request)
    {
        $this->validateInput($request);
        \DB::transaction(function() use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'active' => $request->active,
                'note' => $request->note,
            ]);
            if ($request->has('userSchools')) {
                $user->schools()->sync(array_column($request->userSchools, 'id'));
            }
            $user->assignRole($request->role);
            // $user->syncPermissions($request->permission);
        });

        return redirect(route('users.index'))->with('type', 'success')->with('message', 'User added successfully !!');
    }


    public function edit(Request $request, $user)
    {
        $schools = School::select('id', 'name')->whereActive(1)->get();
        $editUser = User::with('schools:id,name' , 'roles:id,name' )->findorFail($user);
        $roles = Role::select('id', 'name')->with('permissions:id')->orderBy('name')->get();
        $permissions = Permission::select('id', 'name')->orderBy('id' , 'asc')->get();
        return Inertia::render('Setup/Users/Create', compact('editUser', 'schools', 'roles', 'permissions'));
    }

    public function update(Request $request, $user)
    {
        $user = User::findorFail($user);
        $this->updateValidation($request, $user);

        \DB::transaction(function() use ($request, $user) {
            $user->syncRoles($request->role);
            if ($request->password == '') {
                $user->update($request->only('name', 'email', 'note', 'active'));
            }else{
                $user->update($request->only('name', 'email', 'password', 'note', 'active'));
            }
            if ($request->has('userSchools')) {
                $user->schools()->sync(array_column($request->userSchools, 'id'));
            }

        });
        return redirect(route('users.index'))->with('type', 'success')->with('message', 'User updated successfully !!');
    }

    public function destroy(User $user)
    {
        // code...
    }

    private function validateInput($request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);
    }

    private function updateValidation($request, User $user)
    {
        $request->validate([
            'name' => 'required||max:255',
            'email' => 'required|email',
            'name' => [Rule::unique('users')->ignore($user->id)],
            'email' => [Rule::unique('users')->ignore($user->id)],
            'role' => 'required'
        ],
        [
            'name.required' => 'User name is empty.',
            'name.unique' => 'User name is not unique.',
            'email.required' => 'User email is empty.',
            'email.unique' => 'User email is already taken.',
        ]
    );
    }
}
