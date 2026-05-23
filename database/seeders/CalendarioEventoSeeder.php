<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalendarioEvento;

class CalendarioEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'event' => 'Cita #1',
                'start_date' => '2025-09-18 09:00:00',
                'end_date'   => '2025-09-18 10:00:00',
                'color'      => '#ff0000',
            ],
            [
                'event' => 'Cita #2',
                'start_date' => '2025-09-19 14:00:00',
                'end_date'   => '2025-09-19 15:00:00',
                'color'      => '#00ff00',
            ],
            [
                'event' => 'Cita #3',
                'start_date' => '2025-09-20 11:30:00',
                'end_date'   => '2025-09-20 12:00:00',
                'color'      => '#0000ff',
            ],
        ];

        foreach ($events as $event) {
            CalendarioEvento::create($event);
        }
    }
}
