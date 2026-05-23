<form action="{{ route('perfil.update') }}" method="POST">
    @csrf
    @method('PUT')


    <div class="row mt-3">
        <div class="col-md-6">
            <label>Nueva Contraseña</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa nueva contraseña">
                
            </div>
        </div>

        <div class="col-md-6">
            <label>Confirmar Contraseña</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirma nueva contraseña">
                <span class="input-group-text" onclick="togglePassword('password_confirmation', this)" style="cursor:pointer;">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>
    </div>

    <small class="text-muted">Tu contraseña solo se actualizará si ingresas un valor.</small>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-info px-4">
            <i class="fas fa-save"></i> Actualizar
        </button>
    </div>
</form>

@push('js')
<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        const i = icon.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            i.classList.remove('fa-eye');
            i.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            i.classList.remove('fa-eye-slash');
            i.classList.add('fa-eye');
        }
    }
</script>
@endpush
