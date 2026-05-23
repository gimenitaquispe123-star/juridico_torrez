<?php

namespace App\Http\Controllers;

use App\Models\Carpeta;
use App\Models\TipoProceso;
use App\Models\Proceso;
use App\Models\Plantilla;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Documento;


class CarpetaController extends Controller
{
 public function index(Request $request)
{
    $perPage = $request->get('perPage', 10); 
    $carpetas = Carpeta::with('subcarpetas')
                        ->whereNull('padre_id')
                        ->paginate($perPage);
    return view('carpetas.index', compact('carpetas'));
}


    public function create()
    {
        $carpetas = Carpeta::whereNull('padre_id')->get();
        $tipos_procesos = TipoProceso::all();
        $procesos = Proceso::with('cliente')->get();

        return view('carpetas.create', compact('carpetas', 'tipos_procesos', 'procesos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'padre_id' => 'nullable|exists:carpetas,id',
            'tipo_proceso_id' => 'nullable|exists:tipos_procesos,id',
            'proceso_id' => 'nullable|exists:procesos,id',
        ]);

        Carpeta::create([
            'nombre' => $request->nombre,
            'padre_id' => $request->padre_id ?? null,
            'tipo_proceso_id' => $request->tipo_proceso_id ?? null,
            'proceso_id' => $request->proceso_id ?? null,
            'registrado' => now(),
            'usuario_reg' => Auth::user()->name ?? 'Sistema',
        ]);

        return redirect()->route('carpetas.index')->with('success', 'Carpeta creada correctamente.');
    }

public function show($id)
{
    $carpeta = Carpeta::with('subcarpetas')->findOrFail($id);
    $subcarpetas = $carpeta->subcarpetas()->paginate(5);
    $documentos = $carpeta->documentos()->paginate(5);
    $plantillas = Plantilla::where('estado', 1)->get();

    return view('carpetas.show', compact('carpeta', 'subcarpetas', 'documentos', 'plantillas'));
}

public function destroy($id)
{
    $carpeta = Carpeta::with(['subcarpetas','documentos'])->findOrFail($id);

    if ($carpeta->subcarpetas->count() > 0 || $carpeta->documentos->count() > 0) {
        return redirect()->back()->with('error', 'No puedes eliminar una carpeta que tiene contenido.');
    }

    $carpeta->delete();

    return redirect()->route('carpetas.index')
        ->with('success', 'Carpeta eliminada correctamente.');
}
public function edit($id)
{
    $carpeta = Carpeta::findOrFail($id);
    $carpetas = Carpeta::whereNull('padre_id')->get();
    $tipos_procesos = TipoProceso::all();
    $procesos = Proceso::with('cliente')->get();

    return view('carpetas.edit', compact(
        'carpeta',
        'carpetas',
        'tipos_procesos',
        'procesos'
    ));
}
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'padre_id' => 'nullable|exists:carpetas,id',
        'tipo_proceso_id' => 'nullable|exists:tipos_procesos,id',
        'proceso_id' => 'nullable|exists:procesos,id',
    ]);

    $carpeta = Carpeta::findOrFail($id);

    $carpeta->update([
        'nombre' => $request->nombre,
        'padre_id' => $request->padre_id ?? null,
        'tipo_proceso_id' => $request->tipo_proceso_id ?? null,
        'proceso_id' => $request->proceso_id ?? null,
    ]);

    return redirect()->route('carpetas.index')
        ->with('success','Carpeta actualizada correctamente.');
}
}
