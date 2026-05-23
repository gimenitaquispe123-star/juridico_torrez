<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #0b5ed7; color: white; text-align: center;">
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>CI</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $index => $c)
        <tr style="background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#ffffff' }};">
            <td style="text-align: center;">{{ $c->id }}</td>
            <td>{{ $c->nombres }}</td>
            <td>{{ $c->paterno }}</td>
            <td>{{ $c->materno }}</td>
            <td>{{ $c->ci ?? '-' }}</td>
            <td>{{ $c->celular ?? '-' }}</td>
            <td>{{ $c->email ?? '-' }}</td>
            <td style="text-align: center;">{{ $c->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($mes || $anio)
<p style="margin-top: 10px; font-style: italic;">
    Filtrado por:
    @if($mes) Mes: {{ $mes }} @endif
    @if($anio) Año: {{ $anio }} @endif
</p>
@endif

