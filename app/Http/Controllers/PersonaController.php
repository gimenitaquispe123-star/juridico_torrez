<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Persona::with('tipoPersona');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('paterno', 'like', "%{$buscar}%")
                  ->orWhere('materno', 'like', "%{$buscar}%")
                  ->orWhere('ci', 'like', "%{$buscar}%")
                  ->orWhere('celular', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $personas = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('personas.index', compact('personas'));
    }


    public function create()
    {
        $tipos_personas = TipoPersona::all();
        return view('personas.create', compact('tipos_personas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'paterno' => 'required|string|max:50',
            'materno' => 'nullable|string|max:50',
            'ci' => 'nullable|string|max:20|unique:personas,ci',
             'ci_expedido' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'email' => 'nullable|email|unique:personas,email',
            'fecha_nacimiento' => 'nullable|date',
            'matricula' => 'nullable|string|max:50',
            'id_tipo_persona' => 'nullable|exists:tipos_personas,id',
        ]);

        $persona = new Persona();
        $persona->fill($request->all());
        $persona->usuario_reg = auth()->id();
        $persona->save();

        return redirect()->route('personas.index')->with('success', 'Persona registrada correctamente.');
    }

  
    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        $tipos_personas = TipoPersona::all();

        return view('personas.edit', compact('persona', 'tipos_personas'));
    }


    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $request->validate([
            'nombres' => 'required|string|max:100',
            'paterno' => 'required|string|max:50',
            'materno' => 'nullable|string|max:50',
            'ci' => 'nullable|string|max:20|unique:personas,ci,' . $persona->id,
            'ci_expedido' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'email' => 'nullable|email|unique:personas,email,' . $persona->id,
            'fecha_nacimiento' => 'nullable|date',
            'matricula' => 'nullable|string|max:50',
            'id_tipo_persona' => 'nullable|exists:tipos_personas,id',
        ]);

        $persona->fill($request->all());
        $persona->usuario_mod = auth()->id();
        $persona->save();

        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente.');
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente.');
    }

   
    public function show($id)
    {
        $persona = Persona::with('tipoPersona')->findOrFail($id);
        return view('personas.show', compact('persona'));
    }
}

