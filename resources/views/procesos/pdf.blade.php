<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Procesos</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 15px; font-family: Georgia, serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body>

<h2>Lista de Procesos</h2>

<p>
    <strong>Mes:</strong>
    {{ $mes ? \Carbon\Carbon::createFromDate(null, (int)$mes, 1)->locale('es')->monthName : 'Todos' }}

    &nbsp;&nbsp;

    <strong>Año:</strong>
    {{ $anio ?? 'Todos' }}
</p>

<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Posición</th>
            <th>Contrario</th>
            <th>Estado</th>
            <th>Proceso</th>
            <th>Tipo</th>
            <th>Expediente</th>
            <th>Abogado</th>
            <th>Involucrados</th>
        </tr>
    </thead>

    <tbody>
        @forelse($procesos as $p)
            <tr>
                <td>
                    {{ $p->cliente->nombres ?? '' }}
                    {{ $p->cliente->paterno ?? '' }}
                    {{ $p->cliente->materno ?? '' }}
                </td>

                <td>{{ $p->posicion->nombre ?? '---' }}</td>

                <td>{{ $p->contrario ?? '---' }}</td>

                <td>{{ $p->estadoProceso->estado_proceso ?? '---' }}</td>

                <td>{{ $p->proceso ?? '---' }}</td>

                <td>{{ $p->tipoProceso->tipo_proceso ?? '---' }}</td>

                <td>{{ $p->expediente->codigo_expediente ?? '---' }}</td>

                <td>
                    {{ $p->expediente->abogadoAsignado->empleado->nombres ?? 'Sin asignar' }}
                </td>

                <td>{{ $p->involucrados ?? '---' }}</td>

                
            </tr>
        @empty
            <tr>
                <td colspan="11" style="text-align:center;">
                    No hay procesos registrados
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>