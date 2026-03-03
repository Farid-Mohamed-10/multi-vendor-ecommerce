<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $users = User::query();
        $allRoles = Role::get();

        if ($search) {
            $users = $users->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        if ($roleFilter) {
            $users = $users->whereHas('roles', function ($query) use ($roleFilter) {
                $query->where('name', $roleFilter);
            });
        }

        $users = $users->paginate(10)->withQueryString();

        return view('admin-dashboard.users.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $roles = Role::all();
        return view('admin-dashboard.users.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $role = $data['role'];
        unset($data['role']);
        $user = User::create($data);

        $user->assignRole($role);

        return redirect()->route('admin-dashboard.users.index')->with('success', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin-dashboard.users.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // $roles = Role::all();
        return view('admin-dashboard.users.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $role = $data['role'] ?? null;
        unset($data['role']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        if ($role) {
            $user->syncRoles([$role]);
        }

        return redirect()->route('admin-dashboard.users.index')->with('success', 'User Information Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User Deleted Successfully');
    }
}
