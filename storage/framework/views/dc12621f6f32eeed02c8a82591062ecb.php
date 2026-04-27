

<?php $__env->startPush('styles'); ?>
    
        <script src="<?php echo e(asset('asset/bengkel-calendar/dist-widget/bengkel-calendar.js')); ?>"></script>
<?php $__env->stopPush(); ?>

    <?php $__env->startSection('content'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <style>
            .page-header {
                background: linear-gradient(135deg, var(--navy, #0f172a) 0%, #16213e 50%, #0f172a 100%);
                border-radius: 20px;
                padding: 30px 36px;
                color: white;
                margin-bottom: 26px;
                position: relative;
                overflow: hidden;
            }

            .page-header::before {
                content: '';
                position: absolute;
                top: -80px;
                right: -80px;
                width: 300px;
                height: 300px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 70%);
            }

            .page-header::after {
                content: '';
                position: absolute;
                bottom: -50px;
                left: 25%;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .03);
            }

            .header-title {
                font-size: 1.75rem;
                font-weight: 800;
                margin: 0 0 5px;
                letter-spacing: -.6px;
                position: relative;
                z-index: 1;
            }

            .header-sub {
                font-size: .85rem;
                color: rgba(255, 255, 255, .5);
                margin: 0;
                font-weight: 500;
                position: relative;
                z-index: 1;
            }

            .header-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(177, 0, 0, .25);
                border: 1px solid rgba(177, 0, 0, .35);
                color: #fca5a5;
                border-radius: 20px;
                padding: 4px 14px;
                font-size: .72rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1.2px;
                margin-bottom: 10px;
                position: relative;
                z-index: 1;
            }

            /* Container styling for widget */
            .widget-panel {
                background: #fff;
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                border: 1px solid #f1f5f9;
            }
        </style>

        <div class="container-fluid">
            
            <div class="page-header" style="animation: fadeUp .45s ease both;">
                <div class="header-eyebrow">
                    Admin Panel
                </div>
                <h1 class="header-title">Jadwal Bengkel</h1>
                <p class="header-sub">Atur dan pantau jadwal libur/operasional bengkel melalui kalender interaktif berikut.
                </p>
            </div>

            
            <div class="widget-panel" style="animation: fadeUp .45s ease both; animation-delay: .1s;">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.jadwal-manager');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-575389873-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
            </div>
        </div>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/admin/jadwal.blade.php ENDPATH**/ ?>