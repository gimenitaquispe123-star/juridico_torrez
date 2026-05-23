<div class="container mt-3">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="text-black" style="font-family: 'Georgia', serif;">Mis Datos Personales</h2>
            <i class="fas fa-user fa-5x text-black mt-2"></i>
        </div>
    </div>

    <div class="row">
        <!-- Nombres -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->persona->nombres ?? '-' }}" disabled>
            </div>
        </div>

        <!-- Apellido Paterno -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->persona->paterno ?? '-' }}" disabled>
            </div>
        </div>

        <!-- Apellido Materno -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->persona->materno ?? '-' }}" disabled>
            </div>
        </div>

        <!-- CI -->
        <div class="col-md-4">
            <div class="form-group">
                <label>CI</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->persona->ci ?? '-' }}" disabled>
            </div>
        </div>

        <!-- Usuario -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->usuario }}" disabled>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->email }}" disabled>
            </div>
        </div>

        <!-- Estado -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Estado</label>
                <input type="text" class="form-control bg-light" value="{{ ucfirst(auth()->user()->estado) }}" disabled>
            </div>
        </div>

        <!-- Rol -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Rol</label>
                <input type="text" class="form-control bg-light" value="{{ auth()->user()->roles->pluck('name')->join(', ') }}" disabled>
            </div>
        </div>
    </div>
</div>

<style>
    .form-group label {
        font-weight: 600;
        font-size: 14px;
        color: #555;
    }
    input[disabled], .bg-light {
        background-color: #f8f9fa !important;
        color: #666 !important;
    }
    input, select {
        font-size: 14px;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    input:focus, select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 5px rgba(23,162,184,0.5);
    }
</style>
