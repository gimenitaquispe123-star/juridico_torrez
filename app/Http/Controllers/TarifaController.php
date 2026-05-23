<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifa;
use App\Models\TipoProceso;
use Illuminate\Support\Facades\Auth;

class TarifaController extends Controller
{
    public function index(Request $request)
{
    $buscar = $request->get('buscar');
    $perPage = $request->get('per_page', 10);

    $tarifas = Tarifa::with('tipoProceso')
        ->when($buscar, function ($query, $buscar) {
            $query->whereHas('tipoProceso', function ($q) use ($buscar) {
                $q->where('tipo_proceso', 'like', "%{$buscar}%");
            })
            ->orWhere('tipo_documento', 'like', "%{$buscar}%")
            ->orWhere('categoria', 'like', "%{$buscar}%");
        })
        ->orderBy('id_tarifa', 'asc')
        ->paginate($perPage);

    
    $tiposProcesos = TipoProceso::select('id', 'tipo_proceso')
        ->orderBy('tipo_proceso', 'asc')
        ->get();

    return view('tarifas.index', compact('tarifas', 'tiposProcesos'));
}
 public function create()
    {
        $tiposProcesos = TipoProceso::select('id', 'nombre')->orderBy('nombre')->get();
        return view('tarifas.create', compact('tiposProcesos'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_proceso_id' => 'required|exists:tipos_procesos,id',
            'monto_min'       => 'required|numeric|min:0',
            'monto_max'       => 'required|numeric|min:0|gte:monto_min',
            'categoria'       => 'nullable|string|max:255',
            'moneda'          => 'nullable|string|max:10',
            'vigencia_inicio' => 'nullable|date',
            'vigencia_fin'    => 'nullable|date|after_or_equal:vigencia_inicio',
        ]);

        Tarifa::create($validated + [
            'usuario_reg' => Auth::id(),
            'registrado'  => now(),
        ]);

        return redirect()->route('tarifas.index')
            ->with('success', ' Tarifa registrada correctamente.');
    }
  
   public function edit($id)
{
    $tarifa = Tarifa::findOrFail($id);

    $tiposProcesos = TipoProceso::orderBy('tipo_proceso', 'asc')->get();

    return view('tarifas.edit', compact('tarifa', 'tiposProcesos'));
}

   
 public function update(Request $request, $id)
{
 
    $tarifa = Tarifa::findOrFail($id);

    $validated = $request->validate([
        'tipo_proceso_id' => 'required|exists:tipos_procesos,id',
        'categoria'       => 'nullable|string|max:255',
        'monto_min'       => 'required|numeric|min:0',
        'monto_max'       => 'required|numeric|min:0|gte:monto_min',
        'moneda'          => 'nullable|string|max:10',
        'vigencia_inicio' => 'nullable|date',
        'vigencia_fin'    => 'nullable|date|after_or_equal:vigencia_inicio',
    ]);

    $tarifa->fill($validated);

    $tarifa->usuario_mod = Auth::id();
    $tarifa->modificado  = now();

    $tarifa->save();

    return redirect()->route('tarifas.index')
                     ->with('success', ' Tarifa actualizada correctamente.');
}


   
    public function destroy($id)
    {
        $tarifa = Tarifa::findOrFail($id);
        $tarifa->delete();

        return redirect()->route('tarifas.index')
            ->with('success', '🗑️ Tarifa eliminada correctamente.');
    }

    public function show($id)
{
    $tarifa = Tarifa::findOrFail($id);

    return view('tarifas.show', compact('tarifa'));
}


   
}
