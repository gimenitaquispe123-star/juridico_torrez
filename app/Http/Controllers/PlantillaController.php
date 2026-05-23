<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\TipoPlantilla;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantillaController extends Controller
{

   public function index(Request $request)
{
    $tipoPlantilla = TipoPlantilla::all();

    $search = $request->input('search'); 
    $perPage = 10; 

    $plantillas = Plantilla::with('tipoPlantilla')
        ->when($search, function($query, $search) {
            $query->where('plantilla', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
        })
        ->orderBy('id', 'asc')
        ->paginate($perPage)
        ->appends(['search' => $search]); 

    return view('plantillas.index', compact('plantillas', 'tipoPlantilla', 'search'));
}

    public function create()
    {
        $tipos = TipoPlantilla::all();
        return view('plantillas.create', compact('tipos'));
    }

  public function store(Request $request)
{
    $request->validate([
        'id_tipo_plantilla' => 'required|exists:tipos_plantilla,id',
        'plantilla'         => 'required|string|max:255',
        'descripcion'       => 'nullable|string',
        'archivo'           => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,webp|max:8192',
    ]);

    $rutaArchivo = null;

    if ($request->hasFile('archivo')) {
        $rutaArchivo = $request->file('archivo')->store('plantillas', 'public');
    }

    Plantilla::create([
        'id_tipo_plantilla' => strtoupper($request->id_tipo_plantilla), 
        'plantilla'         => strtoupper($request->plantilla),         
        'descripcion'       => $request->descripcion,                   
        'ruta_archivo'      => strtoupper($rutaArchivo),               
        'es_original'       => true,
        'usuario_reg'       => strtoupper(auth()->user()->name ?? 'Sistema'),
    ]);

    return redirect()->route('plantillas.index')->with('success', 'Plantilla registrada correctamente.');
}


    public function edit($id)
    {
        $plantilla = Plantilla::findOrFail($id);
        $tipos = TipoPlantilla::all();
        return view('plantillas.edit', compact('plantilla', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $plantilla = Plantilla::findOrFail($id);

        $request->validate([
            'id_tipo_plantilla' => 'required|exists:tipos_plantilla,id',
            'plantilla'         => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'archivo'           => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,webp|max:8192',
        ]);

        $rutaArchivo = $plantilla->ruta_archivo;

        if ($request->hasFile('archivo')) {

            if ($rutaArchivo && Storage::disk('public')->exists($rutaArchivo)) {
                Storage::disk('public')->delete($rutaArchivo);
            }

            $rutaArchivo = $request->file('archivo')->store('plantillas', 'public');
        }

        $plantilla->update([
            'id_tipo_plantilla' => $request->id_tipo_plantilla,
            'plantilla'         => $request->plantilla,
            'descripcion'       => $request->descripcion,
            'ruta_archivo'      => $rutaArchivo,
            'usuario_mod'       => auth()->user()->name ?? 'Sistema',
            'modificado'        => now(),
        ]);

        return redirect()->route('plantillas.index')->with('success', 'Plantilla actualizada correctamente.');
    }


    public function destroy($id)
    {
        $plantilla = Plantilla::findOrFail($id);

        if ($plantilla->ruta_archivo && Storage::disk('public')->exists($plantilla->ruta_archivo)) {
            Storage::disk('public')->delete($plantilla->ruta_archivo);
        }

        $plantilla->delete();

        return redirect()->route('plantillas.index')->with('success', 'Plantilla eliminada correctamente.');
    }

    public function show($id)
    {
        $plantilla = Plantilla::with('tipoPlantilla')->findOrFail($id);
        return view('plantillas.show', compact('plantilla'));
    }

    public function verPDF($id)
    {
        $plantilla = Plantilla::findOrFail($id);

        if (!$plantilla->ruta_archivo || !Storage::disk('public')->exists($plantilla->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        $ruta = Storage::disk('public')->path($plantilla->ruta_archivo);
        return response()->file($ruta);
    }


}

