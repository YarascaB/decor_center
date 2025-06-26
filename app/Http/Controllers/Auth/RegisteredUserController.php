<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register'); // Asegúrate de que esta vista esté disponible
    }

    /**
     * Maneja el registro de un nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'confirmed',
                'min:8', // La contraseña debe tener al menos 8 caracteres
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[0-9]/', // Al menos un número
                'regex:/[@$!%*?&]/', // Al menos un carácter especial
            ],
        ]);

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Disparar el evento de usuario registrado
        event(new Registered($user));

        // Iniciar sesión para el usuario recién registrado
        Auth::login($user);

        // Redirigir al login después del registro
        return redirect('/login');  // Redirige a la página de login
    }
}
