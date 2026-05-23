<style>
html, body {
    margin: 0; padding: 0; 
    font-family: Arial, Helvetica, Sans-serif;
    font-size:14px;
}
#calendar { max-width: 100%; height: 80vh; margin: 20px auto; }
.modal-content { border-radius: 2rem !important; }
.modal-header, .modal-footer { border: none; }
.input-linea {
    border: none;
    border-bottom: 3px solid #007bff;
    background-color: transparent;
    width: 100%;
    padding: 10px 0;
    text-align: center;
    font-size: 1.4rem;
    font-weight: bold;
    color: #000;
    border-radius: 0;
}
.modal {
    overflow: visible !important;
}

.modal-dialog {
    overflow: visible !important;
}

.modal-content {
    overflow: visible !important;
}
.input-linea::placeholder { color: #007bff; font-size: 1.5rem; opacity:1; text-align:center; }
.input-linea:focus { outline: none; border-bottom: 3px solid rgb(80, 162, 250); background-color: transparent; }
.form-control, .form-select { border-radius: 1.25rem; }
</style>

<div id="calendar"></div>

<div class="modal fade" id="modalCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;">
        <form id="formCita" method="POST" action="{{ route('citas.store') }}">
            @csrf
            <input type="hidden" name="cita_id" id="cita_id">
            <div class="modal-content rounded-5 shadow">

                <div class="modal-header text-danger py-2 rounded-top-5 d-flex justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">X</button>
                </div>
                <div class="modal-body py-3">
                    <div class="container-fluid">

                        <div class="row g-3 mb-3">
                            <div class="col-12 text-center">
                                <input type="text" name="titulo" id="titulo" class="input-linea" placeholder="Título de la cita" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label>Cliente</label>
                                <select name="id_cliente" id="id_cliente" class="form-select rounded-4" required>
                                    <option value="">Seleccione cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">
                                            {{ $cliente->nombres }} {{ $cliente->paterno }} {{ $cliente->materno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

    <div class="col-md-6">
    <label for="id_empleado">Empleado</label>
   
        <select name="id_empleado" id="id_empleado" 
    class="form-select rounded-4 w-100" required>
        <option value="">Seleccione empleado</option>

        @forelse($empleados as $empleado)
            <option value="{{ $empleado->id }}">
                {{ $empleado->nombres }} {{ $empleado->paterno }} {{ $empleado->materno }}
            </option>
        @empty
            <option value="" disabled>No hay empleados registrados</option>
        @endforelse

    </select>
</div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label>Asunto</label>
                                <input type="text" name="asunto" id="asunto" class="form-control rounded-4" placeholder="Tema principal" required>
                            </div>
                            <div class="col-md-6">
                                <label>Nota</label>
                                <input type="text" name="nota" id="nota" class="form-control rounded-4" placeholder="Opcional">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label>Fecha y Hora</label>
                                <input type="datetime-local" name="fecha_hora_cita" id="fecha_hora_cita" class="form-control rounded-4" required>
                            </div>
                            <div class="col-md-4">
                                <label>Lugar</label>
                                <input type="text" name="lugar_cita" id="lugar_cita" class="form-control rounded-4" required>
                            </div>
                            <div class="col-md-4">
                                <label>Estado</label>
                                <select name="estado_cita" id="estado_cita" class="form-select rounded-4" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label>Mensaje</label>
                                <textarea name="mensaje" id="mensaje" rows="2" class="form-control rounded-4" placeholder="Detalles adicionales..."></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer rounded-bottom-5 d-flex justify-content-center align-items-center">
                    <button type="submit" id="btnGuardar" class="btn btn-info px-4 me-2">Registrar</button>
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </form>
    </div>
</div>


@section('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const modalEl = document.getElementById('modalCita');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('formCita');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        editable: true,
        headerToolbar: {
            left: 'prev,next today crearBtn',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        customButtons: {
            crearBtn: {
                text: 'Crear',
                click: function() {
                    form.reset();
                    document.getElementById('cita_id').value = '';
                    modal.show();
                }
            }
        },
        events: @json($events),
        dateClick: function(info) {
            form.reset();
            document.getElementById('cita_id').value = '';
            document.getElementById('fecha_hora_cita').value = info.dateStr+"T08:00";
            modal.show();
        },
        eventClick: function(info) {
            const e = info.event.extendedProps;
            document.getElementById('cita_id').value = info.event.id;
            document.getElementById('titulo').value = info.event.title;
            document.getElementById('id_cliente').value = e.id_cliente;
            document.getElementById('id_empleado').value = e.id_empleado;
            document.getElementById('fecha_hora_cita').value = info.event.startStr.slice(0,16);
            document.getElementById('lugar_cita').value = e.lugar_cita;
            document.getElementById('estado_cita').value = e.estado_cita;
            document.getElementById('asunto').value = e.asunto;
            document.getElementById('nota').value = e.nota;
            document.getElementById('mensaje').value = e.mensaje || '';
            modal.show();
        }
    });

    calendar.render();

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif

    
    const hoy = new Date().toISOString().slice(0, 10);
    const eventosHoy = @json($events).filter(e => e.start.slice(0,10) === hoy);
    if(eventosHoy.length > 0){
        let lista = eventosHoy.map(e => `<li><b>${e.title}</b> — ${new Date(e.start).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</li>`).join('');
        Swal.fire({
            icon:'info',
            title:'📅 Eventos para hoy',
            html:`<ul style="text-align:left;list-style:none;padding:0;">${lista}</ul>`,
            confirmButtonText:'Aceptar',
            confirmButtonColor:'#007bff'
        });
    }
});
</script>
@endsection
