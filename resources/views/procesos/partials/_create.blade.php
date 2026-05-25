@can('crear proceso')
    <div class="card-header text-black mb-3">
        <h5 class="mb-0"><i class="fas fa-folder-plus text-success"></i> NUEVO PROCESO</h5>
    </div>
@endcan

<form action="{{ route('procesos.store') }}" method="POST">
    @csrf

    <div class="row">
       
        <div class="col-md-4">
    <div class="form-group">
        <label for="id_cliente" class="form-label">Cliente</label>
        <select name="id_cliente" id="id_cliente" class="form-control select2" required>
            <option value="">Seleccione...</option>

            @isset($clientes)
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}"
                        {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>
                        
                        {{ trim(($cliente->nombres ?? '') . ' ' . ($cliente->paterno ?? '') . ' ' . ($cliente->materno ?? '')) }}
                    
                    </option>
                @endforeach
            @endisset

        </select>
    </div>
</div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="id_posicion" class="form-label">Posición del Cliente</label>
                <select name="id_posicion" id="id_posicion" class="form-control select2" required>
                    <option value="">Seleccione...</option>
                    @isset($posiciones)
                        @foreach ($posiciones as $posicion)
                            <option value="{{ $posicion->id }}">{{ $posicion->nombre }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

        {{-- PERSONA CONTRARIA SOLO LETRAS --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="contrario" class="form-label">Persona Contraria</label>
                <input type="text" 
                       name="contrario" 
                       id="contrario" 
                       class="form-control"
                       value="{{ old('contrario') }}"
                       placeholder="Nombre de la persona contraria"
                       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                       oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
            </div>
        </div>
    </div>

    <div class="row mt-2">

        <div class="col-md-4">
            <div class="form-group">
                <label for="estado_proceso" class="form-label">Estado del Proceso</label>
                <select name="estado_proceso" id="estado_proceso" class="form-control select2">
                    <option value="">Seleccione estado...</option>
                    @isset($estados)
                        @foreach ($estados as $e)
                            <option value="{{ $e->id }}" {{ old('estado_proceso') == $e->id ? 'selected' : '' }}>
                                {{ $e->estado_proceso }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

      
        <div class="col-md-4">
            <div class="form-group">
                <label for="proceso" class="form-label">Nombre del Proceso</label>
                <input type="text" 
                       name="proceso" 
                       id="proceso" 
                       class="form-control"
                       value="{{ old('proceso') }}"
                       placeholder="Ejemplo: Demanda Civil"
                       required
                       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                       oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="tipo_proceso" class="form-label">Tipo de Proceso</label>
                <select name="tipo_proceso" id="tipo_proceso" class="form-control select2" required>
                    <option value="">Seleccione tipo...</option>
                    @isset($tipos)
                        @foreach ($tipos as $t)
                            <option value="{{ $t->id }}" {{ old('tipo_proceso') == $t->id ? 'selected' : '' }}>
                                {{ $t->tipo_proceso }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div class="row mt-3">

     <div class="col-md-4">
    <div class="form-group">
        <label for="id_expediente">Expediente Asociado</label>

      <select name="id_expediente"
        id="id_expediente"
        class="form-control @error('id_expediente') is-invalid @enderror"
        required>

    <option value="">Seleccione expediente...</option>

    @foreach($expedientes as $exp)
        <option value="{{ $exp->id }}"
            {{ old('id_expediente') == $exp->id ? 'selected' : '' }}>

            {{ $exp->nro_expediente }} -
            {{ $exp->cliente->nombre_completo ?? 'Sin cliente' }}

        </option>
    @endforeach

</select>

        @error('id_expediente')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="involucrados" class="form-label">Personas Involucradas</label>
                <textarea name="involucrados" 
                          id="involucrados" 
                          class="form-control" 
                          rows="2"
                          placeholder="Ejemplo: testigos, peritos..."
                          pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s,]+"
                          oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s,]/g, '')">{{ old('involucrados') }}</textarea>
            </div>
        </div>

        {{-- DESCRIPCIÓN SOLO LETRAS --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción del Proceso</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          class="form-control" 
                          rows="2"
                          placeholder="Descripción breve del proceso"
                          pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s,\.]+"
                          oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s,\.]/g, '')">{{ old('descripcion') }}</textarea>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Registrar
        </button>
        <a href="{{ route('procesos.index') }}" class="btn btn-danger">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </div>
</form>

@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });

$(document).ready(function() {
    $('#id_expediente').select2({
        placeholder: "Buscar por número o nombre del cliente...",
        allowClear: true
    });
});
</script>
@stop