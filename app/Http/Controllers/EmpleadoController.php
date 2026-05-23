<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $buscar = $request->input('buscar');
        $tipo = $request->input('tipo'); 

        $tipos_permitidos = [2, 3, 4]; 

        $empleados = Persona::whereIn('id_tipo_persona', $tipos_permitidos)
            ->when($tipo, function ($query) use ($tipo) {
                $query->where('id_tipo_persona', $tipo);
            })
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombres', 'like', "%$buscar%")
                      ->orWhere('paterno', 'like', "%$buscar%")
                      ->orWhere('materno', 'like', "%$buscar%")
                      ->orWhere('ci', 'like', "%$buscar%");
                });
            })
            ->paginate($perPage);

        $tipos_personas = TipoPersona::whereIn('id', $tipos_permitidos)->get();

        return view('empleados.index', compact('empleados', 'tipos_personas'));
    }
  
    public function create()
    {
        $tipos_personas = TipoPersona::all(); 
        return view('empleados.create', compact('tipos_personas'));
    }

 public function store(Request $request)
{
    
    $request->merge([
        'nombres' => strtoupper($request->nombres),
        'paterno' => strtoupper($request->paterno),
        'materno' => strtoupper($request->materno),
        'direccion' => strtoupper($request->direccion),
        'area' => strtoupper($request->area),
    ]);

    $validated = $request->validate([
        'nombres' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
        ],
        'paterno' => [
            'nullable',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
        ],
        'materno' => [
            'nullable',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
        ],
        'ci' => [
            'nullable',
            'string',
            'max:20',
            'unique:personas,ci',
            'regex:/^[0-9]+[-]?[0-9A-Z]?$/'
        ],
        'ci_expedido' => 'nullable|string|max:10',
        'celular' => [
            'nullable',
            'digits:8' 
        ],
        'email' => 'nullable|email|max:255',
        'direccion' => 'nullable|string|max:255',
        'matricula' => 'nullable|string|max:50',
        'area' => 'nullable|string|max:50',
        'fecha_nacimiento' => 'nullable|date',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'id_tipo_persona' => 'required|exists:tipos_personas,id',
    ], [
        'nombres.required' => 'El nombre es obligatorio.',
        'nombres.regex' => 'Nombre inválido. Solo letras.',
        'paterno.regex' => 'Apellido paterno inválido.',
        'materno.regex' => 'Apellido materno inválido.',
        'ci.regex' => 'CI inválido.',
        'ci.unique' => 'Este CI ya está registrado.',
        'celular.digits' => 'El celular debe tener exactamente 8 números.', 
        'email.email' => 'Correo inválido.',
        'id_tipo_persona.required' => 'Debe seleccionar un tipo.',
    ]);

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('empleados', 'public');
    }

    Persona::create($validated);

    return redirect()->route('empleados.index')
        ->with('success', 'Empleado registrado correctamente.');
}

    public function edit($id)
    {
        $empleado = Persona::findOrFail($id);
        $tipos_personas = TipoPersona::all();
        return view('empleados.edit', compact('empleado', 'tipos_personas'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Persona::findOrFail($id);

        $request->merge([
            'nombres' => strtoupper($request->nombres),
            'paterno' => strtoupper($request->paterno),
            'materno' => strtoupper($request->materno),
            'direccion' => strtoupper($request->direccion),
            'area' => strtoupper($request->area),
        ]);

        $validated = $request->validate([
            'nombres' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],
            'paterno' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],
            'materno' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],
            'ci' => [
                'nullable',
                'string',
                'max:20',
                'unique:personas,ci,' . $empleado->id,
                'regex:/^[0-9]+[-]?[0-9A-Za-z]?$/'
            ],
            'ci_expedido' => 'nullable|string|max:10',
            'celular' => [
                'nullable',
                'digits:8'
            ],
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'area' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'id_tipo_persona' => 'required|exists:tipos_personas,id',
        ], [
            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.regex' => 'Nombre inválido. Solo letras.',
            'paterno.regex' => 'Apellido paterno inválido.',
            'materno.regex' => 'Apellido materno inválido.',
            'ci.regex' => 'CI inválido.',
            'ci.unique' => 'Este CI ya está registrado.',
            'celular.digits' => 'El celular debe tener exactamente 8 números.',
            'email.email' => 'Correo inválido.',
            'id_tipo_persona.required' => 'Debe seleccionar un tipo.',
        ]);

        if ($request->hasFile('foto')) {
            if ($empleado->foto) {
                Storage::disk('public')->delete($empleado->foto);
            }
            $validated['foto'] = $request->file('foto')->store('empleados', 'public');
        }

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Persona::findOrFail($id);

        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }

    public function show($id)
    {
        $empleado = Persona::with('tipoPersona')->findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    public function exportPDF(Request $request)
    {
        $buscar = $request->input('buscar');
        $tipos_permitidos = [2, 3, 4]; 

        $empleados = Persona::whereIn('id_tipo_persona', $tipos_permitidos)
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombres', 'like', "%{$buscar}%")
                      ->orWhere('paterno', 'like', "%{$buscar}%")
                      ->orWhere('materno', 'like', "%{$buscar}%")
                      ->orWhere('ci', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('paterno', 'asc')
            ->get();

        if ($empleados->isEmpty()) {
            return redirect()->back()->with('error', 'No hay registros para generar el PDF.');
        }

        $pdf = PDF::loadView('empleados.pdf', compact('empleados'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('empleados.pdf');
    }
}