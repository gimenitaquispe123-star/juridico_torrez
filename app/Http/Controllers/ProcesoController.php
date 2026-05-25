<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\Persona;
use App\Models\TipoProceso;
use App\Models\EstadoProceso;
use App\Models\Expediente;
use App\Models\Posicion;
use App\Models\Carpeta;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf; 

class ProcesoController extends Controller

{
    
public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $buscar = $request->get('buscar', '');

    $user = Auth::user();

    $query = Proceso::with([
        'cliente',
        'posicion',
        'tipoProceso',
        'estadoProceso',
        'expediente.abogadoAsignado.empleado'
    ]);

    if (strtolower($user->rol) === 'abogado') {
        $query->whereHas('expediente.abogadoAsignado', function ($q) use ($user) {
            $q->where('id_empleado', $user->persona_id)
              ->where('estado', 1); 
        });
    }

    $procesos = $query
        ->when($buscar, function ($query, $buscar) {
            $query->where('proceso', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'asc')
        ->paginate($perPage)
        ->appends([
            'buscar' => $buscar,
            'per_page' => $perPage
        ]);

    $clientes = Persona::where('id_tipo_persona', 1)->orderBy('nombres')->get();
    $abogados = Persona::where('id_tipo_persona', 2)->orderBy('nombres')->get();
    $tipos = TipoProceso::orderBy('tipo_proceso')->get();
    $estados = EstadoProceso::orderBy('estado_proceso')->get();
    $posiciones = Posicion::orderBy('nombre')->get();

    $expedientes = Expediente::orderBy('id', 'desc')->paginate(10);

    $proceso_detalle = $procesos->first();

    return view('procesos.index', compact(
        'procesos',
        'clientes',
        'abogados',
        'tipos',
        'estados',
        'expedientes',
        'posiciones',
        'proceso_detalle',
        'buscar',
        'perPage'
    ));
}
public function create()
{
    $user = auth()->user();

    $clientes = Persona::where('id_tipo_persona', 1)
        ->orderBy('nombres')
        ->get();

    $abogados = Persona::where('id_tipo_persona', 2)
        ->orderBy('nombres')
        ->get();

    $tipos = TipoProceso::orderBy('tipo_proceso')->get();
    $estados = EstadoProceso::orderBy('estado_proceso')->get();
    $posiciones = Posicion::orderBy('nombre')->get();

  if (strtolower($user->rol) === 'abogado') {

    $expedientes = Expediente::whereIn('id', function ($query) use ($user) {

        $query->select('id_expediente')
              ->from('abogado_expedientes')
              ->where('id_empleado', $user->persona_id)
              ->where('estado', 1);

    })
    ->with(['cliente', 'abogadoAsignado'])
    ->orderByDesc('id')
    ->get();

} else {

    $expedientes = Expediente::with(['cliente', 'abogadoAsignado'])
        ->orderByDesc('id')
        ->get();
}

    return view('procesos.create', compact(
        'clientes',
        'abogados',
        'tipos',
        'estados',
        'expedientes',
        'posiciones'
    ));
}
public function edit(Proceso $proceso)
{
    $user = auth()->user();

    $clientes = Persona::where('id_tipo_persona', 1)->orderBy('nombres')->get();
    $abogados = Persona::where('id_tipo_persona', 2)->orderBy('nombres')->get();
    $tipos = TipoProceso::orderBy('tipo_proceso')->get();
    $estados = EstadoProceso::orderBy('estado_proceso')->get();
    $posiciones = Posicion::orderBy('nombre')->get();

    $expedientesQuery = Expediente::query();

    if ($user->rol === 'abogado') {
        $expedientesQuery->whereHas('abogadoAsignado', function ($q) use ($user) {
            $q->where('id_empleado', $user->persona_id)
              ->where('estado', 1);
        });
    }

    $expedientes = $expedientesQuery->orderBy('id', 'desc')->get();

    return view('procesos.edit', compact(
        'proceso',
        'clientes',
        'abogados',
        'tipos',
        'estados',
        'expedientes',
        'posiciones'
    ));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'id_cliente' => 'nullable|exists:personas,id',
        'id_abogado' => 'nullable|exists:personas,id',
        'id_posicion' => 'nullable|exists:posiciones,id',
        'contrario' => 'nullable|string|max:255',
        'proceso' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'tipo_proceso' => 'nullable|exists:tipos_procesos,id',
        'estado_proceso' => 'nullable|exists:estados_proceso,id',
        'involucrados' => 'nullable|string',
        'fecha_inicio' => 'nullable|date',
        'fecha_final' => 'nullable|date|after_or_equal:fecha_inicio',
        'usuario_reg' => 'nullable|string|max:100',
        'usuario_mod' => 'nullable|string|max:100',
        'estado' => 'nullable|string|max:50',
        'documento_principal' => 'nullable|file|mimes:pdf,doc,docx|max:20480',

        'id_expediente' => [
            'nullable',
            'exists:expedientes,id',
            Rule::unique('procesos', 'id_expediente')
        ],
    ], [
        'id_expediente.unique' => 'Este expediente ya está asociado a otro proceso.'
    ]);

    
    $camposTexto = ['contrario', 'proceso', 'descripcion', 'involucrados', 'estado'];
    foreach ($camposTexto as $campo) {
        if (!empty($validated[$campo])) {
            $validated[$campo] = strtoupper($validated[$campo]);
        }
    }

    
    $validated['usuario_reg'] = Auth::user()
        ? strtoupper(Auth::user()->name)
        : 'SISTEMA';

    $validated['usuario_mod'] = null;

    $proceso = Proceso::create($validated);
    

if ($request->hasFile('documento_principal')) {

    $archivo = $request->file('documento_principal');

    $path = $archivo->store(
        'documentos/proceso_'.$proceso->id,
        'public'
    );

    
    $carpetaDemanda = Carpeta::where('proceso_id', $proceso->id)
        ->where('nombre', 'DEMANDA')
        ->first();

    Documento::create([

        'nombre' => $archivo->getClientOriginalName(),

        'tipo' => $archivo->getClientOriginalExtension(),

        'archivo' => $path,

        'descripcion' => 'Documento principal del proceso',

        'fecha_subida' => now(),

        'carpeta_id' => $carpetaDemanda?->id,

        'proceso_id' => $proceso->id,

        'expediente_id' => $proceso->id_expediente,

        'id_usuario' => auth()->id(),

    ]);
}

    return redirect()->route('procesos.index')
                     ->with('success', 'Proceso creado correctamente.');
}

public function update(Request $request, Proceso $proceso)
{
    $validated = $request->validate([
        'id_cliente' => 'nullable|exists:personas,id',
        'id_abogado' => 'nullable|exists:personas,id',
        'id_posicion' => 'nullable|exists:posiciones,id',
        'contrario' => 'nullable|string|max:255',
        'proceso' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'tipo_proceso' => 'nullable|exists:tipos_procesos,id',
        'estado_proceso' => 'nullable|exists:estados_proceso,id',
        'involucrados' => 'nullable|string',
        'fecha_inicio' => 'nullable|date',
        'fecha_final' => 'nullable|date|after_or_equal:fecha_inicio',
        'usuario_reg' => 'nullable|string|max:100', 
        'usuario_mod' => 'nullable|string|max:100',
        'estado' => 'nullable|string|max:50',
        'id_expediente' => 'nullable|exists:expedientes,id',
    ]);

    $camposTexto = ['contrario', 'proceso', 'descripcion', 'involucrados', 'estado'];
    foreach ($camposTexto as $campo) {
        if (isset($validated[$campo])) {
            $validated[$campo] = strtoupper($validated[$campo]);
        }
    }

    $validated['usuario_mod'] = Auth::user() ? strtoupper(Auth::user()->name) : 'SISTEMA';

    $proceso->update($validated);

    return redirect()->route('procesos.index')
                     ->with('success', 'Proceso actualizado correctamente.');
}


   
    public function destroy(Proceso $proceso)
    {
        $proceso->delete();

        return redirect()->route('procesos.index')
                         ->with('success', 'Proceso eliminado correctamente.');
    }


    public function show($id)
{
    $proceso = Proceso::with([
        'cliente',
        'tipoProceso',
        'estadoProceso',
        'expediente.abogadoAsignado.empleado',
        'documentos.usuario'
    ])->findOrFail($id);

    $perPage = request()->get('per_page', 5);

$documentos = $proceso->documentos()
    ->orderBy('fecha_subida', 'asc')
    ->paginate($perPage)
    ->withQueryString();

    $carpetas = Carpeta::where('proceso_id', $proceso->id)->get();

    return view('procesos.show', compact(
        'proceso',
        'documentos',
        'carpetas'
    ));
}



public function pdfVista(Request $request)
{
    $request->validate([
        'mes' => 'nullable|integer|min:1|max:12',
        'anio' => 'nullable|integer|min:2000|max:2100',
    ]);

    $mes = $request->mes;
    $anio = $request->anio;

    $query = Proceso::with([
        'cliente',
        'posicion',
        'tipoProceso',
        'estadoProceso',
        'expediente',
        'expediente.abogadoAsignado.empleado'
    ]);

    if ($mes) {
        $query->whereMonth('created_at', $mes);
    }

    if ($anio) {
        $query->whereYear('created_at', $anio);
    }

    $procesos = $query->get();

    return Pdf::loadView('procesos.pdf', compact('procesos', 'mes', 'anio'))
              ->stream();
}
}
