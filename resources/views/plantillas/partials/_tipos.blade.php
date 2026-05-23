<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('tipo_plantilla.index') }}" class="btn text-danger btn-sm">
        <i class="fas fa-layer-group"></i> Ir a Tipo de Plantilla
    </a>
</div>

<div class="table-responsive">
    <table id="tablaTipos" class="table table-bordered table-striped table-hover text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tipo_Plantilla</th>
                <th>Descripción</th>
                <th>Registrado</th>
                <th>Estado</th>
            
            </tr>
        </thead>
        <tbody>
            @forelse($tipoPlantilla as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->tipo_plantilla }}</td>
                    <td>{{ $tipo->descripcion }}</td>
                    <td>{{ \Carbon\Carbon::parse($tipo->registrado)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($tipo->estado)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr><td colspan="6">No hay tipos de plantilla registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Crear Tipo --}}
<div class="modal fade" id="crearTipoModal" tabindex="-1" aria-labelledby="crearTipoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('tipo_plantilla.store') }}" method="POST" novalidate>
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="crearTipoModalLabel"><i class="fas fa-plus-circle"></i> Nuevo Tipo de Plantilla</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>

          <div class="modal-body">
              {{-- Mostrar errores de validación --}}
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <div class="mb-3">
                  <label for="tipo_plantilla" class="form-label">Tipo de Plantilla</label>
                  <input type="text" class="form-control @error('tipo_plantilla') is-invalid @enderror"
                         name="tipo_plantilla" id="tipo_plantilla"
                         value="{{ old('tipo_plantilla') }}"
                         placeholder="Ej. Sentencia, Resolución, Auto..." required>
                  @error('tipo_plantilla') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="mb-3">
                  <label for="descripcion" class="form-label">Descripción</label>
                  <textarea class="form-control @error('descripcion') is-invalid @enderror"
                            name="descripcion" id="descripcion" rows="3" placeholder="Breve descripción...">{{ old('descripcion') }}</textarea>
                  @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="mb-3">
                  <label for="estado" class="form-label">Estado</label>
                  <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                      <option value="1" {{ old('estado','1') == '1' ? 'selected' : '' }}>Activo</option>
                      <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                  </select>
                  @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times"></i> Cerrar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> registrar
            </button>
          </div>
        </div>
    </form>
  </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Buscador de tabla (simple)
    const searchInput = document.getElementById('tableSearchTipos');
    const table = document.getElementById('tablaTipos');
    if (searchInput && table) {
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.trim().toLowerCase();
            for (let row of table.tBodies[0].rows) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            }
        });
    }

    
    @if ($errors->any())
        
        (function openModalIfErrors() {
            const modalEl = document.getElementById('crearTipoModal');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const myModal = new bootstrap.Modal(modalEl);
                myModal.show();
            } else {
                
                setTimeout(function() {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        new bootstrap.Modal(modalEl).show();
                    }
                }, 500);
            }
        })();
    @endif
});
</script>
@endpush

