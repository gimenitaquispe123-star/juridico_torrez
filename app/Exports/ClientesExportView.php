<?php

namespace App\Exports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ClientesExportView implements FromView
{
    protected $mes;
    protected $anio;

    public function __construct($mes = null, $anio = null)
    {
        $this->mes = $mes;
        $this->anio = $anio;
    }

    public function view(): View
    {
        $query = Persona::where('id_tipo_persona', 1);

        if ($this->mes) $query->whereMonth('created_at', $this->mes);
        if ($this->anio) $query->whereYear('created_at', $this->anio);

        $clientes = $query->get();

        return view('clientes.excel', compact('clientes','mes','anio'));
    }
}
