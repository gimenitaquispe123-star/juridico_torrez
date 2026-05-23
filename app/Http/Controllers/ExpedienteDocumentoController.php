<?php

namespace App\Http\Controllers;

use App\Models\ExpedienteDocumento;
use App\Models\Expediente;
use App\Models\Documento;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ExpedienteDocumentoController extends Controller
{
    public function index()
    {
        $documentos = ExpedienteDocumento::with([
            'expediente',
            'documento',
            'usuarioRegistro',
            'usuarioModificacion'
        ])->orderBy('registrado', 'asc')->get();

        return view('expedientes_documentos.index', compact('documentos'));
    }

    public function create(Expediente $expediente = null)
    {
        $expedientes = Expediente::all();
        $documentos = Documento::all();
        $usuarios = Usuario::all();

        return view('expedientes_documentos.create', compact('expedientes', 'documentos', 'usuarios', 'expediente'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_expediente' => 'required|exists:expedientes,id',
            'documento_id' => 'required|exists:documentos,id_documento',
            'observacion_descripcion' => 'nullable|string',
            'ruta_documento' => 'nullable|string|max:255',
            'estado' => 'nullable|boolean',
        ]);

        $data['usuario_reg'] = auth()->id(); 

        ExpedienteDocumento::create($data);

        return redirect()->route('expedientes-documentos.index')
            ->with('success', 'Documento registrado correctamente.');
    }

    public function show(ExpedienteDocumento $expedienteDocumento)
    {
        $expedienteDocumento->load(['expediente', 'documento', 'usuarioRegistro', 'usuarioModificacion']);
        return view('expedientes_documentos.show', compact('expedienteDocumento'));
    }

    public function edit(ExpedienteDocumento $expedienteDocumento)
    {
        $expedientes = Expediente::all();
        $documentos = Documento::all();
        $usuarios = Usuario::all();

        return view('expedientes_documentos.edit', compact('expedienteDocumento', 'expedientes', 'documentos', 'usuarios'));
    }

    public function update(Request $request, ExpedienteDocumento $expedienteDocumento)
    {
        $data = $request->validate([
            'id_expediente' => 'required|exists:expedientes,id',
            'documento_id' => 'required|exists:documentos,id_documento',
            'observacion_descripcion' => 'nullable|string',
            'ruta_documento' => 'nullable|string|max:255',
            'estado' => 'nullable|boolean',
        ]);

        $data['usuario_mod'] = auth()->id(); 

        $expedienteDocumento->update($data);

        return redirect()->route('expedientes-documentos.index')
            ->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy(ExpedienteDocumento $expedienteDocumento)
    {
        $expedienteDocumento->delete();

        return redirect()->route('expedientes-documentos.index')
            ->with('success', 'Documento eliminado correctamente.');
    }
}
