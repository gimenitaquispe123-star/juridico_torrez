<?php

namespace App\Http\Controllers;

use App\Models\Posicion;
use Illuminate\Http\Request;

class PosicionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $buscar = $request->get('buscar', '');

        $posiciones = Posicion::where('nombre', 'like', "%{$buscar}%")
                      ->orderBy('id', 'asc')
                      ->paginate($perPage);

        return view('posiciones.index', compact('posiciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'required|boolean',
        ]);

        Posicion::create($request->only(['nombre','descripcion','estado']));

        return redirect()->route('posiciones.index')->with('success', 'Posición creada correctamente.');
    }

    public function update(Request $request, Posicion $posicion)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'required|boolean',
        ]);

        $posicion->update($request->only(['nombre','descripcion','estado']));

        return redirect()->route('posiciones.index')->with('success', 'Posición actualizada correctamente.');
    }

    public function destroy(Posicion $posicion)
    {
        $posicion->delete();
        return redirect()->route('posiciones.index')->with('success', 'Posición eliminada correctamente.');
    }
}
