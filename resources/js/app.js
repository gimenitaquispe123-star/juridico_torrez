import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import esLocale from '@fullcalendar/core/locales/es'; // Importar idioma español

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            locale: esLocale, // Aplicar idioma español
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',  // Botones para navegar entre meses
                center: 'title',          // Título del mes
                right: 'dayGridDay,dayGridWeek,dayGridMonth' // Cambiar vista
            },
            events: '/agendas/eventos', // Ruta para cargar eventos desde Laravel
        });

        calendar.render();
    }
});
