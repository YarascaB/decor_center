<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function cambiarRol(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|exists:roles,name',
        ]);
    
        $usuario = User::findOrFail($id);
        $usuario->syncRoles([$request->rol]); // reemplaza el rol anterior con el nuevo
    
        return redirect()->back()->with('success', 'Rol actualizado correctamente.');
    }
}
