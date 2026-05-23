<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Expedientes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h2 style="font-family: Georgia, serif;">Lista de Expedientes</h2>

@php
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
        4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
        7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
        10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
@endphp

<p>
    <strong>Mes:</strong> {{ $mes ? $meses[$mes] : 'Todos' }} 
    &nbsp;&nbsp; 
    <strong>Año:</strong> {{ $anio ?? 'Todos' }}
</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Expediente N°</th>
            <th>Cliente</th>
            <th>Demandante</th>
            <th>Demandado</th>
            <th>Abogado Asignado</th>
            <th>Estado</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        @forelse($expedientes as $expediente)
            <tr>
                <td>{{ $expediente->codigo_expediente ?? '---' }}</td>

                <td>{{ $expediente->nro_expediente ?? '---' }}</td>

                <td>
                    {{ $expediente->cliente 
                        ? $expediente->cliente->nombres . ' ' . $expediente->cliente->paterno . ' ' . $expediente->cliente->materno 
                        : '---' }}
                </td>
                <td>{{ $expediente->demandante ?? '---' }}</td>
                <td>{{ $expediente->demandado ?? '---' }}</td>
                <td>
                    {{ $expediente->abogadoAsignado && $expediente->abogadoAsignado->empleado
                        ? $expediente->abogadoAsignado->empleado->nombres . ' ' . $expediente->abogadoAsignado->empleado->paterno
                        : 'Sin asignar' }}
                </td>

                <td>{{ strtoupper($expediente->estado_expediente ?? '---') }}</td>

                <td>
                    {{ $expediente->registrado 
                        ? \Carbon\Carbon::parse($expediente->registrado)->format('d/m/Y H:i') 
                        : '---' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center;">
                    No hay expedientes registrados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>