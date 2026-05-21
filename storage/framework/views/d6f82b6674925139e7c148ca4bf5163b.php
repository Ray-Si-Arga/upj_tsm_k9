<?php

use Livewire\Component;
use App\Models\Jadwal;

new class extends Component {
    public function with(): array
    {
        $jadwals = Jadwal::all()->map(function ($jadwal) {
            return [
                'id' => $jadwal->date,
                'date' => $jadwal->date,
                'title' => $jadwal->title,
                'description' => $jadwal->description,
                'isClosed' => (bool) $jadwal->is_closed,
                'isOperational' => (bool) $jadwal->is_operational,
            ];
        })->toArray();

        return [
            'jadwals' => $jadwals,
        ];
    }

    public function handleAddEvent($eventData)
    {
        Jadwal::updateOrCreate(
            ['date' => $eventData['date']],
            [
                'title' => $eventData['title'],
                'description' => $eventData['description'] ?? null,
                'is_closed' => $eventData['isClosed'] ?? false,
                'is_operational' => $eventData['isOperational'] ?? false,
            ]
        );
    }

    public function handleUpdateEvent($eventData)
    {
        Jadwal::updateOrCreate(
            ['date' => $eventData['date']],
            [
                'title' => $eventData['title'],
                'description' => $eventData['description'] ?? null,
                'is_closed' => $eventData['isClosed'] ?? false,
                'is_operational' => $eventData['isOperational'] ?? false,
            ]
        );
    }

    public function handleDeleteEvent($id)
    {
        Jadwal::where('date', $id)->delete();
    }
};
?>

<div>
    <div id="kalender-container" wire:ignore></div>

        <?php
        $__scriptKey = '2808893748-2';
        ob_start();
    ?>
    <script>
        // Inject data awal ke widget React
        window.BengkelCalendarInitialEvents = <?php echo \Illuminate\Support\Js::from($jadwals)->toHtml() ?>;

        // Render widget
        if (window.BengkelCalendar) {
            window.BengkelCalendar.render("kalender-container");
        } else {
            window.addEventListener('bengkel-calendar-ready', function () {
                window.BengkelCalendar.render("kalender-container");
            }, { once: true });
        }

        // Listener untuk event React widget
        window.addEventListener('bengkel-calendar-add', (e) => {
            $wire.handleAddEvent(e.detail);
        });

        window.addEventListener('bengkel-calendar-update', (e) => {
            $wire.handleUpdateEvent(e.detail);
        });

        window.addEventListener('bengkel-calendar-delete', (e) => {
            $wire.handleDeleteEvent(e.detail.id);
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\components\admin\⚡jadwal-manager.blade.php ENDPATH**/ ?>