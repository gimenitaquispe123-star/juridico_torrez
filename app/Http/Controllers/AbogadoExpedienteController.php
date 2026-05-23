<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbogadoExpediente;
use App\Models\Expediente;
use App\Models\Persona;

class AbogadoExpedienteController extends Controller
{
 public function index()
{
    $user = auth()->user();

    $query = AbogadoExpediente::with([
        'expediente',
        'empleado'
    ]);

   
    if ($user->rol === 'abogado') {

        $query->where('id_empleado', 2);
    }

    $abogados = $query->get();

    return view('abogado_expediente.index', compact('abogados'));
}
    public function create($id_expediente)
    {
        $expediente = Expediente::findOrFail($id_expediente);

        $abogados = Persona::whereHas('tipoPersona', function ($q) {
            $q->where('tipo_persona', 'Abogado');
        })->get();

        return view('abogado_expediente.create', compact('expediente', 'abogados'));
    }

public function store(Request $request)
{
    $request->validate([
        'id_expediente' => 'required|exists:expedientes,id',
        'id_empleado' => 'required|exists:personas,id',
        'fecha_asignacion' => 'required|date',
        'observacion' => 'nullable|string',
    ]);

    AbogadoExpediente::where('id_expediente', $request->id_expediente)
        ->where('estado', true)
        ->update([
            'estado' => false,
            'fecha_desvinculacion' => now(),
            'usuario_mod' => auth()->id()
        ]);

    AbogadoExpediente::create([
        'id_expediente' => $request->id_expediente,
        'id_empleado' => $request->id_empleado,
        'fecha_asignacion' => $request->fecha_asignacion,
        'observacion' => $request->observacion,
        'usuario_reg' => auth()->id(),
        'estado' => true,
    ]);

    return redirect()->route('expedientes.index')
        ->with('success', 'Abogado asignado correctamente.');
}

  
    public function edit($id)
    {
        $abogado = AbogadoExpediente::with(['expediente', 'empleado'])->findOrFail($id);
        $expedientes = Expediente::all();
        $empleados = Persona::all();

        return view('abogado_expediente.edit', compact('abogado', 'expedientes', 'empleados'));
    }

  public function update(Request $request, $id)
{
    $request->validate([
        'id_expediente' => 'required|exists:expedientes,id',
        'id_empleado' => 'required|exists:personas,id',
        'fecha_asignacion' => 'required|date',
        'fecha_desvinculacion' => 'nullable|date',
        'observacion' => 'nullable|string',
        'estado' => 'required|boolean',
    ]);

    $abogado = AbogadoExpediente::findOrFail($id);

    
    if ($abogado->id_empleado != $request->id_empleado) {

        AbogadoExpediente::where('id_expediente', $request->id_expediente)
            ->where('estado', true)
            ->update([
                'estado' => false,
                'fecha_desvinculacion' => now(),
                'usuario_mod' => auth()->id()
            ]);
    }

    $abogado->id_expediente = $request->id_expediente;
    $abogado->id_empleado = $request->id_empleado;
    $abogado->fecha_asignacion = $request->fecha_asignacion;
    $abogado->fecha_desvinculacion = $request->fecha_desvinculacion ?: null;
    $abogado->observacion = $request->observacion;
    $abogado->estado = $request->estado;
    $abogado->usuario_mod = auth()->id();
    $abogado->save();

    return redirect()->route('expedientes.index')
        ->with('success', 'Asignación actualizada correctamente.');
}
    public function destroy($id)
    {
        $abogado = AbogadoExpediente::findOrFail($id);
        $abogado->delete();

        return redirect()->back()
            ->with('success', 'Asignación eliminada correctamente.');
    }

    public function show($id)
{
    $abogado = AbogadoExpediente::with(['expediente', 'empleado'])->findOrFail($id);
    return view('abogado_expediente.show', compact('abogado'));
}

}
