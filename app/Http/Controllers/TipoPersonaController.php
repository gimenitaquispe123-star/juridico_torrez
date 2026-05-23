<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoPersona;

class TipoPersonaController extends Controller
{
    
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $perPage = $request->get('per_page', 10);

        $tipos = TipoPersona::when($buscar, function ($query, $buscar) {
            return $query->where('tipo_persona', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'asc')
        ->paginate($perPage);

        return view('tipos_personas.index', compact('tipos'));
    }


    public function create()
    {
        return view('tipos_personas.create');
    }


 public function store(Request $request)
{
    $request->validate([
        'tipo_persona' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ]);

    TipoPersona::create([
        'tipo_persona' => $request->tipo_persona,
        'descripcion' => $request->descripcion,
        'registrado' => now(),       
        
    ]);

    return redirect()->route('tipos_personas.index')
                     ->with('success', 'Tipo de persona creado correctamente.');
}


  
    public function edit($id)
    {
        $tipoPersona = TipoPersona::findOrFail($id);
        return view('tipos_personas.edit', compact('tipoPersona'));
    }

 
    public function update(Request $request, $id)
    {
        $tipoPersona = TipoPersona::findOrFail($id);

        $request->validate([
            'tipo_persona' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipoPersona->update([
            'tipo_persona' => $request->tipo_persona,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipos_personas.index')
                         ->with('success', 'Tipo de persona actualizado correctamente.');
    }

    public function show($id)
    {
        $tipoPersona = TipoPersona::findOrFail($id);
        return view('tipos_personas.show', compact('tipoPersona'));
    }

    public function destroy($id)
    {
        $tipoPersona = TipoPersona::findOrFail($id);
        $tipoPersona->delete();

        return redirect()->route('tipos_personas.index')
                         ->with('success', 'Tipo de persona eliminado correctamente.');
    }
}
