<form 
    action="{{ isset($expedienteDigitalizado) ? route('expedientes_digitalizados.update', $expedienteDigitalizado->id) : route('expedientes_digitalizados.storeMultiple') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($expedienteDigitalizado))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_cliente"><i class="fas fa-user"></i> Cliente</label>
                <select name="id_cliente" id="id_cliente" class="form-control select2 @error('id_cliente') is-invalid @enderror" required>
                <option value="">Seleccione...</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"
                        {{ (isset($expedienteDigitalizado) && $expedienteDigitalizado->id_cliente == $cliente->id) ? 'selected' : '' }}>
                        {{ $cliente->nombres ?? $cliente->nombre_completo }}
                    </option>
                @endforeach
            </select>

                @error('id_cliente')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="id_expediente"><i class="fas fa-folder-open"></i> Nro Expediente</label>
                <select name="id_expediente" id="id_expediente" class="form-control select2 @error('id_expediente') is-invalid @enderror" required>
                    <option value="">Seleccione expediente...</option>
                    @foreach($expedientes as $exp)
                        <option value="{{ $exp->id }}"
                            {{ (isset($expedienteDigitalizado) && $expedienteDigitalizado->id_expediente == $exp->id) ? 'selected' : '' }}>
                            {{ $exp->nro_expediente }} — {{ $exp->demandante }}
                        </option>
                    @endforeach
                </select>
                @error('id_expediente')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nro_expediente"><i class="fas fa-hashtag"></i> Código de Expediente</label>
                <input type="text" 
                       name="nro_expediente" 
                       id="nro_expediente"
                       class="form-control @error('nro_expediente') is-invalid @enderror" 
                       value="{{ old('nro_expediente', $expedienteDigitalizado->nro_expediente ?? '') }}" 
                       readonly>
                @error('nro_expediente')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
    <label for="tipo_expediente">
        <i class="fas fa-folder"></i> Tipo de Expediente
    </label>

    <input type="text"
           name="tipo_expediente"
           class="form-control @error('tipo_expediente') is-invalid @enderror"
           value="{{ old('tipo_expediente', $expedienteDigitalizado->tipo_expediente ?? '') }}"
           placeholder="Ej: Penal, Civil, Laboral..."
           required>

    @error('tipo_expediente')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
        </div>

        <div class="col-md-6">
            <div class="col-md-12">
    <div class="form-group">
        <label for="texto_expediente"><i class="fas fa-file-alt"></i> Descripción / Texto</label>
        <textarea 
            name="texto_expediente" 
            id="texto_expediente" 
            rows="6" 
            class="form-control @error('texto_expediente') is-invalid @enderror" 
            placeholder="Escribe aquí la descripción o notas del expediente..."
        >{{ old('texto_expediente', $expedienteDigitalizado->texto_expediente ?? '') }}</textarea>

        @error('texto_expediente')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


           <div class="form-group">
                <label for="imagenes"><i class="fas fa-images"></i> Subir Varias Imágenes para digitalizar</label>
                <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                <small class="text-muted d-block">Seleccione varias imágenes si desea generar un PDF buscable.</small>
            </div>
            <div class="form-group mt-4 text-center">
                <a href="{{ route('expedientes_digitalizados.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> {{ isset($expedienteDigitalizado) ? 'Actualizar' : 'Registrar / Digitalizar' }}
                </button>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#id_expediente').on('change', function() {
        let expedienteID = $(this).val();

        if (expedienteID) {
            $.ajax({
                url: '{{ route("expedientes.get-codigo", ["id" => "EXP_ID"]) }}'.replace('EXP_ID', expedienteID),
                type: 'GET',
                success: function(data) {
                    console.log(data); 
                    $('#nro_expediente').val(data.codigo_expediente);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        } else {
            $('#nro_expediente').val('');
        }
    });

$(document).ready(function() {
    $('#id_cliente').select2({
        placeholder: "Buscar cliente...",
        allowClear: true
    });
});
</script>
