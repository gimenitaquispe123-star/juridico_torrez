<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnlaceJuridico;
use Illuminate\Support\Facades\Auth;

class EnlaceJuridicoController extends Controller
{
    
    public function index(Request $request)
{
    
    $perPage = $request->input('per_page', 10);

    $buscar = $request->input('buscar');

    $enlaces = EnlaceJuridico::with('usuarioRegistrado', 'usuarioModificado')
                ->when($buscar, function($query, $buscar) {
                    return $query->where('nombre', 'like', "%{$buscar}%");
                })
                ->orderBy('id', 'asc')
                ->paginate($perPage);

    return view('enlaces.index', compact('enlaces'));
}
  
 public function create()
{
        return view('enlaces.create');
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:150',
        'enlace' => 'required|url|max:500',
        'descripcion' => 'nullable|string',
        'estado' => 'required|in:activo,inactivo',
    ]);

    EnlaceJuridico::create([
        'nombre' => strtoupper($request->nombre),
        'enlace' => $request->enlace,
        'descripcion' => $request->descripcion ? strtoupper($request->descripcion) : null,
        'estado' => $request->estado,
        'registrado_por' => Auth::id(),
    ]);

    return redirect()->route('enlaces.index')->with('success', 'Enlace registrado correctamente.');
}
public function edit($id)
{
    $enlace = EnlaceJuridico::findOrFail($id);
    return view('enlaces.edit', compact('enlace'));
}

public function update(Request $request, EnlaceJuridico $enlace)
{
    $request->validate([
        'nombre' => 'required|string|max:150',
        'enlace' => 'required|url|max:500',
        'descripcion' => 'nullable|string',
        'estado' => 'required|in:activo,inactivo',
    ]);

    $enlace->update([
        'nombre' => strtoupper($request->nombre),
        'enlace' => $request->enlace,
        'descripcion' => $request->descripcion ? strtoupper($request->descripcion) : null,
        'estado' => $request->estado,
        'modificado_por' => Auth::id(),
    ]);

    return redirect()->route('enlaces.index')->with('success', 'Enlace actualizado correctamente.');
}

  
    public function destroy(EnlaceJuridico $enlace)
    {
        $enlace->delete();
        return redirect()->route('enlaces.index')->with('success', 'Enlace eliminado correctamente.');
    }
    public function show($id)
{
    
    $enlace = EnlaceJuridico::with('usuarioRegistrado', 'usuarioModificado')->findOrFail($id);

    return view('enlaces.show', compact('enlace'));
}

}
