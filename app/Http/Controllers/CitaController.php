<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Persona;
use App\Notifications\CitaCreadaNotification;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaController extends Controller
{
  public function index(Request $request)
{
    $orderField = 'fecha_hora_cita';

    $porPagina = $request->get('porPagina', 5);

   

    $user = Auth::user();

$query = Cita::with([
    'cliente',
    'empleado',
    'usuarioRegistrado',
    'usuarioModificado'
]);

$queryCalendar = Cita::select(
    'id',
    'titulo',
    'fecha_hora_cita',
    'id_cliente',
    'id_empleado',
    'nota',
    'asunto',
    'mensaje',
    'lugar_cita',
    'estado_cita'
);

// SI ES ABOGADO → SOLO SUS CITAS
if ($user->rol === 'abogado') {

    $query->where('id_empleado', $user->persona_id);

    $queryCalendar->where('id_empleado', $user->persona_id);
}

$citas = $query
    ->orderBy($orderField, 'asc')
    ->paginate($porPagina);

$allCitas = $queryCalendar->get();

    // CLIENTES
    $clientes = Persona::whereHas('tipoPersona', function ($query) {

        $query->where('tipo_persona', 'Cliente');

    })->get();

    // EMPLEADOS
    $empleados = Persona::whereHas('tipoPersona', function ($query) {

        $query->whereIn('tipo_persona', [
            'abogado',
            'administrador',
            'secretaria'
        ]);

    })->get();

    // EVENTOS DEL CALENDARIO
    $events = $allCitas->map(function ($cita) {

        return [

            'id'    => $cita->id,

            'title' => $cita->titulo,

            'start' => $cita->fecha_hora_cita
                ? \Carbon\Carbon::parse($cita->fecha_hora_cita)->toDateTimeString()
                : null,

            'extendedProps' => [

                'id_cliente'   => $cita->id_cliente,
                'id_empleado'  => $cita->id_empleado,
                'nota'         => $cita->nota,
                'asunto'       => $cita->asunto,
                'mensaje'      => $cita->mensaje,
                'lugar_cita'   => $cita->lugar_cita,
                'estado_cita'  => $cita->estado_cita,

            ],

            'color' => match ($cita->estado_cita) {

                'Pendiente'  => 'orange',
                'Confirmada' => 'green',
                'Cancelada'  => 'red',

                default => 'blue',
            }

        ];
    });

    return view('citas.index', compact(
        'citas',
        'clientes',
        'empleados',
        'events',
        'porPagina'
    ));
}
public function create()
{
    // Solo clientes
    $tipoCliente = \App\Models\TipoPersona::where('tipo_persona', 'cliente')->first();
    $clientes = Persona::where('id_tipo_persona', $tipoCliente?->id)->get();

    // Empleados: secretaria y administrador (puedes agregar abogado si quieres)
    $tiposEmpleados = \App\Models\TipoPersona::whereIn('tipo_persona', ['secretaria', 'administrador'])->pluck('id');
    $empleados = Persona::whereIn('id_tipo_persona', $tiposEmpleados)->get();

    return view('citas.create', compact('clientes', 'empleados'));
}


   public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'nullable|exists:personas,id', 
        'id_empleado' => 'required|exists:personas,id',
        'titulo' => 'nullable|string|max:150',
        'nota' => 'nullable|string|max:255',
        'asunto' => 'nullable|string|max:255',
        'mensaje' => 'nullable|string',
        'fecha_hora_cita' => 'required|date',
        'lugar_cita' => 'nullable|string|max:255',
        'estado_cita' => 'required|string|max:50',
    ]);

    $cita = new Cita($request->all());
    $cita->usuario_registrado = Auth::id();
    $cita->usuario_modificado = Auth::id();
    $cita->registrado = now();
    $cita->modificado = now();
    $cita->save();

    // 🔔 ENVIAR NOTIFICACIÓN AL USUARIO LOGUEADO
    $usuario = Auth::user();
    $usuario->notify(new \App\Notifications\CitaCreadaNotification($cita));

    return redirect()->route('citas.index')
        ->with('success', 'Cita creada correctamente y notificación enviada.');
}

    public function show(Cita $cita)
    {
        $cita->load(['cliente', 'empleado', 'usuarioRegistrado', 'usuarioModificado']);
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        $clientes = Persona::all();
        $empleados = Persona::all();
        return view('citas.edit', compact('cita', 'clientes', 'empleados'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'id_cliente' => 'required|exists:personas,id',
            'id_empleado' => 'required|exists:personas,id',
            'titulo' => 'nullable|string|max:150',
            'nota' => 'nullable|string|max:255',
            'asunto' => 'nullable|string|max:255',
            'mensaje' => 'nullable|string',
            'fecha_hora_cita' => 'required|date',
            'lugar_cita' => 'nullable|string|max:255',
            'estado_cita' => 'required|string|max:50',
        ]);

        $cita->fill($request->all());
        $cita->usuario_modificado = Auth::id();
        $cita->modificado = now();
        $cita->save();

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}
