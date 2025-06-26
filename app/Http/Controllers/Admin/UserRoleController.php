<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]); // reemplaza los roles anteriores
        return back()->with('success', 'Rol asignado correctamente');
    }

    public function editRole(User $user)
{
    $roles = Role::all(); // admin, editor, vendedor
    return view('admin.users.edit-role', compact('user', 'roles'));
}

public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|exists:roles,name',
    ]);

    // Reemplaza el rol anterior por el nuevo
    $user->syncRoles([$request->role]);

    return redirect()->route('admin.users.index')->with('success', 'Rol actualizado correctamente.');
}

}
