<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Plugins CSS -->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <!-- Loader -->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icons & App CSS -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <title>Registro</title>

    <style>
        .invalid-feedback { color: red; font-size: 13px; margin-top: 3px; }
        .bth { width: 100%; padding: 10px; margin-top: 15px; background-color: #007bff; color: #fff; border: none; cursor: pointer; }
        .bth:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="form-box register">
        <h2>Registro</h2>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nombre -->
            <div class="input-box"> 
                <span class="icon"><i class="bx bx-user icon"></i></span>  
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required placeholder="Escribe...">
                <label>Nombre</label>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- C.I -->
            <div class="input-box">
                <span class="icon"><i class="bx bx-id-card icon"></i></span>  
                <input type="text" class="form-control @error('ci') is-invalid @enderror" 
                       id="ci" name="ci" value="{{ old('ci') }}" required 
                       placeholder="Escribe tu C.I." pattern="^\d{7,10}$" 
                       title="El C.I. debe ser de 7 a 10 dígitos numéricos">
                <label>C.I</label>
                @error('ci')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="input-box">
                <span class="icon"><i class="bx bx-mail icon"></i></span>                     
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" required placeholder="Introduce tu correo">
                <label>Email</label>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="input-box">
                <i class="toggle-password" onclick="togglePassword()">👁️</i>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" id="password" required placeholder="Ingresa contraseña">
                <label>Contraseña</label>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="input-box">
                <span class="icon"><i class="bx bx-lock-alt icon"></i></span>  
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                       name="password_confirmation" id="password_confirmation" required placeholder="Confirma contraseña">
                <label>Confirmar contraseña</label>
            </div>

            <!-- Botón Registrar -->
            <button type="submit" class="bth">Registrar</button>

            <!-- Link login -->
            <div class="login-register mt-2 text-center">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
            </div>
        </form>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        var passwordIcon = document.querySelector('.toggle-password');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.textContent = '🙈';
        } else {
            passwordField.type = 'password';
            passwordIcon.textContent = '👁️';
        }
    }
</script>

</body>
</html>
