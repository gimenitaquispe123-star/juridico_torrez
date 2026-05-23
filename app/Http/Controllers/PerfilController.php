<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    // Mostrar el perfil
    public function index()
    {
        $usuario = auth()->user(); // usuario logueado
        return view('perfil.index', compact('usuario')); // pasamos $usuario
    }

    // Actualizar la contraseña
    public function update(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
        }

        return redirect()->back()->with('success', 'No se realizaron cambios.');
    }
}
