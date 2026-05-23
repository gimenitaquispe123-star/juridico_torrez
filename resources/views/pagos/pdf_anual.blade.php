<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Anual de Pagos - {{ $year }}</title>

    <style>
        body{
            font-family: Georgia, serif;
            font-size:13px;
        }

        h2{
            text-align:center;
            margin-bottom:10px;
        }

        .info{
            text-align:center;
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #000;
            padding:6px;
            text-align:center;
        }

        th{
            background:#f2f2f2;
        }

        .text-left{
            text-align:left;
        }

        .resumen{
            margin-top:20px;
            width:60%;
        }

        .resumen td{
            border:1px solid #000;
            padding:6px;
        }
    </style>

</head>

<body>

<h2>REPORTE ANUAL DE PAGOS</h2>

<div class="info">
    Gestión: <strong>{{ $year }}</strong>
</div>

<table>

<thead>
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Detalle</th>
    <th>Pagado (Bs)</th>
    <th>Pendiente (Bs)</th>
    <th>Fecha Pago</th>
</tr>
</thead>

<tbody>

@forelse($pagos as $pago)

<tr>

    <td>{{ $pago->id_pago }}</td>

    <td class="text-left">
        {{ $pago->cliente->nombre_completo ?? 'Sin cliente' }}
    </td>

    <td class="text-left">
        {{ $pago->glosa_pago ?? '-' }}
    </td>

    <td>
        {{ number_format($pago->monto_pagado ?? 0, 2, '.', ',') }}
    </td>

    <td>
        {{ number_format($pago->monto_pendiente ?? 0, 2, '.', ',') }}
    </td>

    <td>
        {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') : '-' }}
    </td>

</tr>

@empty

<tr>
    <td colspan="6">No existen pagos registrados en este año.</td>
</tr>

@endforelse

</tbody>

</table>

<!-- RESUMEN -->
<table class="resumen">

<tr>
    <td><strong>Total de pagos registrados</strong></td>
    <td>{{ $pagos->count() }}</td>
</tr>

<tr>
    <td><strong>Total recaudado (Bs)</strong></td>
    <td>{{ number_format($totalPagado ?? 0, 2, '.', ',') }}</td>
</tr>

<tr>
    <td><strong>Total pendiente (Bs)</strong></td>
    <td>{{ number_format($totalPendiente ?? 0, 2, '.', ',') }}</td>
</tr>

</table>

</body>
</html>