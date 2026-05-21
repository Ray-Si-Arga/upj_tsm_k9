
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .card-history {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-header {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .vehicle-badge {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }
    </style>

    <main class="py-4">
        <div class="container">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Riwayat Service</h2>
                    <p class="text-muted mb-0">
                        Pelanggan: <span class="fw-bold text-primary"><?php echo e($customerName ?? 'Nama Tidak Ditemukan'); ?></span>
                    </p>
                </div>
                <a href="<?php echo e(route('customers.index')); ?>"
                    class="btn btn-light border text-secondary shadow-sm rounded-pill px-4 hover-shadow">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card card-history">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 px-4">Tanggal Booking</th>
                                    <th class="py-3 px-4">Kendaraan</th>
                                    <th class="py-3 px-4">Layanan</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr>
                                        
                                        <td class="px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light p-2 rounded me-3 text-secondary">
                                                    <i class="far fa-calendar-alt"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">
                                                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y')); ?>

                                                    </div>
                                                    <small class="text-muted">
                                                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('H:i')); ?>

                                                        WIB
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        
                                        <td class="px-4">
                                            <div class="fw-semibold text-dark"><?php echo e($booking->vehicle_type); ?></div>
                                            <span class="vehicle-badge mt-1 d-inline-block">
                                                <?php echo e(strtoupper($booking->plate_number)); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-4">
                                            <span class="fw-medium text-secondary"><?php echo e($booking->service->name); ?></span>
                                        </td>

                                        
                                        <td class="px-4 text-center">
                                            <?php
                                                $statusClass = match ($booking->status) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'approved' => 'bg-primary text-white',
                                                    'on_progress' => 'bg-info text-white',
                                                    'done' => 'bg-success text-white',
                                                    'cancelled' => 'bg-danger text-white',
                                                    default => 'bg-secondary text-white',
                                                };

                                                $statusLabel = match ($booking->status) {
                                                    'pending' => 'Menunggu',
                                                    'approved' => 'Diterima',
                                                    'on_progress' => 'Dikerjakan',
                                                    'done' => 'Selesai',
                                                    'cancelled' => 'Batal',
                                                    default => ucfirst($booking->status),
                                                };
                                            ?>
                                            <span class="badge <?php echo e($statusClass); ?> rounded-pill px-3 py-2 fw-normal">
                                                <?php echo e($statusLabel); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-4 text-center">
                                            <a href="<?php echo e(route('booking.history.detail', [$booking->customer_whatsapp, $booking->id])); ?>"
                                                class="btn btn-outline-primary btn-icon" title="Lihat Detail Transaksi">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-history fa-3x mb-3 text-secondary opacity-25"></i>
                                                <p class="mb-0 fs-5">Belum Ada Riwayat</p>
                                                <p class="small">Customer ini belum pernah melakukan service.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\booking\history.blade.php ENDPATH**/ ?>