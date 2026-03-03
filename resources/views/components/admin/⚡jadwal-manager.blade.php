<?php

use Livewire\Component;
use App\Http\Controllers\BookingController;
use App\Models\Jadwal;
use Livewire\Attributes\On;

new class extends Component {
    public function with(): array
    {
        $jadwals = Jadwal::all()->map(function ($jadwal) {
            return [
                'id' => $jadwal->event_id,
                'date' => $jadwal->date,
                'title' => $jadwal->title,
                'description' => $jadwal->description,
                'color' => $jadwal->color,
                'startTime' => $jadwal->start_time ? date('H:i', strtotime($jadwal->start_time)) : null,
                'endTime' => $jadwal->end_time ? date('H:i', strtotime($jadwal->end_time)) : null,
                'isClosed' => (bool) $jadwal->is_closed,
            ];
        })->toArray();

        return [
            'jadwals' => $jadwals,
        ];
    }

    public function handleAddEvent($eventData)
    {
        app(BookingController::class)->storeJadwal($eventData);
    }

    public function handleUpdateEvent($eventData)
    {
        app(BookingController::class)->storeJadwal($eventData);
    }

    public function handleDeleteEvent($id)
    {
        app(BookingController::class)->deleteJadwal($id);
    }
};
?>

<div>
    <div id="kalender-container" wire:ignore></div>

    @script
    <script>
        // Inject data awal ke widget React
        window.BengkelCalendarInitialEvents = $wire.jadwals;

        // Render widget
        if (window.BengkelCalendar) {
            window.BengkelCalendar.render("kalender-container");
        }

        // Listener untuk event React widget
        window.addEventListener('bengkel-calendar-add', (e) => {
            console.log('Received bengkel-calendar-add with detail: ', e.detail);
            $wire.handleAddEvent(e.detail).then(() => {
                console.log('Successfully saved to DB!');
            }).catch(err => {
                console.error('Failed to save to DB (HandleAddEvent)', err);
            });
        });

        window.addEventListener('bengkel-calendar-update', (e) => {
            console.log('Received bengkel-calendar-update with detail: ', e.detail);
            $wire.handleUpdateEvent(e.detail);
        });

        window.addEventListener('bengkel-calendar-delete', (e) => {
            console.log('Received bengkel-calendar-delete with id: ', e.detail.id);
            $wire.handleDeleteEvent(e.detail.id);
        });
    </script>
    @endscript
</div>