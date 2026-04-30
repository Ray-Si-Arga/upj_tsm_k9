<?php
use Livewire\Component;
use App\Models\Jadwal;
?>

<div>
    <div id="kalender-container" wire:ignore></div>

        <?php
        $__scriptKey = '2450788034-0';
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
</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\storage\framework/views/livewire/views/267efc74.blade.php ENDPATH**/ ?>