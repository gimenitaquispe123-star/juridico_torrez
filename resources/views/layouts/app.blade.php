
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

   <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>


<script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];

    OneSignalDeferred.push(async function(OneSignal) {

        await OneSignal.init({
            appId: "cd696aca-16e2-4b47-89a2-59fcc37ea0e8",
            notifyButton: {
                enable: true,
            },
        });

    });
</script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light font-sans">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menú dinámico por rol -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        {{-- ADMINISTRADOR --}}
                        @if(auth()->user()->tieneRol('admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="/administracion">
                                    <i class="fa fa-cog"></i> Administración del sistema
                                </a>
                            </li>
                        @endif

                        {{-- SECRETARIA --}}
                        @if(auth()->user()->tieneRol('secretaria'))
                            <li class="nav-item">
                                <a class="nav-link" href="/personas">
                                    <i class="fa fa-users"></i> Gestión de personas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/seguimiento">
                                    <i class="fa fa-chart-line"></i> Seguimiento económico
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/agenda">
                                    <i class="fa fa-calendar"></i> Agenda
                                </a>
                            </li>
                        @endif

                        {{-- ABOGADO --}}
                        @if(auth()->user()->tieneRol('abogado'))
                            <li class="nav-item">
                                <a class="nav-link" href="/expedientes">
                                    <i class="fa fa-folder"></i> Expedientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/procesos">
                                    <i class="fa fa-gavel"></i> Gestión procesal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/documentos">
                                    <i class="fa fa-file"></i> Documentos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/agenda">
                                    <i class="fa fa-calendar"></i> Agenda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/plantillas">
                                    <i class="fa fa-copy"></i> Plantillas
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Login / Logout -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa fa-user"></i> {{ auth()->user()->nombre ?? auth()->user()->usuario }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i> Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
