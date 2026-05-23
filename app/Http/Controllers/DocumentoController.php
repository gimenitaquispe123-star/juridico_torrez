<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Carpeta;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
 

class DocumentoController extends Controller
{
    
   public function index(Request $request)
{
    $perPage = $request->perPage ?? 15;

    if ($request->carpeta_id) {

        $carpeta = Carpeta::with('subcarpetas', 'documentos.usuario')
            ->findOrFail($request->carpeta_id);

        $documentos = $carpeta->documentos()

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('nombre', 'like', '%' . $request->search . '%')
                      ->orWhere('tipo', 'like', '%' . $request->search . '%');

                });

            })

            ->orderBy('fecha_subida', 'asc')->paginate($perPage)->appends($request->all());

        return view('documentos.index', compact('carpeta', 'documentos'));
    }

    $documentos = Documento::when($request->search, function ($query) use ($request) {

            $query->where(function ($q) use ($request) {

                $q->where('nombre', 'like', '%' . $request->search . '%')
                  ->orWhere('tipo', 'like', '%' . $request->search . '%');

            });

        })

        ->orderBy('fecha_subida', 'asc')

        ->paginate($perPage)

        ->appends($request->all());

    return view('documentos.index', compact('documentos'));
}
    
    public function create(Request $request)
    {
        $carpeta_id = $request->carpeta_id;
        $carpeta = Carpeta::find($carpeta_id);

        if (!$carpeta) {
            return redirect()->route('carpetas.index')
                             ->with('error', 'Debe seleccionar una carpeta válida antes de subir un documento.');
        }

        return view('documentos.create', compact('carpeta_id', 'carpeta'));
    }

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:51200',
        'carpeta_id' => 'nullable|exists:carpetas,id',
        'proceso_id' => 'nullable|exists:procesos,id',
        'expediente_id' => 'nullable|exists:expedientes,id',
        'descripcion' => 'nullable|string',
    ]);

    $disk = 'public';

    if ($request->carpeta_id) {
        $dir = 'documentos/carpeta_' . $request->carpeta_id;
    } elseif ($request->proceso_id) {
        $dir = 'documentos/proceso_' . $request->proceso_id;
    } elseif ($request->expediente_id) {
        $dir = 'documentos/expediente_' . $request->expediente_id;
    } else {
        $dir = 'documentos/otros';
    }
    $path = $request->file('archivo')->store($dir, $disk);

    $fullPath = Storage::disk($disk)->path($path);
    $sha256 = file_exists($fullPath) ? hash_file('sha256', $fullPath) : null;
    $documento = Documento::create([
        'nombre' => $request->nombre,
        'tipo' => $request->file('archivo')->getClientOriginalExtension(),
        'archivo' => $path,
        'descripcion' => $request->descripcion,
        'fecha_subida' => now(),
        'carpeta_id' => $request->carpeta_id,
        'proceso_id' => $request->proceso_id,
        'expediente_id' => $request->expediente_id,
        'id_usuario' => Auth::id(),
        'userid_sha256' => $sha256,
      
    ]);

    if ($request->proceso_id) {
        return redirect()
            ->route('procesos.show', $request->proceso_id)
            ->with('success', 'Documento subido correctamente al proceso.');
    }

    if ($request->expediente_id) {
        return redirect()
            ->route('expedientes.show', $request->expediente_id)
            ->with('success', 'Documento subido correctamente al expediente.');
    }

    if ($request->carpeta_id) {
        return redirect()
            ->route('carpetas.show', $request->carpeta_id)
            ->with('success', 'Documento subido correctamente a la carpeta.');
    }

    return redirect()
        ->route('documentos.index')
        ->with('success', 'Documento subido correctamente.');
}
public function show($id)
{
    $documento = Documento::findOrFail($id);

    $carpetas = Carpeta::with('subcarpetas')->get();

    return view('documentos.show', compact(
        'documento',
        'carpetas'
    ));
}
    
    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        Storage::disk('private')->delete($documento->archivo);
        $documento->delete();

        return back()->with('success','Documento eliminado correctamente.');
    }

    
    public function download($id)
{
    $documento = Documento::findOrFail($id);
    $disk = 'public';

    if (!Storage::disk($disk)->exists($documento->archivo)) {
        abort(404, 'El archivo no existe.');
    }

    $filePath = Storage::disk($disk)->path($documento->archivo);
    $fileName = $documento->nombre;

    if (!str_contains($fileName, '.')) {
        $fileName .= '.' . $documento->tipo;
    }

    $previewable = ['pdf','jpg','jpeg','png','gif','svg'];
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if (in_array($extension, $previewable)) {
        return response()->file($filePath, [
            'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);
    }

    return Storage::disk($disk)->download($documento->archivo, $fileName);
}
    


  public function extraerTextoOCR(Request $request, $id_documento)
{
    $documento = Documento::findOrFail($id_documento);
    $path = Storage::disk('public')->path($documento->archivo);

    if (!file_exists($path)) {
        return back()->with('error', 'Archivo no encontrado');
    }

    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $texto = '';

    if (in_array($extension, ['jpg','jpeg','png','tif','tiff'])) {

        $texto = (new TesseractOCR($path))
            ->executable("C:\\Program Files\\Tesseract-OCR\\tesseract.exe")
            ->tessdataDir("C:\\Program Files\\Tesseract-OCR\\tessdata")
            ->lang('spa')
            ->run();

    } else {
        return back()->with('error', 'Formato no soportado para OCR');
    }

    $documento->texto_extraido = $texto;
    $documento->save();

    return back()->with('success', 'OCR aplicado correctamente');
}
public function updateTexto(Request $request, $id_documento)
{
    $documento = Documento::findOrFail($id_documento);

    $request->validate([
        'texto_extraido' => 'required|string',
    ]);

    $documento->texto_extraido = $request->texto_extraido;
    $documento->save();



    return redirect()->route('documentos.show', $documento->id_documento)
                     ->with('success', 'Texto actualizado correctamente y log registrado.');
}

    public function editar($id)
    {
        $documento = Documento::findOrFail($id);
        return view('documentos.edit', compact('documento'));
    }

     public function guardar(Request $request, $id)
    {
        $documento = Documento::findOrFail($id); 
        Storage::put($documento->ruta, $request->contenido);
        $documento->temporal = false;
        $documento->save();

        return redirect()->back()->with('success', 'Documento guardado correctamente.');
    }

    public function descargar($id)
{
    $documento = Documento::findOrFail($id);

    
    return Storage::disk('private')->download($documento->archivo, $documento->nombre);
}
public function ver($id)
{
    $documento = Documento::findOrFail($id);

    $path = Storage::disk('public')->path($documento->archivo);
    $mime = Storage::disk('public')->mimeType($documento->archivo);

    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline'
    ]);
}


public function guardarNuevoOCR(Request $request, $id)
{
    $documento = Documento::findOrFail($id);

    $request->validate([
        'nuevo_nombre' => 'required|string|max:255',
        'texto_extraido' => 'required|string',
    ]);

    $nuevoDocumento = new Documento();

    $nuevoDocumento->nombre = $request->nuevo_nombre;
  $nuevoDocumento->tipo = 'OCR EDITADO';
    $nuevoDocumento->archivo = $documento->archivo;
    $nuevoDocumento->descripcion = 'VERSIÓN OCR EDITADA';
    $nuevoDocumento->texto_extraido = $request->texto_extraido;
    $nuevoDocumento->fecha_subida = now();

    $nuevoDocumento->carpeta_id = $documento->carpeta_id;
    $nuevoDocumento->proceso_id = $documento->proceso_id;
    $nuevoDocumento->expediente_id = $documento->expediente_id;

    $nuevoDocumento->id_usuario = auth()->id();

    $nuevoDocumento->save();

    return redirect()
        ->route('documentos.show', $nuevoDocumento->id_documento)
        ->with('success', 'Nuevo documento OCR creado correctamente.');
}
}


