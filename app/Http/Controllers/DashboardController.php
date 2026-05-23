<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\EstadoProceso;
use App\Models\Proceso;
use App\Models\Expediente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
       
        $clientesCount = Persona::where('id_tipo_persona', 1)->count();
        $empleadosCount = Persona::whereIn('id_tipo_persona', [2,3,4])->count();
        $procesosCount = Proceso::count();
        $expedientesCount = Expediente::count();
        $cuentasCount = User::count();

        
        $procesosTerminadosCount = Proceso::whereHas('estadoProceso', function ($q) {
            $q->where('estado_proceso', 'terminado');
        })->count();

        
        $procesosPorMes = Proceso::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $procesosMeses = [];

        for ($i = 1; $i <= 12; $i++) {
            $procesosMeses[] = $procesosPorMes[$i] ?? 0;
        }

       

        $tiposProcesosData = Proceso::select(
        'tipo_proceso',
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('tipo_proceso')
    ->get();

$tiposProcesos = [];
$cantidadProcesos = [];

foreach ($tiposProcesosData as $item) {

    $tipo = \App\Models\TipoProceso::find($item->tipo_proceso);

    $tiposProcesos[] = $tipo->tipo_proceso ?? 'Sin tipo';
    $cantidadProcesos[] = $item->total;
}
       
        $estados = ['Terminados', 'Ganados', 'Perdidos', 'Pendientes'];

        $cantidadEstados = [
            Proceso::whereHas('estadoProceso', function ($q) {
                $q->where('estado_proceso', 'terminado');
            })->count(),

            Proceso::whereHas('estadoProceso', function ($q) {
                $q->where('estado_proceso', 'ganado');
            })->count(),

            Proceso::whereHas('estadoProceso', function ($q) {
                $q->where('estado_proceso', 'perdido');
            })->count(),

            Proceso::whereHas('estadoProceso', function ($q) {
                $q->where('estado_proceso', 'pendiente');
            })->count(),
        ];

        // =====================
        // RETURN VIEW
        // =====================
        return view('dashboard', compact(
            'clientesCount',
            'empleadosCount',
            'procesosCount',
            'procesosTerminadosCount',
            'expedientesCount',
            'cuentasCount',
            'procesosMeses',
            'tiposProcesos',
            'cantidadProcesos',
            'estados',
            'cantidadEstados'
        ));
    }
}