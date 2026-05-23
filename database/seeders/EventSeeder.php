<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event; // Importar el modelo

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'event' => 'cita #1',
                'start_date' => '2025-09-11 08:00',
                'end_date'   => '2025-09-11 08:00',
                'color' => '#1abc9c', // Verde
            ],
            [
                'event' => 'cita #2',
                'start_date' => '2025-09-12 09:00',
                'end_date'   => '2025-09-12 09:30',
                'color' => '#3498db', // Azul
            ],
            [
                'event' => 'cita #3',
                'start_date' => '2025-09-13 10:00',
                'end_date'   => '2025-09-13 10:30',
                'color' => '#e74c3c', // Rojo
            ],
            [
                'event' => 'cita #4',
                'start_date' => '2025-09-14 11:00',
                'end_date'   => '2025-09-14 11:30',
                'color' => '#f39c12', // Naranja
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
