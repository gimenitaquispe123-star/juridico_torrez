<?php

namespace App\Http\Controllers;

use App\Models\TipoProceso;
use Illuminate\Http\Request;

class TipoProcesoController extends Controller
{
    
public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $tipos = TipoProceso::withCount('procesos')
        ->when($buscar, function ($query) use ($buscar) {
            return $query->where('tipo_proceso', 'LIKE', "%{$buscar}%")
                         ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
        })
        ->orderBy('id', 'asc')
        ->paginate(10);

    return view('tipos_proceso.index', compact('tipos', 'buscar'));
}
    public function create()
    {
        return view('tipos_proceso.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo_proceso' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        TipoProceso::create([
            'tipo_proceso' => $request->tipo_proceso,
            'descripcion' => $request->descripcion,
            'registrado' => now(),
            'usuario_reg' => auth()->user()->name ?? 'Sistema',
        ]);

        return redirect()->route('tipos_proceso.index')
                         ->with('success', 'Tipo de proceso creado correctamente.');
    }
    public function edit(TipoProceso $tipos_proceso)
    {
        return view('tipos_proceso.edit', compact('tipos_proceso'));
    }
    public function update(Request $request, TipoProceso $tipos_proceso)
    {
        $request->validate([
            'tipo_proceso' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $tipos_proceso->update([
            'tipo_proceso' => $request->tipo_proceso,
            'descripcion' => $request->descripcion,
            'modificado' => now(),
            'usuario_mod' => auth()->user()->name ?? 'Sistema',
        ]);

        return redirect()->route('tipos_proceso.index')
                         ->with('success', 'Tipo de proceso actualizado correctamente.');
    }

   
    public function destroy(TipoProceso $tipos_proceso)
    {
        $tipos_proceso->delete();

        return redirect()->route('tipos_proceso.index')
                         ->with('success', 'Tipo de proceso eliminado correctamente.');
    }

    public function show(TipoProceso $tipos_proceso)
{
    
    return view('tipos_proceso.show', ['tipoProceso' => $tipos_proceso]);
}



}

