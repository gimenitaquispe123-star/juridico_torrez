<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReciboPago;
use App\Models\Pago;

class ReciboPagoController extends Controller
{
    /**
     * Mostrar la lista de recibos registrados
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        $search = $request->get('search');

        $query = ReciboPago::with('pago')->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where('numero_recibo', 'like', "%{$search}%")
                  ->orWhere('glosa_pago', 'like', "%{$search}%")
                  ->orWhereHas('pago', function($q) use ($search) {
                      $q->where('id_pago', 'like', "%{$search}%");
                  });
        }

        $recibos = $query->paginate($perPage)->appends($request->all());

        return view('recibos_pagos.index', compact('recibos'));
    }

    /**
     * Mostrar formulario para crear un nuevo recibo
     */
    public function create()
    {
        $pagos = Pago::all();
        return view('recibos_pagos.create', compact('pagos'));
    }

    /**
     * Guardar un nuevo recibo en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pago' => 'required|exists:pagos,id_pago',
            'numero_recibo' => 'required|string|max:50|unique:recibos_pagos,numero_recibo',
            'glosa_pago' => 'nullable|string',
            'monto_pago' => 'required|numeric|min:0.01',
            'estado' => 'required|in:Emitido,Anulado',
            'tipo_pago' => 'required|in:Efectivo,Transferencia,Cheque',
        ]);

        // Crear el recibo
        $recibo = ReciboPago::create($request->all());

        // 🔄 Actualizar el pago relacionado
        $pago = $recibo->pago;
        $pago->monto_pagado += $recibo->monto_pago;
        $pago->estado = $pago->monto_pagado >= $pago->monto_total ? 'Pagado' : 'Pendiente';
        $pago->save();

        return redirect()->route('recibos_pagos.index')->with('success', 'Recibo registrado correctamente.');
    }

    /**
     * Mostrar los detalles de un recibo específico
     */
    public function show($id)
    {
        $recibo = ReciboPago::with('pago')->findOrFail($id);
        return view('recibos_pagos.show', compact('recibo'));
    }

    /**
     * Mostrar formulario de edición de un recibo
     */
    public function edit($id)
    {
        $recibo = ReciboPago::findOrFail($id);
        $pagos = Pago::all();
        return view('recibos_pagos.edit', compact('recibo', 'pagos'));
    }

    /**
     * Actualizar los datos de un recibo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pago' => 'required|exists:pagos,id_pago',
            'numero_recibo' => 'required|string|max:50|unique:recibos_pagos,numero_recibo,' . $id,
            'glosa_pago' => 'nullable|string',
            'monto_pago' => 'required|numeric|min:0.01',
            'estado' => 'required|in:Emitido,Anulado',
            'tipo_pago' => 'required|in:Efectivo,Transferencia,Cheque',
        ]);

        $recibo = ReciboPago::findOrFail($id);
        $recibo->update($request->all());

        // 🔄 Recalcular el total pagado del pago relacionado
        $pago = $recibo->pago;
        $pago->monto_pagado = $pago->recibos()->where('estado', 'Emitido')->sum('monto_pago');
        $pago->estado = $pago->monto_pagado >= $pago->monto_total ? 'Pagado' : 'Pendiente';
        $pago->save();

        return redirect()->route('recibos_pagos.index')->with('success', 'Recibo actualizado correctamente.');
    }

    /**
     * Eliminar un recibo
     */
    public function destroy($id)
    {
        $recibo = ReciboPago::findOrFail($id);
        $pago = $recibo->pago;

        $recibo->delete();

        // 🔄 Actualizar el monto total del pago tras eliminar el recibo
        $pago->monto_pagado = $pago->recibos()->where('estado', 'Emitido')->sum('monto_pago');
        $pago->estado = $pago->monto_pagado >= $pago->monto_total ? 'Pagado' : 'Pendiente';
        $pago->save();

        return redirect()->route('recibos_pagos.index')->with('success', 'Recibo eliminado correctamente.');
    }
}
