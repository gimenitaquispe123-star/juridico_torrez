<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Audiencia;
use App\Models\Usuario; 
use App\Models\Cita;
use App\Models\Persona;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
  

public function index()
{
    $citas = Cita::all();       
    $clientes = Persona::all();  
    $empleados = Persona::all(); 

    $events = $citas->map(function($cita) {
        return [
            'id' => $cita->id,
            'title' => $cita->titulo,
            'start' => $cita->fecha_hora_cita,
            'extendedProps' => [
                'id_cliente' => $cita->id_cliente,
                'id_empleado' => $cita->id_empleado,
                'lugar_cita' => $cita->lugar_cita,
                'estado_cita' => $cita->estado_cita,
                'mensaje' => $cita->mensaje
            ],
            'color' => $cita->estado_cita === 'Pendiente' ? 'orange' :
                      ($cita->estado_cita === 'Confirmada' ? 'green' : 'red')
        ];
    });

    return view('citas.index', compact('clientes','empleados','events'));
}

public function create()
{
  
    $abogados = Usuario::where('rol', 'abogado')->get();

    return view('agendas.create', compact('abogados'));
}

 
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo_evento' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
        ]);

        Agenda::create($request->all());

        return redirect()->route('agendas.index')->with('success', 'Evento registrado correctamente.');
    }

    public function edit(Agenda $agenda)
    {
        return view('agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo_evento' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
        ]);

        $agenda->update($request->all());

        return redirect()->route('agendas.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Evento eliminado correctamente.');
    }

    public function getEventos()
    {
        $agendas = Agenda::all();

        $events = $agendas->map(function ($agenda) {
            return [
                'id' => 'agenda-' . $agenda->id_agenda,
                'title' => $agenda->titulo,
                'start' => $agenda->fecha . 'T' . $agenda->hora_inicio,
                'end' => $agenda->hora_fin ? $agenda->fecha . 'T' . $agenda->hora_fin : null,
                'color' => '#28a745', 
                'allDay' => false,
                'url' => route('agendas.edit', $agenda), 
            ];
        });

        return response()->json($events);
    }

    public function events()
{
    $audiencias = Audiencia::all();

    $events = $audiencias->map(function($a) {
        return [
            'id' => $a->id,
            'title' => $a->titulo ?? "{$a->tipo_audiencia} - {$a->demandante} vs {$a->demandado}",
            'start' => $a->start,
            'end' => $a->end,
            'extendedProps' => [
                'proceso' => $a->proceso,
                'tipo_proceso' => $a->tipo_proceso,
                'tipo_audiencia' => $a->tipo_audiencia,
                'demandante' => $a->demandante,
                'demandado' => $a->demandado,
                'abogado_id' => $a->abogado_id,
                'estado' => $a->estado,
                'juzgado' => $a->juzgado,
                'juez' => $a->juez,
            ],
            'color' => match($a->estado) {
                'pendiente' => '#FFA500',
                'realizada' => '#28a745',
                'reprogramada' => '#007bff',
                'suspendida' => '#dc3545',
                default => '#6c757d',
            },
        ];
    });

    return response()->json($events);
}

}
