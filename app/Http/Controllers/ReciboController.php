<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use PDF;

class ReciboController extends Controller
{
    public function generarRecibo($id_pago)
    {
        
        $pago = Pago::with('cliente')->findOrFail($id_pago);

        // Generar el número del recibo con ceros
        $numero_recibo = 'REC-' . str_pad($pago->id_pago, 5, '0', STR_PAD_LEFT);

   
        $pdf = PDF::loadView('recibos.pdf', compact('pago', 'numero_recibo'))
                    ->setPaper('A4', 'portrait');

        
        return $pdf->stream("Recibo-$numero_recibo.pdf");
        
        // Si quieres descargar automáticamente, usar:
        // return $pdf->download("Recibo-$numero_recibo.pdf");
    }
}
