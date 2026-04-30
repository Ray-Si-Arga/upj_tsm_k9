<?php
    $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
    $startTime = $bookingTime;
    $duration = $booking->estimation_duration ?? 60;
    $endTime = $bookingTime->copy()->addMinutes($duration);
    $isOver = now()->greaterThan($endTime) && $booking->status == 'on_progress';
?>

<tr>
    
    <td class="text-center px-4">
        <div class="d-flex justify-content-center">
            <div class="text-dark fw-bold"><?php echo e($booking->queue_number); ?></div>
        </div>
    </td>

    
    <td class="px-4">
        <div class="fw-bold text-dark"><?php echo e($booking->customer_name); ?></div>
        <div class="text-dark small"><?php echo e($booking->vehicle_type); ?> - <span
                class="fw-bold"><?php echo e(strtoupper($booking->plate_number)); ?></span></div>
        <small class="text-muted"><i class="fab fa-whatsapp text-success me-1"></i>
            <?php echo e($booking->customer_whatsapp); ?></small>

        <div class="mt-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->services->count() > 0): ?>
                
                <span class="badge bg-dark bg-gradient mb-1">
                    <?php echo e($booking->services->first()->name); ?>

                </span>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->services->count() > 1): ?>
                    <span class="badge bg-dark bg-gradient mb-1" title="Lihat detail untuk info lengkap">
                        +<?php echo e($booking->services->count() - 1); ?> lainnya
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
                <span class="text-muted small">-</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
    </td>
    </td>

    
    <td class="px-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isToday): ?>
            
            <span class="badge-time fs-6">
                <i class="far fa-clock me-1"></i> <?php echo e($startTime->format('H:i')); ?> - <?php echo e($endTime->format('H:i')); ?>

            </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOver): ?>
                <div class="text-danger fw-bold small mt-1"><i class="fas fa-exclamation-triangle"></i> Lewat Estimasi!
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
            
            <div class="fw-bold text-dark"><?php echo e($bookingTime->format('d M Y')); ?></div>
            <div class="text-muted small">Pukul <?php echo e($startTime->format('H:i')); ?> WIB</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </td>

    
    <td class="px-4 text-center">
        <form action="<?php echo e(route('booking.updateStatus', $booking->id)); ?>" method="POST"
            id="form-status-<?php echo e($booking->id); ?>">
            <?php echo csrf_field(); ?>
            <?php
                $statusColor = match ($booking->status) {
                    'pending' => 'border-warning text-warning',
                    'approved' => 'border-primary text-primary',
                    'on_progress' => 'border-info text-info',
                    'done' => 'border-success text-success',
                    'cancelled' => 'border-danger text-danger',
                    default => 'border-secondary text-secondary',
                };
            ?>

            
            <select name="status" class="form-select form-select-sm status-select <?php echo e($statusColor); ?>"
                onchange="handleStatusChange(this, '<?php echo e($booking->id); ?>', '<?php echo e(route('booking.updateStatus', $booking->id)); ?>')"
                style="min-width: 140px;">

                <option value="pending" <?php echo e($booking->status == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                <option value="approved" <?php echo e($booking->status == 'approved' ? 'selected' : ''); ?>>Diterima</option>
                <option value="on_progress" <?php echo e($booking->status == 'on_progress' ? 'selected' : ''); ?>>Dikerjakan
                </option>
                <option value="done" <?php echo e($booking->status == 'done' ? 'selected' : ''); ?>>Selesai</option>
                <option value="cancelled" <?php echo e($booking->status == 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
            </select>
        </form>
    </td>

    
    <td class="px-4 text-center">
        <div class="d-flex justify-content-center gap-2">
            
            <button type="button" 
                    class="btn-act btn-detail" 
                    onclick='showDetail(<?php echo json_encode($booking->services, 15, 512) ?>)' 
                    title="Lihat Detail">
                <i class="fas fa-search"></i>
            </button>

            <form action="<?php echo e(route('booking.destroy', $booking->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-act btn-hapus" onclick="return confirm('Hapus data booking ini?')"
                    title="Hapus"><i class="fas fa-trash-alt"></i></button>
            </form>
        </div>
    </td>
</tr><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/booking/partials/row_content.blade.php ENDPATH**/ ?>