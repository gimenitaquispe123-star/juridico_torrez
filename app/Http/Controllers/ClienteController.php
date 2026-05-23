<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Exports\ClientesExportView;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;



class ClienteController extends Controller
{
   
    public function index(Request $request)
{
    
    $buscar = $request->input('buscar');
    $perPage = $request->input('per_page', 10); 

    $query = Persona::where('id_tipo_persona', 1);

    if ($buscar) {
        $query->where(function($q) use ($buscar) {
            $q->where('nombres', 'like', "%{$buscar}%")
              ->orWhere('paterno', 'like', "%{$buscar}%")
              ->orWhere('materno', 'like', "%{$buscar}%");
        });
    }
    $clientes = $query->orderBy('id','asc')->paginate($perPage)->withQueryString();

    return view('clientes.index', compact('clientes'));
}


    public function create()
    {
        return view('clientes.create');
    }
public function store(Request $request)
{
    
    $request->validate([
        'nombres' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],
        'paterno' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],
        'materno' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],

        'ci' => ['nullable', 'string', 'unique:personas,ci', 'regex:/^\d+$/'],
        'ci_expedido' => ['nullable', 'string', 'max:50'], 
        'celular' => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],

        'direccion' => 'nullable|string|max:200',
        'email' => 'nullable|email|unique:personas,email',
        'fecha_nacimiento' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
    ], [
        'nombres.regex' => 'El campo "Nombre" solo puede contener letras y espacios.',
        'paterno.regex' => 'El campo "Apellido Paterno" solo puede contener letras y espacios.',
        'materno.regex' => 'El campo "Apellido Materno" solo puede contener letras y espacios.',
        'ci.regex' => 'El campo "Cédula" solo puede contener números.',
        'celular.regex' => 'El campo "Celular" solo puede contener números.',
    ]);


    $data = $request->only([
        'nombres', 'paterno', 'materno', 'ci', 'ci_expedido',
        'celular', 'direccion', 'email', 'fecha_nacimiento'
    ]);

    $data['nombres'] = mb_strtoupper($data['nombres'], 'UTF-8');
    $data['paterno'] = mb_strtoupper($data['paterno'], 'UTF-8');
    $data['materno'] = isset($data['materno']) ? mb_strtoupper($data['materno'], 'UTF-8') : null;
    $data['direccion'] = isset($data['direccion']) ? mb_strtoupper($data['direccion'], 'UTF-8') : null;
    $data['ci_expedido'] = isset($data['ci_expedido']) ? mb_strtoupper($data['ci_expedido'], 'UTF-8') : null;

    $data['id_tipo_persona'] = 1; 
    $data['usuario_reg'] = auth()->id(); 
    $data['usuario_mod'] = null;        

    Persona::create($data);

    return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente');
}


    public function edit(Persona $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

   public function update(Request $request, Persona $cliente)
{
    $request->validate([

        'nombres' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],
        'paterno' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],
        'materno' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/'],

        'ci' => ['nullable','string', Rule::unique('personas','ci')->ignore($cliente->id), 'regex:/^\d+$/'],
        'ci_expedido' => ['nullable','string','max:50'], 
        'celular' => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],

        'direccion' => 'nullable|string|max:200',
        'email' => ['nullable','email', Rule::unique('personas','email')->ignore($cliente->id)],
        'fecha_nacimiento' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
    ], [
        
        'nombres.regex' => 'El campo "Nombre" solo puede contener letras y espacios.',
        'paterno.regex' => 'El campo "Apellido Paterno" solo puede contener letras y espacios.',
        'materno.regex' => 'El campo "Apellido Materno" solo puede contener letras y espacios.',
        'ci.regex' => 'El campo "Cédula" solo puede contener solo números.',
        'celular.regex' => 'El campo "Celular" solo puede contener solo números.',
    ]);

    $data = $request->only([
        'nombres','paterno','materno','ci','ci_expedido',
        'celular','direccion','email','fecha_nacimiento'
    ]);

    $data['nombres'] = strtoupper($data['nombres']);
    $data['paterno'] = strtoupper($data['paterno']);
    $data['materno'] = isset($data['materno']) ? strtoupper($data['materno']) : null;

    $data['usuario_mod'] = Auth::id(); 

    $cliente->update($data);

    return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
}


    public function show(Persona $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function destroy(Persona $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }


public function exportPdf(Request $request)
{
    $fecha = $request->fecha;

    $mes = null;
    $anio = null;

    if (!empty($fecha) && strpos($fecha, '-') !== false) {
        [$anio, $mes] = explode('-', $fecha);

        $anio = (int) $anio;
        $mes = (int) $mes;
    }

    $query = Persona::where('id_tipo_persona', 1);

    if ($mes) {
        $query->whereMonth('created_at', $mes);
    }

    if ($anio) {
        $query->whereYear('created_at', $anio);
    }

    $clientes = $query->get();

    return Pdf::loadView('clientes.pdf', compact('clientes', 'mes', 'anio'))
        ->stream('clientes.pdf');
}

}
