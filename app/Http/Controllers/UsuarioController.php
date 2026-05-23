<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UsuarioController extends Controller
{
    public function index(Request $request)
{
    
    $buscar = $request->get('buscar', '');
    $perPage = $request->get('per_page', 10); 
    $query = Usuario::with('persona');
    if ($buscar) {
        $query->where(function($q) use ($buscar) {
            $q->where('usuario', 'like', "%{$buscar}%")
              ->orWhereHas('persona', function($q2) use ($buscar) {
                  $q2->where('nombres', 'like', "%{$buscar}%")
                     ->orWhere('paterno', 'like', "%{$buscar}%")
                     ->orWhere('materno', 'like', "%{$buscar}%");
              });
        });
    }

    $query->orderBy('id', 'asc');
    $usuarios = $query->paginate($perPage)->withQueryString();
    $personas = Persona::all();
    $roles = Role::all();

    return view('usuarios.index', compact('usuarios', 'personas', 'roles'));
}


    public function create()
    {
        $personas = Persona::all();
        $roles = Role::all();
        return view('usuarios.create_modal', compact('personas', 'roles'));
    }

public function store(Request $request)
{
    $request->validate([
        'persona_id' => 'required|exists:personas,id',
        'usuario' => 'required|string|max:100|unique:usuarios,usuario',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'nullable|string|min:6',
        'estado' => 'required|in:activo,inactivo',
        'rol' => 'required|string|exists:roles,name',
    ]);

    $password = $request->password ?: Str::random(8);

    $usuario = Usuario::create([
        'persona_id' => $request->persona_id,
        'usuario' => $request->usuario,
        'email' => $request->email,
        'password' => Hash::make($password), 
        'estado' => $request->estado,
        'rol' => $request->rol,  
        'usuario_reg' => auth()->user()->usuario ?? 'sistema',
        'fecha_registro' => now(),
    ]);

    $usuario->assignRole($request->rol);

    return redirect()->route('usuarios.index')
                     ->with('success', 'Usuario creado correctamente.');
}


    public function edit($id)
    {
        $usuario = Usuario::with('persona', 'roles')->findOrFail($id);
        $personas = Persona::all();
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'personas', 'roles'));
    }

   public function update(Request $request, Usuario $usuario)
{
    $request->validate([
        'persona_id' => 'required|exists:personas,id',
        'usuario' => 'required|string|max:100|unique:usuarios,usuario,' . $usuario->id,
        'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
        'estado' => 'required|in:activo,inactivo',
        'rol' => 'required|string|exists:roles,name',
        'password' => 'nullable|string|min:6|confirmed',
    ], [
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ]);

    $usuario->persona_id = $request->persona_id;
    $usuario->usuario = $request->usuario;
    $usuario->email = $request->email;
    $usuario->estado = $request->estado;

    if ($request->rol) {
        $usuario->syncRoles([$request->rol]);
    }

    if ($request->filled('password')) {
        $usuario->password = Hash::make($request->password);
    }

    $usuario->modificado = now();
    $usuario->usuario_mod = auth()->user()->usuario ?? 'sistema';

    $usuario->save();

    return redirect()->route('usuarios.index')
                     ->with('success', 'Usuario actualizado correctamente.');
}
    public function show($id)
    {
        $usuario = Usuario::with('persona')->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }

    public function pdfVista(Request $request)
    {
        $mes = $request->get('mes');
        $anio = $request->get('anio');

        $query = Usuario::query();

        if ($mes) $query->whereMonth('created_at', $mes);
        if ($anio) $query->whereYear('created_at', $anio);

        $usuarios = $query->get();

        return Pdf::loadView('usuarios.pdf', compact('usuarios', 'mes', 'anio'))
                  ->stream();
    }

    public function pdfDescargar(Request $request)
    {
        $mes = $request->get('mes');
        $anio = $request->get('anio');

        $query = Usuario::query();
        if ($mes) $query->whereMonth('created_at', $mes);
        if ($anio) $query->whereYear('created_at', $anio);

        $usuarios = $query->get();

        return Pdf::loadView('usuarios.pdf', compact('usuarios', 'mes', 'anio'))
                  ->download('usuarios_'.$anio.'_'.$mes.'.pdf');
    }

}
