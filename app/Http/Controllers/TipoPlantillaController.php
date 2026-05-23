<?php

namespace App\Http\Controllers;

use App\Models\TipoPlantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoPlantillaController extends Controller
{
    
   public function index(Request $request)
    {
        $query = TipoPlantilla::query();
        if (!empty($request->buscar)) {
            $query->where(function ($q) use ($request) {
                $q->where('tipo_plantilla', 'like', '%' . $request->buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
            });
        }
        $perPage = $request->get('per_page', 10);

        $tipos = $query->orderBy('id', 'asc')
                       ->paginate($perPage)
                       ->appends($request->query()); 

        return view('tipo_plantilla.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipo_plantilla.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo_plantilla' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|boolean',
        ]);

        TipoPlantilla::create([
            'tipo_plantilla' => $request->tipo_plantilla,
            'descripcion' => $request->descripcion,
            'registrado' => now(),
            'usuario_reg' => Auth::user()->name ?? null,
            'estado' => $request->estado,
        ]);

        return redirect()->route('tipo_plantilla.index')
                         ->with('success', '✅ Tipo de plantilla creado correctamente.');
    }
    public function edit(TipoPlantilla $tipoPlantilla)
    {
        return view('tipo_plantilla.edit', compact('tipoPlantilla'));
    }

    public function update(Request $request, TipoPlantilla $tipoPlantilla)
    {
        $request->validate([
            'tipo_plantilla' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|boolean',
        ]);

        $tipoPlantilla->update([
            'tipo_plantilla' => $request->tipo_plantilla,
            'descripcion' => $request->descripcion,
            'modificado' => now(),
            'usuario_mod' => Auth::user()->name ?? null,
            'estado' => $request->estado,
        ]);

        return redirect()->route('tipo_plantilla.index')
                         ->with('success', '✅ Tipo de plantilla actualizado correctamente.');
    }

    public function destroy(TipoPlantilla $tipoPlantilla)
    {
        $tipoPlantilla->delete();

        return redirect()->route('tipo_plantilla.index')
                         ->with('success', '🗑️ Tipo de plantilla eliminado correctamente.');
    }
}

