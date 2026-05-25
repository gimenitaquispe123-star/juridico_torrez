<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\ExpedienteDigitalizado;
use App\Models\Expediente;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FPDF;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;


class ExpedienteDigitalizadoController extends Controller
{
 public function index()
{
    $user = auth()->user();

    $query = ExpedienteDigitalizado::with([
        'cliente',
        'expediente'
    ]);

    if ($user->rol === 'abogado') {

        $query->whereHas('expediente.abogadoAsignado', function ($q) use ($user) {

            $q->where('id_empleado', $user->persona_id);

        });
    }

    $digitalizados = $query->paginate(10);

    $clientes = Persona::whereHas('expedientes')->get();

    $expedientes = Expediente::all();

    return view('expedientes_digitalizados.index', compact(
        'digitalizados',
        'clientes',
        'expedientes'
    ));
}
public function store(Request $request)
{
    $request->validate([
        'id_cliente'       => 'required|exists:personas,id',
        'id_expediente'    => 'required|exists:expedientes,id|unique:expedientes_digitalizados,id_expediente',
        'tipo_expediente'  => 'required|string|max:255',
        'texto_expediente' => 'nullable|string|max:1000',
        'imagenes.*'       => 'nullable|image|mimes:jpg,jpeg,png,bmp,tiff,gif|max:20480',
        'url_documento'    => 'nullable|file|mimes:pdf,doc,docx|max:20480',
    ]);

    $expediente = Expediente::findOrFail($request->id_expediente);
    $nroExpediente = $expediente->nro_expediente;

    $carpeta = storage_path('app/public/expedientes_files');

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $rutaFinal = null;

    if ($request->hasFile('imagenes')) {

        $pdf = new \FPDF();
        $pdf->SetAutoPageBreak(true, 10);

        foreach ($request->file('imagenes') as $imagen) {

            $nombreImagen = time().'_'.Str::slug(
                pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME)
            ).'.'.$imagen->getClientOriginalExtension();

            $imagen->move($carpeta, $nombreImagen);

            $pdf->AddPage();
            $pdf->Image($carpeta.'/'.$nombreImagen, 10, 10, 190);
        }

        $nombrePDF = 'expediente_'.$nroExpediente.'_'.time().'.pdf';
        $rutaPDF = $carpeta.'/'.$nombrePDF;

        $pdf->Output('F', $rutaPDF);

        $rutaFinal = 'storage/expedientes_files/'.$nombrePDF;
    }

    elseif ($request->hasFile('url_documento')) {

        $archivo = $request->file('url_documento');

        $nombreArchivo = time().'_'.Str::slug(
            pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)
        ).'.'.$archivo->getClientOriginalExtension();

        $archivo->move($carpeta, $nombreArchivo);

        $rutaFinal = 'storage/expedientes_files/'.$nombreArchivo;
    }

    if (!$rutaFinal) {
        return back()->with('error', 'Debe subir imágenes o un archivo PDF.');
    }

    ExpedienteDigitalizado::create([
        'id_cliente'       => $request->id_cliente,
        'id_expediente'    => $request->id_expediente,
        'nro_expediente'   => $nroExpediente,
        'tipo_expediente'  => mb_strtoupper($request->tipo_expediente, 'UTF-8'),
        'texto_expediente' => mb_strtoupper($request->texto_expediente ?? '', 'UTF-8'),
        'url_documento'    => $rutaFinal,
        'estado'           => 'activo',
        'usuario_reg'      => Auth::id(),
    ]);

    return redirect()
        ->route('expedientes_digitalizados.index')
        ->with('success', 'Expediente digitalizado correctamente.');
}
    public function storeMultiple(Request $request)
{
   
    $request->validate([
        'id_cliente'        => 'required|exists:personas,id',
        'id_expediente'     => 'required|exists:expedientes,id|unique:expedientes_digitalizados,id_expediente',
        'nro_expediente'    => 'required|string|max:255',
        'tipo_expediente'   => 'required|string|max:255',
        'texto_expediente'  => 'nullable|string|max:1000',
        'imagenes.*'        => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
        'url_documento'     => 'nullable|file|mimes:pdf,doc,docx|max:20480',
    ]);

    if (!$request->hasFile('imagenes') && !$request->hasFile('url_documento')) {
        return back()->with('error', 'Debe subir al menos un archivo.');
    }

    $carpeta = storage_path('app/public/expedientes_files');

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $rutaFinal = null;

    if ($request->hasFile('imagenes')) {

        $pdf = new \FPDF();
        $pdf->SetAutoPageBreak(true, 10);

        foreach ($request->file('imagenes') as $imagen) {

            $nombreImagen = time().'_'.
                \Str::slug(pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME)).
                '.'.$imagen->getClientOriginalExtension();

            $rutaImagen = $carpeta.'/'.$nombreImagen;
            $imagen->move($carpeta, $nombreImagen);

            $pdf->AddPage();
            $pdf->Image($rutaImagen, 10, 10, 190);
        }

        $nombrePDF = 'expediente_'.time().'.pdf';
        $rutaPDF = $carpeta.'/'.$nombrePDF;
        $pdf->Output('F', $rutaPDF);

        $rutaFinal = 'storage/expedientes_files/'.$nombrePDF;
    }

    elseif ($request->hasFile('url_documento')) {

        $archivo = $request->file('url_documento');

        $nombreArchivo = time().'_'.
            \Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)).
            '.'.$archivo->getClientOriginalExtension();

        $archivo->move($carpeta, $nombreArchivo);

        $rutaFinal = 'storage/expedientes_files/'.$nombreArchivo;
    }

    $expediente = new ExpedienteDigitalizado();
    $expediente->id_cliente       = $request->id_cliente;
    $expediente->id_expediente    = $request->id_expediente;
    $expediente->nro_expediente   = mb_strtoupper($request->nro_expediente, 'UTF-8');
    $expediente->tipo_expediente  = mb_strtoupper($request->tipo_expediente, 'UTF-8');
    $expediente->texto_expediente = mb_strtoupper($request->texto_expediente ?? '', 'UTF-8');
    $expediente->url_documento    = $rutaFinal;
    $expediente->estado           = 'activo';
    $expediente->usuario_reg      = Auth::id();
    $expediente->save();

    return redirect()
        ->route('expedientes_digitalizados.index')
        ->with('success', 'Expediente digitalizado correctamente.');
}
public function edit(ExpedienteDigitalizado $expedientes_digitalizado)
{
    $clientes = Persona::whereHas('expedientes')->get();
    $expedientes = Expediente::all();

    return view('expedientes_digitalizados.edit', compact(
        'expedientes_digitalizado',
        'clientes',
        'expedientes'
    ));
}


public function update(Request $request, ExpedienteDigitalizado $expedientes_digitalizado)
{
    $request->validate([
        'id_cliente'        => 'required|exists:personas,id',
        'id_expediente'     => 'required|exists:expedientes,id',
        'nro_expediente'    => 'required|string|max:255',
        'tipo_expediente'   => 'required|string|max:255',
        'texto_expediente'  => 'nullable|string|max:1000',
        'imagenes.*'        => 'nullable|image|mimes:jpg,jpeg,png,bmp,tiff,gif|max:20480',
    ]);

    $expedientes_digitalizado->update([
        'id_cliente'       => $request->id_cliente,
        'id_expediente'    => $request->id_expediente,
        'nro_expediente'   => mb_strtoupper($request->nro_expediente, 'UTF-8'),
        'tipo_expediente'  => mb_strtoupper($request->tipo_expediente, 'UTF-8'),
        'texto_expediente' => mb_strtoupper($request->texto_expediente ?? '', 'UTF-8'),
        'usuario_mod'      => auth()->id()
    ]);

    if ($request->hasFile('imagenes')) {

        $carpeta = storage_path('app/public/expedientes_files');

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $pdf = new \setasign\Fpdi\Fpdi();

        $rutaAnterior = null;

        if ($expedientes_digitalizado->url_documento) {

            $rutaAnterior = storage_path(
                'app/public/expedientes_files/' .
                basename($expedientes_digitalizado->url_documento)
            );

            if (file_exists($rutaAnterior)) {

                $pageCount = $pdf->setSourceFile($rutaAnterior);

                for ($i = 1; $i <= $pageCount; $i++) {

                    $template = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($template);

                    $pdf->AddPage(
                        $size['orientation'],
                        [$size['width'], $size['height']]
                    );

                    $pdf->useTemplate($template);
                }
            }
        }

        foreach ($request->file('imagenes') as $imagen) {

            $nombreImagen = time() . '_' .
                \Str::slug(pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME)) .
                '.' . $imagen->getClientOriginalExtension();

            $rutaImagen = $carpeta . '/' . $nombreImagen;

            $imagen->move($carpeta, $nombreImagen);

            $pdf->AddPage();
            $pdf->Image($rutaImagen, 10, 10, 190);
        }

        $nombrePDF = 'expediente_' . time() . '.pdf';
        $rutaPDF = $carpeta . '/' . $nombrePDF;

        $pdf->Output('F', $rutaPDF);

        if ($rutaAnterior && file_exists($rutaAnterior)) {
            unlink($rutaAnterior);
        }

        $expedientes_digitalizado->url_documento = 'storage/expedientes_files/' . $nombrePDF;
        $expedientes_digitalizado->save();
    }

    return redirect()
        ->route('expedientes_digitalizados.index')
        ->with('success', 'Expediente actualizado y páginas agregadas correctamente.');
}

public function destroy($id)
{
    $expediente = ExpedienteDigitalizado::findOrFail($id);

    if ($expediente->url_documento) {
     
        $ruta = str_replace('storage/', '', $expediente->url_documento);

        if (Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        }
    }

    $expediente->delete();

    return redirect()->route('expedientes_digitalizados.index')
                     ->with('success', 'Expediente eliminado correctamente.');
}
public function show($id)
{
    $expediente = ExpedienteDigitalizado::with(['cliente', 'expediente'])->findOrFail($id);
    return view('expedientes_digitalizados.show', compact('expediente'));
}


 public function verPDF($nombreArchivo)
    {
        $ruta = storage_path('app/public/expedientes_files/' . $nombreArchivo);

        if (!file_exists($ruta)) {
            abort(404, 'Archivo no encontrado');
        }
        return response()->file($ruta);
    }
}
