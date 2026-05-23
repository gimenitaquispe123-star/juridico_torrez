<?php

namespace App\Http\Controllers;

use App\Models\ProcesoSeguimiento;
use App\Models\Proceso;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProcesoSeguimientoController extends Controller
{

    public function index(Request $request)
    {

        $query = ProcesoSeguimiento::with(['cliente', 'usuarioReg', 'usuarioMod', 'proceso']);

        $proceso = null;

        if ($request->has('proceso_id')) {
            $proceso = Proceso::find($request->proceso_id);

            if ($proceso) {
                $query->where('id_proceso', $request->proceso_id);
            }
        }

        $seguimientos = $query->orderBy('fecha', 'asc')
                              ->paginate($request->per_page ?? 10);

        return view('procesos_seguimiento.index', compact('seguimientos', 'proceso'));
    }


    public function create(Request $request)
    {
        $proceso = null;

        if ($request->has('proceso_id')) {
            $proceso = Proceso::find($request->proceso_id);
        }

        $clientes = Persona::where('id_tipo_persona', 1)->get();
        $usuarios = Usuario::all();
        $procesos = Proceso::all();

        return view('procesos_seguimiento.create', compact('proceso','clientes','usuarios','procesos'));
    }


    public function store(Request $request)
{
    $request->validate([
        'id_proceso' => 'required|exists:procesos,id',
        'id_cliente' => 'nullable|exists:personas,id',
        'fecha' => 'required|date',
        'etapa' => 'nullable|string|max:255',
        'accion' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string',
        'dias_plazo' => 'nullable|integer|min:1',
    ]);

    $fechaVencimiento = null;
    $estadoPlazo = null;

    if ($request->filled('dias_plazo')) {

        $dias = (int) $request->dias_plazo;

        $fechaVencimiento = Carbon::parse($request->fecha)
            ->addDays($dias);

        $hoy = Carbon::today();

        if ($fechaVencimiento->lt($hoy)) {
            $estadoPlazo = 'vencido';
        } elseif ($fechaVencimiento->diffInDays($hoy) <= 2) {
            $estadoPlazo = 'proximo';
        } else {
            $estadoPlazo = 'pendiente';
        }
    }

    $seguimiento = new ProcesoSeguimiento();

    $seguimiento->id_proceso = $request->id_proceso;
    $seguimiento->id_cliente = $request->id_cliente;
    $seguimiento->fecha = $request->fecha;
    $seguimiento->etapa = $request->etapa;
    $seguimiento->accion = $request->accion;
    $seguimiento->observaciones = $request->observaciones;

    $seguimiento->dias_plazo = $request->dias_plazo;
    $seguimiento->fecha_vencimiento = $fechaVencimiento;
    $seguimiento->estado_plazo = $estadoPlazo;

    $seguimiento->usuario_reg = Auth::id();

    $seguimiento->save();

    return redirect()->route('procesos_seguimiento.index', [
        'proceso_id' => $request->id_proceso
    ])->with('success', 'Seguimiento registrado correctamente.');
}

    public function edit($id)
    {
        $seguimiento = ProcesoSeguimiento::findOrFail($id);

        $proceso = Proceso::find($seguimiento->id_proceso);

        $clientes = Persona::all();
        $usuarios = Usuario::all();

        return view('procesos_seguimiento.edit', compact('seguimiento', 'proceso', 'clientes', 'usuarios'));
    }


    public function update(Request $request, $id)
{

    $seguimiento = ProcesoSeguimiento::findOrFail($id);

    $request->validate([
        'id_cliente' => 'nullable|exists:personas,id',
        'fecha' => 'required|date',
        'etapa' => 'nullable|string|max:255',
        'accion' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string',

        // PLAZOS
        'dias_plazo' => 'nullable|integer|min:1',
    ]);

    $fechaVencimiento = null;
    $estadoPlazo = null;

    if ($request->filled('dias_plazo')) {

        $dias = (int) $request->dias_plazo;

        $fechaVencimiento = Carbon::parse($request->fecha)
            ->addDays($dias);

        $hoy = Carbon::today();

        if ($fechaVencimiento->lt($hoy)) {

            $estadoPlazo = 'vencido';

        } elseif ($fechaVencimiento->diffInDays($hoy) <= 2) {

            $estadoPlazo = 'proximo';

        } else {

            $estadoPlazo = 'pendiente';
        }
    }

    $seguimiento->id_cliente = $request->id_cliente;
    $seguimiento->fecha = $request->fecha;
    $seguimiento->etapa = $request->etapa;
    $seguimiento->accion = $request->accion;
    $seguimiento->observaciones = $request->observaciones;

    // PLAZOS
    $seguimiento->dias_plazo = $request->dias_plazo;
    $seguimiento->fecha_vencimiento = $fechaVencimiento;
    $seguimiento->estado_plazo = $estadoPlazo;

    $seguimiento->usuario_mod = Auth::id();

    $seguimiento->save();

    return redirect()->route('procesos_seguimiento.index', [
        'proceso_id' => $seguimiento->id_proceso
    ])->with('success', 'Seguimiento actualizado correctamente.');
}


    public function show($id)
    {
        $seguimiento = ProcesoSeguimiento::with(['proceso.cliente', 'usuarioReg', 'usuarioMod'])
            ->findOrFail($id);

        return view('procesos_seguimiento.show', compact('seguimiento'));
    }


    public function destroy($id)
    {

        $seguimiento = ProcesoSeguimiento::findOrFail($id);

        $id_proceso = $seguimiento->id_proceso;

        $seguimiento->delete();

        return redirect()->route('procesos_seguimiento.index', ['proceso_id' => $id_proceso])
            ->with('success', 'Seguimiento eliminado correctamente.');
    }


    public function porCliente($clienteId)
    {

        $cliente = Persona::findOrFail($clienteId);

        $seguimientos = ProcesoSeguimiento::whereHas('proceso', function ($query) use ($clienteId) {

            $query->where('id_cliente', $clienteId);

        })
        ->with(['proceso', 'proceso.cliente', 'usuarioReg', 'usuarioMod'])
        ->orderBy('fecha', 'asc')
        ->paginate(request('per_page', 10));

        return view('procesos_seguimiento.index', compact('seguimientos', 'cliente'));
    }
}