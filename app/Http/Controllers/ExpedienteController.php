<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Documento;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Usuario;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ExpedienteController extends Controller
{
    
public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;
    $buscar = $request->buscar;

   $user = auth()->user();

$query = Expediente::with([
    'cliente',
    'usuarioReg',
    'usuarioMod',
    'abogadoAsignado.empleado'
]);


if ($user->rol === 'abogado') {

    $query->whereHas('abogadoAsignado', function ($q) use ($user) {

        $q->where('id_empleado', $user->persona_id);

    });
}

$expedientes = $query
    ->when($buscar, function($query, $buscar) {

        $query->where('codigo_expediente', 'like', "%$buscar%")
              ->orWhere('nro_expediente', 'like', "%$buscar%")
              ->orWhereHas('cliente', function($q) use ($buscar) {

                  $q->where('nombres', 'like', "%$buscar%")
                    ->orWhere('paterno', 'like', "%$buscar%")
                    ->orWhere('materno', 'like', "%$buscar%");
              });
    })
    ->orderBy('registrado', 'asc')
    ->paginate($perPage)
    ->withQueryString();

    return view('expedientes.index', compact('expedientes'));
}


    public function create()
    {
        $clientes = Persona::where('id_tipo_persona', 1)->get(); 
        $usuarios = Usuario::all(); 
         $expedientes = Expediente::all();

        return view('expedientes.create', compact('clientes', 'usuarios','expedientes'));
    }

public function store(Request $request)
{
    $request->validate([

    'id_cliente' => 'nullable|exists:personas,id',
'nro_expediente' => [
    'required',
    'string',
    'max:50',
    'regex:/^[A-Za-z0-9\-\/]+$/',
    'unique:expedientes,nro_expediente'
],

    'demandante' => [
    'required',
    'string',
    'max:150',
    'regex:/^[\pL\s\.\-0-9]+$/u'
],

'demandado' => [
    'required',
    'string',
    'max:150',
    'regex:/^[\pL\s\.\-0-9]+$/u'
],

    'materia' => [
        'required',
        'string',
        'max:100',
        'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
    ],

    'contingencia' => [
        'nullable',
        'string',
        'max:150',
        'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
    ],

    'respaldo' => 'nullable|file|mimes:pdf,doc,docx|max:20480',

    'estado_expediente' => [
        'required',
        'string',
        'max:50',
        'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
    ],

    'observaciones' => 'nullable|string|max:1000',

], [

    'nro_expediente.required' => 'El Número de Expediente es obligatorio.',
    'nro_expediente.unique' => 'Este Número de Expediente ya está registrado.',
    'nro_expediente.regex' => 'El Número de Expediente debe contener solo números.',

    'demandante.required' => 'El Demandante es obligatorio.',
    'demandante.regex' => 'El Demandante solo puede contener letras y espacios.',

    'demandado.required' => 'El Demandado es obligatorio.',
    'demandado.regex' => 'El Demandado solo puede contener letras y espacios.',

    'materia.required' => 'La Materia es obligatoria.',
    'materia.regex' => 'La Materia solo puede contener letras y espacios.',

    'contingencia.regex' => 'La Contingencia solo puede contener letras y espacios.',

    'estado_expediente.required' => 'El Estado del Expediente es obligatorio.',
    'estado_expediente.regex' => 'El Estado del Expediente solo puede contener letras y espacios.',

    'respaldo.mimes' => 'El archivo debe ser PDF o Word.',
    'respaldo.max' => 'El archivo no debe superar los 2MB.',
]);

    $expediente = new Expediente();

    $lastId = Expediente::max('id') ?? 0;
    $expediente->codigo_expediente = 'EXP' . ($lastId + 1) . '-PT';

    $expediente->id_cliente = $request->id_cliente;
    $expediente->nro_expediente = $request->nro_expediente;
    $expediente->demandante = $request->demandante ? strtoupper($request->demandante) : null;
    $expediente->demandado = $request->demandado ? strtoupper($request->demandado) : null;
    $expediente->materia = $request->materia ? strtoupper($request->materia) : null;
    $expediente->contingencia = $request->contingencia ? strtoupper($request->contingencia) : null;
    $expediente->estado_expediente = $request->estado_expediente ? strtoupper($request->estado_expediente) : 'INICIADO';
    $expediente->observaciones = $request->observaciones ? strtoupper($request->observaciones) : null;
    $expediente->estado = $request->has('estado');

    $expediente->usuario_reg = auth()->user()->id ?? null;
    $expediente->usuario_mod = auth()->user()->id ?? null;

    if ($request->hasFile('respaldo')) {
    $path = $request->file('respaldo')->store('expedientes', 'public');
    $expediente->respaldo = $path;
}

    $expediente->save();

    return redirect()->route('expedientes.index')->with('success', 'Expediente creado correctamente.');
}



public function update(Request $request, $id)
{
    $expediente = Expediente::findOrFail($id);

    $request->validate([
        'id_cliente' => 'nullable|exists:personas,id',
        'codigo_expediente' => 'required|unique:expedientes,codigo_expediente,' . $expediente->id,
        'nro_expediente' => ['nullable','string','max:50','regex:/^[0-9\-]+$/'],
        'demandante' => ['nullable','string','max:150','regex:/^[\pL\s\.\-0-9]+$/u'],
        'demandado' => ['nullable','string','max:150','regex:/^[\pL\s\.\-0-9]+$/u'],
        'materia' => ['nullable','string','max:100','regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
        'contingencia' => ['nullable','string','max:50','regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
        'respaldo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'estado_expediente' => ['nullable','string','max:50','regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
        'observaciones' => 'nullable|string',
        'estado' => 'nullable|boolean',
    ], [
        'nro_expediente.regex' => 'El Número de Expediente debe contener solo números.',
        'demandante.regex' => 'El Demandante solo puede contener letras y espacios.',
        'demandado.regex' => 'El Demandado solo puede contener letras y espacios.',
        'materia.regex' => 'La Materia solo puede contener letras y espacios.',
        'contingencia.regex' => 'La Contingencia solo puede contener letras y espacios.',
        'estado_expediente.regex' => 'El Estado del Expediente solo puede contener letras y espacios.',
    ]);

    $expediente->update([
        'id_cliente' => $request->id_cliente,
        'codigo_expediente' => $request->codigo_expediente,
        'nro_expediente' => $request->nro_expediente,
        'demandante' => $request->demandante ? strtoupper($request->demandante) : null,
        'demandado' => $request->demandado ? strtoupper($request->demandado) : null,
        'materia' => $request->materia ? strtoupper($request->materia) : null,
        'contingencia' => $request->contingencia ? strtoupper($request->contingencia) : null,
        'estado_expediente' => $request->estado_expediente ? strtoupper($request->estado_expediente) : 'INICIADO',
        'observaciones' => $request->observaciones ? strtoupper($request->observaciones) : null,
        'estado' => $request->has('estado') ? true : false,
        'usuario_mod' => auth()->user()->id ?? $expediente->usuario_mod,
    ]);

    if ($request->hasFile('respaldo')) {

        if ($expediente->respaldo) {
            Storage::disk('public')->delete($expediente->respaldo);
        }

        $file = $request->file('respaldo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('expedientes', $filename, 'public');


        $expediente->respaldo = $filename;
        $expediente->save();
    }

    return redirect()->route('expedientes.index')
        ->with('success', 'Expediente actualizado correctamente.');
}
    public function edit($id)
    {
        $expediente = Expediente::findOrFail($id);
        $clientes = Persona::where('id_tipo_persona', 1)->get();
        $usuarios = Usuario::all();

        return view('expedientes.edit', compact('expediente', 'clientes', 'usuarios'));
    }

   
 
    
    public function destroy($id)
    {
        $expediente = Expediente::findOrFail($id);
        $expediente->delete();

        return redirect()->route('expedientes.index')->with('success', 'Expediente eliminado correctamente.');
    }

public function show($id)
{
    $expediente = Expediente::with([
    'cliente',
    'usuarioReg',
    'usuarioMod',
    'documentos.usuario',
    'abogadoAsignado.empleado'
])->findOrFail($id);

    return view('expedientes.show', compact('expediente'));
}


public function uploadDocumento(Request $request, $id)
{
    $expediente = Expediente::findOrFail($id);

    $request->validate([
        'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:51200',
        'nombre' => 'nullable|string|max:255',
    ]);

    $archivo = $request->file('archivo');
    $nombreArchivo = $request->nombre ?? $archivo->getClientOriginalName();
   $path = $archivo->store('documentos/expedientes', 'public');

    Documento::create([
    'nombre' => $nombreArchivo,
    'archivo' => $path,
    'fecha_subida' => now(),
    'id_usuario' => auth()->id(),
    'expediente_id' => $expediente->id,
]);


    return redirect()->route('expedientes.show', $expediente->id)
                     ->with('success', 'Documento subido correctamente.');
}


    public function pdfVista(Request $request)
    {
        $mes = $request->get('mes');
        $anio = $request->get('anio');

        $query = Expediente::with(['cliente', 'usuarioReg', 'usuarioMod']);

        if ($mes) $query->whereMonth('registrado', $mes);
        if ($anio) $query->whereYear('registrado', $anio);

        $expedientes = $query->get();

        return Pdf::loadView('expedientes.pdf', compact('expedientes', 'mes', 'anio'))
                  ->stream();
    }

    public function pdfDescargar(Request $request)
    {
        $mes = $request->get('mes');
        $anio = $request->get('anio');

        $query = Expediente::with(['cliente', 'usuarioReg', 'usuarioMod']);

        if ($mes) $query->whereMonth('registrado', $mes);
        if ($anio) $query->whereYear('registrado', $anio);

        $expedientes = $query->get();

        return Pdf::loadView('expedientes.pdf', compact('expedientes', 'mes', 'anio'))
                  ->download('expedientes_'.$anio.'_'.$mes.'.pdf');
    }

public function getCodigo($id)
{
    $exp = \App\Models\Expediente::find($id);

    return response()->json([
        'codigo_expediente' => $exp ? $exp->codigo_expediente : ''
    ]);
}
public function eliminarRespaldo($id)
{
    $expediente = Expediente::findOrFail($id);

    if ($expediente->respaldo) {
        // eliminar archivo físico
        \Storage::disk('public')->delete($expediente->respaldo);

        // limpiar campo en BD
        $expediente->respaldo = null;
        $expediente->save();
    }

    return back()->with('success', 'Documento principal eliminado correctamente.');
}

}
