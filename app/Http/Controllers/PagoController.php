<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\Tarifa;
use PDF; 
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $search  = $request->input('search');

    $pagos = Pago::with(['cliente', 'tarifa', 'usuarioRegistro', 'usuarioModifico'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where(DB::raw("CONCAT(nombres, ' ', paterno, ' ', materno)"), 'LIKE', "%{$search}%");
            })
            ->orWhereHas('tarifa', function ($q) use ($search) {
                $q->where('categoria', 'LIKE', "%{$search}%");
            })
            ->orWhere('monto_total', 'LIKE', "%{$search}%")         
            ->orWhere('monto_pagado', 'LIKE', "%{$search}%")         
            ->orWhere('monto_pendiente', 'LIKE', "%{$search}%")      
            ->orWhere('fecha_pago', 'LIKE', "%{$search}%");
        })
        ->orderBy('id_pago', 'asc')
        ->paginate($perPage);

    $clientes = Persona::where('id_tipo_persona', 1)->get()->map(function ($c) {
        $c->nombre_completo = implode(' ', array_filter([
            $c->nombres,
            $c->paterno,
            $c->materno
        ]));
        return $c;
    });

    $tarifas = Tarifa::orderBy('categoria')->get();

    return view('pagos.index', compact('pagos', 'clientes', 'tarifas', 'search'));
}


    public function create()
    {
        $clientes = Persona::all()->map(function($c) {
            $c->nombre_completo = trim(
                ($c->nombres ?? '') . ' ' .
                ($c->paterno ?? '') . ' ' .
                ($c->materno ?? '')
            );
            return $c;
        });

        $tarifas = Tarifa::orderBy('categoria')->get();

        return view('pagos.create', compact('clientes', 'tarifas'));
    }

  public function store(Request $request)
{
    $request->validate([
        'id_cliente'    => 'required|exists:personas,id',
        'tarifa_id'     => 'required|exists:tarifas,id_tarifa',
        'monto_total'   => 'required|numeric|min:0',
        'monto_pagado'  => 'nullable|numeric|min:0',
        'fecha_pago'    => 'nullable|date',
        'glosa_pago'    => 'nullable|string|max:255',
    ]);

    // MONTO ACTUAL
    $montoPagadoActual = $request->monto_pagado ?? 0;

    // SUMA DE PAGOS ANTERIORES
    $totalPagadoAnterior = Pago::where('id_cliente', $request->id_cliente)
        ->where('tarifa_id', $request->tarifa_id)
        ->sum('monto_pagado');

    // TOTAL PAGADO ACUMULADO
    $totalPagado = $totalPagadoAnterior + $montoPagadoActual;

    // CALCULAR MONTO PENDIENTE
    $montoPendiente = $request->monto_total - $totalPagado;

    // EVITAR NEGATIVOS
    if ($montoPendiente < 0) {
        $montoPendiente = 0;
    }

    // REDONDEAR
    $montoPendiente = round($montoPendiente, 2);

    // ESTADO AUTOMÁTICO
    $estado = $montoPendiente <= 0
        ? 'Pagado'
        : 'Pendiente';

    // USUARIO AUTENTICADO
    $usuarioId = Auth::id();

    if (!$usuarioId) {
        abort(403, 'Usuario no autenticado.');
    }

    // GUARDAR PAGO
    Pago::create([
        'id_cliente'        => $request->id_cliente,
        'tarifa_id'         => $request->tarifa_id,
        'monto_total'       => $request->monto_total,
        'monto_pagado'      => $montoPagadoActual,
        'monto_pendiente'   => $montoPendiente,
        'fecha_pago'        => $request->fecha_pago,
        'glosa_pago'        => $request->glosa_pago,
        'estado'            => $estado,
        'usuario_registro'  => $usuarioId,
    ]);

    return redirect()
        ->route('pagos.index')
        ->with('success', 'Pago registrado correctamente.');
}


public function edit($id)
{
    $pago = Pago::with('cliente', 'tarifa')->findOrFail($id);

    $clientes = Persona::all()->map(function($c) {
        $c->nombre_completo = trim(
            ($c->nombres ?? '') . ' ' .
            ($c->paterno ?? '') . ' ' .
            ($c->materno ?? '')
        );
        return $c;
    });

    $tarifas = Tarifa::orderBy('categoria')->get();

    return view('pagos.edit', compact('pago', 'clientes', 'tarifas'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'monto_pagado' => 'required|numeric|min:0',
        'fecha_pago'   => 'nullable|date',
        'glosa_pago'   => 'nullable|string',
    ]);

    $pago = Pago::findOrFail($id);

    $montoTotal = $pago->monto_total;

    $totalPagadoAnterior = Pago::where('id_cliente', $pago->id_cliente)
        ->where('tarifa_id', $pago->tarifa_id)
        ->where('id_pago', '!=', $id)
        ->sum('monto_pagado');

   
    $totalPagado = $totalPagadoAnterior + $request->monto_pagado;

    $montoPendiente = $montoTotal - $totalPagado;

    if ($montoPendiente < 0) {
        $montoPendiente = 0;
    }

    $montoPendiente = round($montoPendiente, 2);

    $estado = $montoPendiente <= 0
        ? 'Pagado'
        : 'Pendiente';

    $usuarioId = Auth::id();

    if (!$usuarioId) {
        abort(403, 'Usuario no autenticado');
    }

    $pago->update([
        'monto_pagado'      => $request->monto_pagado,
        'monto_pendiente'   => $montoPendiente,
        'fecha_pago'        => $request->fecha_pago,
        'glosa_pago'        => $request->glosa_pago,
        'estado'            => $estado,
        'usuario_modifico'  => $usuarioId,
    ]);

    return redirect()->route('pagos.index')
        ->with('success', 'Pago actualizado correctamente.');
}

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()->route('pagos.index')
                         ->with('success','Pago eliminado correctamente.');
    }
    public function show($id)
{
    
    $pago = Pago::with(['cliente', 'tarifa', 'usuarioRegistro', 'usuarioModifico'])
                ->findOrFail($id);

    return view('pagos.show', compact('pago'));
}   

public function reporteAnual(Request $request)
{
    $year = $request->get('year', now()->year);
    $perPage = $request->get('perPage', 10);

    $query = Pago::with('cliente')
        ->whereYear('fecha_pago', $year);

    $pagos = $query->paginate($perPage)
        ->appends([
            'year' => $year,
            'perPage' => $perPage
        ]);

    $totalMonto = (clone $query)->sum('monto_total');
    $totalPagado = (clone $query)->sum('monto_pagado');
    $totalPendiente = (clone $query)->sum('monto_pendiente');

    return view('pagos.reportes.anual', compact(
        'pagos',
        'year',
        'perPage',
        'totalMonto',
        'totalPagado',
        'totalPendiente'
    ));
}

public function reporteMensual(Request $request)
{
    $year = $request->get('year', now()->year);
    $month = $request->get('month', now()->month);
    $perPage = $request->get('perPage', 10);

    $query = \App\Models\Pago::with('cliente')
                ->whereYear('fecha_pago', $year)
                ->whereMonth('fecha_pago', $month);

    $pagos = $query->paginate($perPage)
            ->appends([
                'year' => $year,
                'month' => $month,
                'perPage' => $perPage
            ]);

    $totalMonto = (clone $query)->sum('monto_total');
    $totalPagado = (clone $query)->sum('monto_pagado');
    $totalPendiente = (clone $query)->sum('monto_pendiente');

    return view('pagos.reportes.mensual', compact(
        'pagos',
        'year',
        'month',
        'totalMonto',
        'totalPagado',
        'totalPendiente',
        'perPage'
    ));
}

public function exportarAnualPDF($year)
{
    $pagos = Pago::with('cliente')
        ->whereYear('fecha_pago', $year)
        ->get(); 

    $totalMonto = $pagos->sum('monto_total');
    $totalPagado = $pagos->sum('monto_pagado');
    $totalPendiente = $pagos->sum('monto_pendiente');

    $pdf = PDF::loadView('pagos.pdf_anual', compact(
        'pagos',
        'year',
        'totalMonto',
        'totalPagado',
        'totalPendiente'
    ));

    return $pdf->stream("Reporte_Anual_Pagos_$year.pdf");
}
public function exportarMensualPDF(Request $request)
{
    $year = $request->year;
    $month = $request->month;

    $pagos = Pago::with('cliente')
        ->whereYear('fecha_pago', $year)
        ->whereMonth('fecha_pago', $month)
        ->get();

    $totalMonto = $pagos->sum('monto_total');
    $totalPagado = $pagos->sum('monto_pagado');
    $totalPendiente = $pagos->sum('monto_pendiente');

    $pdf = PDF::loadView('pagos.pdf_mensual', compact('pagos', 'year', 'month', 'totalMonto', 'totalPagado', 'totalPendiente'));
    return $pdf->stream("reporte_mensual_{$month}_{$year}.pdf");
}

public function historial($clienteId, $tarifaId)
{
    $pagos = Pago::with('cliente', 'tarifa')
        ->where('id_cliente', $clienteId)
        ->where('tarifa_id', $tarifaId)
        ->orderBy('created_at', 'asc')
        ->get();

    $totalPagado = $pagos->sum('monto_pagado');
    $montoTotal = $pagos->first()->monto_total ?? 0;
    $pendiente = $montoTotal - $totalPagado;

    if ($pendiente < 0) {
        $pendiente = 0;
    }

    return view('pagos.historial', compact(
        'pagos',
        'totalPagado',
        'montoTotal',
        'pendiente'
    ));
}
}
