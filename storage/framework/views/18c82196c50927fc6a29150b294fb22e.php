<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-label-custom {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .form-control-custom {
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 12px;
        }

        .form-control-custom:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control-custom {
            border-color: #ffc107;
            /* Warna Warning untuk Edit */
        }

        .input-group:focus-within .input-group-text i {
            color: #ffc107;
        }

        .btn-modern {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card card-modern bg-white">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark"><?php echo e(__('Edit Barang')); ?></h3>
                            <p class="text-muted small">Perbarui data inventory bengkel.</p>
                        </div>

                        <form method="POST" action="<?php echo e(route('inventory.update', $inventory->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            
                            <div class="mb-4">
                                <label for="nama_barang" class="form-label-custom"><?php echo e(__('Nama Barang')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box text-muted"></i></span>
                                    <input id="nama_barang" type="text"
                                        class="form-control form-control-custom <?php $__errorArgs = ['nama_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="nama_barang" value="<?php echo e(old('nama_barang', $inventory->nama_barang)); ?>"
                                        required autocomplete="nama_barang" autofocus>
                                </div>
                                <?php $__errorArgs = ['nama_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger mt-1 d-block">
                                        <strong><?php echo e($message); ?></strong>
                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-4">
                                <label for="jumlah_barang" class="form-label-custom"><?php echo e(__('Stok Saat Ini')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group text-muted"></i></span>
                                    <input id="jumlah_barang" type="number"
                                        class="form-control form-control-custom <?php $__errorArgs = ['jumlah_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="jumlah_barang" value="<?php echo e(old('jumlah_barang', $inventory->jumlah_barang)); ?>"
                                        required autocomplete="jumlah_barang" min="0">
                                </div>
                                <?php $__errorArgs = ['jumlah_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger mt-1 d-block">
                                        <strong><?php echo e($message); ?></strong>
                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-4">
                                <label for="harga_beli_view" class="form-label-custom"><?php echo e(__('Harga Beli')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold text-muted">Rp</span>
                                    <input id="harga_beli_view" type="text" class="form-control form-control-custom" 
                                        value="<?php echo e(number_format($inventory->harga_beli, 0, ',', '.')); ?>" required>
                                    <input type="hidden" id="harga_beli" name="harga_beli" value="<?php echo e($inventory->harga_beli); ?>">
                                </div>
                            </div>

                            
                            <div class="mb-4">
                                <label for="harga_jual_view" class="form-label-custom"><?php echo e(__('Harga Jual')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold text-muted">Rp</span>
                                    <input id="harga_jual_view" type="text" class="form-control form-control-custom" 
                                        value="<?php echo e(number_format($inventory->harga_jual, 0, ',', '.')); ?>" required>
                                    <input type="hidden" id="harga_jual" name="harga_jual" value="<?php echo e($inventory->harga_jual); ?>">
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-warning btn-modern shadow-sm text-white">
                                    <i class="fas fa-save me-2"></i> <?php echo e(__('Simpan Perubahan')); ?>

                                </button>
                                <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-light btn-modern text-muted">
                                    <?php echo e(__('Batal')); ?>

                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupMask(viewId, hiddenId) {
            const viewInput = document.getElementById(viewId);
            const realInput = document.getElementById(hiddenId);

            if (!viewInput || !realInput) return;

            viewInput.addEventListener('input', function() {
                let angka = this.value.replace(/[^0-9]/g, '');
                realInput.value = angka;
                this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        }

        setupMask('harga_beli_view', 'harga_beli');
        setupMask('harga_jual_view', 'harga_jual');
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/inventory/edit.blade.php ENDPATH**/ ?>