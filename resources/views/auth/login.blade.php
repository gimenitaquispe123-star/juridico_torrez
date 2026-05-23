<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

 
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        .error-message { color: red; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="wrapper"> 
    <form method="POST" class="row g-3" action="{{ route('login') }}">
        @csrf
        <div class="login-wrapper"> 
            <div class="login-header text-center fs-2 mb-3">Iniciar </div>
            <div class="login-form"> 

            
                <div class="input-wrapper mb-3">      
                    <input type="email" class="input-field form-control" id="email" name="email" value="{{ old('email') }}" required>
                    <label for="email" class="label">Correo electrónico</label>
                    <i class="bx bx-user icon"></i>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-wrapper mb-3">    
                    <input type="password" class="input-field form-control" id="pw" name="password" required>
                    <label for="pw" class="label">Contraseña</label>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login-check mb-3">
                    <div class="forgot text-end">
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
              <div class="input-wrapper mb-3">
                    <input type="submit" class="input-login btn btn-primary w-100" value="Iniciar"/>
                </div>

                <div class="register mt-3 text-center">
                    <p>¿No tienes cuenta? <a href="">Regístrate</a></p>
                </div>

            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById('pw');
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
