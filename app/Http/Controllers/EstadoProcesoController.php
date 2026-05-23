<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstadoProceso;

class EstadoProcesoController extends Controller
{
    public function index(Request $request)
{
    
    $buscar = $request->input('buscar', '');
    $limit = $request->input('per_page', 10); 

    $estados = EstadoProceso::query()
        ->when($buscar, function($query, $buscar) {
            $query->where('estado_proceso', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'asc')
        ->paginate($limit);
    return view('estados_proceso.index', compact('estados', 'buscar', 'limit'));
}

    public function create()
    {
        return view('estados_proceso.create');
    }

public function store(Request $request)
{
    $request->validate([
        'estado_proceso' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ]);

    EstadoProceso::create([
        'estado_proceso' => $request->estado_proceso,
        'descripcion' => $request->descripcion,
        'usuario_reg' => auth()->id(), 
        'registrado' => now(),
        'usuario_mod' => null, 
        'modificado' => null,  
    ]);

    return redirect()->route('estados_proceso.index')
                     ->with('success', 'Estado de proceso creado correctamente.');
}

    public function edit($id)
    {
        $estado = EstadoProceso::findOrFail($id);
        return view('estados_proceso.edit', compact('estado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado_proceso' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $estado = EstadoProceso::findOrFail($id);
        $estado->update([
            'estado_proceso' => $request->estado_proceso,
            'descripcion' => $request->descripcion,
            'usuario_mod' => auth()->user()->id ?? null,
            'modificado' => now(),
        ]);

        return redirect()->route('estados_proceso.index')->with('success', 'Estado de proceso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estado = EstadoProceso::findOrFail($id);
        $estado->delete();

        return redirect()->route('estados_proceso.index')->with('success', 'Estado de proceso eliminado correctamente.');
    }

    public function show($id)
    {
        $estado = EstadoProceso::findOrFail($id);

        
        return view('estados_proceso.show', compact('estado'));
    }
}

