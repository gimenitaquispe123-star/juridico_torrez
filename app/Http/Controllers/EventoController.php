<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Familiar;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    
    public function index()
    {
        $eventos = Evento::with('familiar')->paginate(10);
        return view('eventos.index', compact('eventos'));
    }

    
    public function eventosJson()
    {
        $eventos = Evento::with('familiar')->get();

        $eventos = $eventos->map(function ($evento) {
            return [
                'id'    => $evento->id,
                'title' => $evento->tipo . ' - ' . ($evento->familiar->nombre ?? 'Sin familiar'),
                'start' => $evento->fecha,
                'extendedProps' => [
                    'observaciones' => $evento->observaciones,
                    'familiar'      => $evento->familiar->nombre ?? '',
                ],
            ];
        });

        return response()->json($eventos);
    }

    public function create($familiar_id)
    {
        $familiar = Familiar::findOrFail($familiar_id);
        return view('eventos.create', compact('familiar'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'familiar_id'   => 'required|exists:familiares,id_familiar',
            'tipo'          => 'required|string|max:255',
            'fecha'         => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        Evento::create($request->all());

        return redirect()->route('eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }

 
    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

  
    public function edit(Evento $evento)
    {
        $familiar = $evento->familiar;
        return view('eventos.edit', compact('evento', 'familiar'));
    }

 
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'tipo'          => 'required|string|max:255',
            'fecha'         => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}

