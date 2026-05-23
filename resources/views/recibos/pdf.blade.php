<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .recibo{
    width: 600px;
    margin: 20px auto;   /* mejor separación arriba y abajo */
    border: 2px solid #002b80;
    padding: 20px;
    background: #fff;     /* fondo limpio tipo documento */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* leve sombra profesional */
    font-family: Arial, sans-serif;
}

        .header{
            text-align: center;
            margin-bottom: 10px;
        }

        .titulo{
            font-size: 22px;
            font-weight: bold;
            color: #002b80;
        }

        .numero{
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }

        .subtitulo{
            text-align: center;
            font-family: Georgia, serif;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .fila{
            margin-bottom: 10px;
        }

        .label{
            font-weight: bold;
        }

        .campo{
            border-bottom: 1px solid #000;
            padding: 4px 0;
            min-height: 18px;
        }

        .tabla{
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .tabla td{
            border: 1px solid #000;
            padding: 6px;
        }

        .monto{
            text-align: center;
            font-weight: bold;
            background: #f2f2f2;
        }

        .info{
            margin-top: 15px;
            font-size: 12px;
        }

        /* FIRMA PERFECTA EN UNA FILA */
        .firmas{
            margin-top: 60px;
            width: 100%;
            display: table;
        }

        .firma{
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }

        .linea{
            width: 200px;
            border-top: 1px solid #000;
            margin: auto;
            margin-bottom: 5px;
        }

        .texto{
            font-size: 12px;
        }

    </style>
</head>

<body>

<div class="recibo">

    <div class="header">
    <div class="titulo">
        RECIBO
    </div>

    <div class="numero">
        N° {{ str_pad($pago->id_pago, 5, '0', STR_PAD_LEFT) }}
    </div>
</div>

    <div class="subtitulo">
        ESTUDIO JURÍDICO TORREZ
    </div>

    {{-- FECHA --}}
    <div class="fila">
        <strong>Fecha y Hora:</strong>
        {{ \Carbon\Carbon::parse($pago->created_at)->format('d/m/Y H:i') }}
    </div>

    {{-- CLIENTE --}}
    <div class="fila">
        <strong>Cliente:</strong>
        <div class="campo">
            {{ $pago->cliente->nombre_completo }}
        </div>
    </div>

    {{-- MONTO --}}
    <div class="fila">
        <strong>La suma de:</strong>
        <div class="campo">
            Bs. {{ number_format($pago->monto_pagado, 2) }}
        </div>
    </div>

    {{-- TABLA --}}
    <table class="tabla">

        <tr>
            <td><strong>Bolivianos (Bs.)</strong></td>
            <td class="monto">{{ number_format($pago->monto_pagado, 2) }}</td>
        </tr>

        <tr>
            <td><strong>Dólares ($us.)</strong></td>
            <td class="monto">---</td>
        </tr>

    </table>

    {{-- CONCEPTO --}}
    <div class="fila" style="margin-top:10px;">
        <strong>Por concepto de:</strong>
        <div class="campo">
            {{ $pago->glosa_pago ?? 'Pago realizado' }}
        </div>
    </div>

    {{-- INFO EXTRA --}}
    <div class="info">
        <div><strong>Estado:</strong> {{ $pago->estado }}</div>
        <div><strong>Cliente:</strong> {{ $pago->cliente->nombre_completo }}</div>
        <div><strong>Registrado por:</strong> {{ $pago->usuarioRegistro->name ?? 'Adm' }}</div>
    </div>

    {{-- FIRMAS BIEN ALINEADAS --}}
    <div class="firmas">


        <div class="firma">
            <div class="linea"></div>
            <div class="texto">Firma y sello</div>
        </div>
        <div class="firma">
            <div class="linea"></div>
            <div class="texto">{{ $pago->cliente->nombre_completo ?? 'CLIENTE' }}
                <br>
                Firma del Cliente</div>
        </div>

    </div>

</div>

</body>
</html>