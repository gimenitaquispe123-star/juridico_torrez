@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
   <h1 style="font-family: Georgia, serif;">Mi Perfil</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="perfilTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos-tab" data-bs-toggle="tab" href="#datos" role="tab"
                   aria-controls="datos" aria-selected="true">
                    <i class="fas fa-user"></i> Mis Datos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link "  id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                   aria-controls="password" aria-selected="false">
                    <i class="fas fa-key"></i> Cambiar Contraseña
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="perfilTabsContent">

            <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                @include('perfil.partials._datos_personales')
            </div>

     <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
    @include('perfil.partials._cambiar_password')
</div>


        </div>
    </div>
</div>
@stop

@section('css')
    {{-- CSS adicional si quieres --}}
@stop

@section('js')

<script>
document.addEventListener('DOMContentLoaded', function() {
    var triggerTabList = [].slice.call(document.querySelectorAll('#perfilTabs a'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
});
</script>

@stop
