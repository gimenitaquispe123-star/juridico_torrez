<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ci' => 'required|string|max:20',  
            'telefono' => 'nullable|string|max:15',  
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Usuario::create([
            'nombre' => $request->name,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
            'ci' => $request->ci,  
            'telefono' => $request->telefono,  
            'rol' => 'cliente',  
            'direccion' => 'Desconocida', 
            'fecha_creacion' => now(),
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
