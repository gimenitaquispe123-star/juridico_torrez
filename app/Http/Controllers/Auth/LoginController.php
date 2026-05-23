<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Credenciales usando "usuario" como campo de login
        $credentials = [
            'usuario' => $request->usuario,
            'password' => $request->password,
        ];

        // Intentar autenticación
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirección por rol
            return match($user->rol) {
                'administrador' => redirect()->route('admin.dashboard'),
                'abogado'       => redirect()->route('abogado.dashboard'),
                'cliente'       => redirect()->route('cliente.dashboard'),
                default         => redirect()->route('dashboard'),
            };
        }

        return back()->withErrors([
            'usuario' => 'Datos incorrectos.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
