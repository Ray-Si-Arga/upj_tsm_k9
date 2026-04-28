
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }

        .form-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            background: white;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .form-header-title {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 15px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .section-label {
            color: #2c3e50;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
        }

        .form-label-custom {
            font-weight: 600;
            color: #5a6268;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 3px rgba(44,62,80,0.1);
        }

        .input-readonly {
            background-color: #eef2f7 !important;
            color: #495057;
            border: 1px solid #dae0e5;
            font-weight: 600;
        }

        .booking-selector-area {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 25px;
            border-left: 5px solid #ffc107;
        }

        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(13,110,253,0.2);
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }

        .table-responsive { overflow: visible !important; }
        .ts-dropdown { z-index: 9999; }
        .ts-control { border-radius: 8px; padding: 8px 12px; }

        @media (max-width: 768px) {
            .form-header-title { font-size: 1rem; padding: 12px 15px; }
            .form-card { margin-bottom: 15px; }
            .border-end-md {
                border-right: none !important;
                border-bottom: 1px dashed #dee2e6;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }

        @media (min-width: 769px) {
            .border-end-md { border-right: 1px dashed #dee2e6; }
        }
    </style>

    <main class="py-4">
        <div class="container">

            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Edit Service Advisor</h4>
                    <p class="text-muted small mb-0 d-none d-md-block">Memperbarui data pengecekan kendaraan.</p>
                </div>
                <div class="text-end">
                    <a href="<?php echo e(route('advisor.index')); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('advisor.update', $advisor->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="booking-selector-area">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold text-warning mb-1">
                                Data Antrian #<?php echo e($advisor->booking->queue_number); ?>

                            </h6>
                            <p class="mb-0 text-dark">
                                <strong><?php echo e($advisor->booking->customer_name); ?></strong>
                                (<?php echo e(strtoupper($advisor->booking->plate_number)); ?>) — <?php echo e($advisor->booking->vehicle_type); ?>

                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <span class="badge bg-light text-dark border">
                                <?php echo e(\Carbon\Carbon::parse($advisor->booking->booking_date)->format('d M Y')); ?>

                            </span>
                        </div>
                    </div>
                    <div class="mt-3 p-3 rounded-3 bg-light border border-warning" style="border-left-width: 4px !important;">
                        <div class="d-flex">
                            <i class="fas fa-comment-dots text-warning mt-1 me-3 fs-5"></i>
                            <div>
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Keluhan Awal</small>
                                <p class="mb-0 text-dark fw-bold fst-italic">
                                    "<?php echo e($advisor->booking->complaint ?? 'Tidak ada keluhan.'); ?>"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-user-friends me-2"></i> Data Pelanggan
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">

                            
                            <div class="col-12 col-md-6 border-end-md">
                                <div class="section-label text-primary">Data Pembawa (Saat Ini)</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pembawa</label>
                                        <input type="text" name="carrier_name" class="form-control" required
                                            value="<?php echo e($advisor->carrier_name); ?>" placeholder="Nama...">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="carrier_phone" class="form-control" required
                                            value="<?php echo e($advisor->carrier_phone); ?>" placeholder="08xxx">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Hubungan</label>
                                        <select name="relationship" class="form-select">
                                            <option value="Pemilik Sendiri" <?php echo e($advisor->relationship == 'Pemilik Sendiri' ? 'selected' : ''); ?>>Pemilik</option>
                                            <option value="Keluarga"        <?php echo e($advisor->relationship == 'Keluarga'        ? 'selected' : ''); ?>>Keluarga</option>
                                            <option value="Karyawan"        <?php echo e($advisor->relationship == 'Karyawan'        ? 'selected' : ''); ?>>Karyawan</option>
                                            <option value="Lainnya"         <?php echo e($advisor->relationship == 'Lainnya'         ? 'selected' : ''); ?>>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat</label>
                                        <input type="text" name="carrier_address" class="form-control"
                                            value="<?php echo e($advisor->carrier_address); ?>" placeholder="Domisili">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Kel/Kec</label>
                                        <input type="text" name="carrier_area" class="form-control"
                                            value="<?php echo e($advisor->carrier_area); ?>">
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-label text-success mb-0">Data Pemilik (STNK)</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="copyDataCheck"
                                            onchange="copyCarrierToOwner()">
                                        <label class="form-check-label small" for="copyDataCheck">Sama Dengan Pembawa</label>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pemilik</label>
                                        <input type="text" name="owner_name" id="owner_name" class="form-control" 
                                            value="<?php echo e($advisor->owner_name); ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="owner_phone" id="owner_phone" class="form-control"
                                            value="<?php echo e($advisor->owner_phone); ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Dari Dealer Sendiri</label>
                                        <div class="d-flex gap-2 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dYes" value="1" <?php echo e($advisor->is_own_dealer ? 'checked' : ''); ?>>
                                                <label class="form-check-label small" for="dYes">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dNo" value="0" <?php echo e(!$advisor->is_own_dealer ? 'checked' : ''); ?>>
                                                <label class="form-check-label small" for="dNo">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat</label>
                                        <input type="text" name="owner_address" id="owner_address" class="form-control"
                                            value="<?php echo e($advisor->owner_address); ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Kel/Kec</label>
                                        <input type="text" name="owner_area" id="owner_area" class="form-control"
                                            value="<?php echo e($advisor->owner_area); ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-motorcycle me-2"></i> Data Kendaraan
                    </div>
                    <div class="card-body p-4">

                        
                        <div class="p-3 mb-4 rounded-3" style="background-color: #f8f9fa;">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Antrian</label>
                                    <input type="text" class="form-control input-readonly" readonly
                                        value="<?php echo e($advisor->booking->queue_number); ?>">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Tgl Booking</label>
                                    <input type="text" class="form-control input-readonly" readonly
                                        value="<?php echo e(\Carbon\Carbon::parse($advisor->booking->booking_date)->format('d M Y')); ?>">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">No. Polisi</label>
                                    <input type="text" class="form-control input-readonly" readonly
                                        value="<?php echo e(strtoupper($advisor->booking->plate_number)); ?>">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Tipe Motor</label>
                                    <input type="text" class="form-control input-readonly" readonly
                                        value="<?php echo e($advisor->booking->vehicle_type); ?>">
                                </div>
                            </div>
                        </div>

                        
                        <div class="section-label">Pengecekan Fisik</div>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom text-danger">KM (Saat ini)*</label>
                                <input type="text" id="odometer_display" class="form-control fw-bold"
                                    value="<?php echo e(number_format($advisor->odometer, 0, ',', '.')); ?>" required>
                                <input type="hidden" name="odometer" id="odometer_real" value="<?php echo e($advisor->odometer); ?>">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">Tahun</label>
                                <input type="number" name="vehicle_year" class="form-control"
                                    value="<?php echo e($advisor->vehicle_year); ?>" placeholder="20xx">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">No. Mesin</label>
                                <input type="text" name="engine_number" class="form-control"
                                    value="<?php echo e($advisor->engine_number); ?>" placeholder="Opsional">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">No. Rangka</label>
                                <input type="text" name="chassis_number" class="form-control"
                                    value="<?php echo e($advisor->chassis_number); ?>" placeholder="Opsional">
                            </div>
                        </div>

                        <div class="section-label mt-4">Data Tambahan</div>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Alasan Ke Ahass</label>
                                <select name="visit_reason" class="form-control">
                                    <option value="">Pilih...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Inisiatif Sendiri','SMS Reminder','Telp Reminder','Sticker Reminder','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($reason); ?>" <?php echo e($advisor->visit_reason == $reason ? 'selected' : ''); ?>>
                                            <?php echo e($reason); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Email</label>
                                <input type="email" name="customer_email" class="form-control"
                                    value="<?php echo e($advisor->customer_email); ?>">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Sosmed</label>
                                <input type="text" name="customer_social" class="form-control"
                                    value="<?php echo e($advisor->customer_social); ?>" placeholder="@ig">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom text-danger fw-bold">Nama Mekanik*</label>
                                <input type="text" name="nama_mekanik" class="form-control border-danger" required
                                    value="<?php echo e($advisor->nama_mekanik); ?>" placeholder="Wajib diisi">
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label-custom">Catatan SA</label>
                                <textarea name="advisor_notes" class="form-control" rows="2"
                                    placeholder="Catatan fisik motor..."><?php echo e($advisor->advisor_notes); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="form-card">
                    <div class="form-header-title bg-warning text-dark">
                        <i class="fas fa-handshake me-2"></i> Persetujuan
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 border-end-md">
                                <label class="form-label-custom fw-bold">Pekerjaan Tambahan:</label>
                                <div class="d-flex flex-column gap-2 mt-1">
                                    <div class="form-check p-3 border rounded bg-light position-relative">
                                        <input class="form-check-input" type="radio" name="pkb_approval"
                                            id="approval_call" value="hubungi" checked>
                                        <label class="form-check-label w-100 stretched-link" for="approval_call">
                                            <i class="fas fa-phone-alt me-2 text-primary"></i> Konfirmasi / Telp
                                        </label>
                                    </div>
                                    <div class="form-check p-3 border rounded bg-light position-relative">
                                        <input class="form-check-input" type="radio" name="pkb_approval"
                                            id="approval_direct" value="langsung">
                                        <label class="form-check-label w-100 stretched-link" for="approval_direct">
                                            <i class="fas fa-tools me-2 text-success"></i> Langsung Kerja
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-custom fw-bold">Part Bekas:</label>
                                <div class="d-flex gap-2 mt-1">
                                    <div
                                        class="form-check flex-fill p-3 border rounded bg-light text-center position-relative">
                                        <input class="form-check-input float-none me-1" type="radio"
                                            name="part_bekas_dibawa" id="part_yes" value="1">
                                        <label class="form-check-label fw-bold stretched-link"
                                            for="part_yes">DIBAWA</label>
                                    </div>
                                    <div
                                        class="form-check flex-fill p-3 border rounded bg-light text-center position-relative">
                                        <input class="form-check-input float-none me-1" type="radio"
                                            name="part_bekas_dibawa" id="part_no" value="0" checked>
                                        <label class="form-check-label fw-bold stretched-link"
                                            for="part_no">DITINGGAL</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-tools me-2"></i> Daftar Pekerjaan
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" id="jobTable" style="min-width: 400px;">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 45%">Jenis Pekerjaan</th>
                                        <th style="width: 35%">Estimasi Biaya</th>
                                        <th style="width: 20%">x</th>
                                    </tr>
                                </thead>
                                <tbody id="jobListBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="p-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm fw-bold w-100" onclick="addJobRow()">
                                                <i class="fas fa-plus me-1"></i> Tambah Pekerjaan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold bg-light">
                                        <td class="text-end">Total Pekerjaan</td>
                                        <td colspan="2" class="text-primary text-end px-3" id="totalJobCost">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="emptyJobState" class="text-center py-4 text-muted border rounded mt-0 bg-light"
                            style="border-top: none !important; display: none;">
                            <p class="small mb-0">Belum ada pekerjaan.</p>
                        </div>
                    </div>
                </div>

                
                <div class="form-card mt-4">
                    <div class="form-header-title" style="background-color: #198754;">
                        <i class="fas fa-boxes me-2"></i> Sparepart
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" id="sparepartTable"
                                style="min-width: 500px;">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 40%">Barang</th>
                                        <th style="width: 15%">Qty</th>
                                        <th style="width: 20%">Harga</th>
                                        <th style="width: 20%">Subtotal</th>
                                        <th style="width: 5%">x</th>
                                    </tr>
                                </thead>
                                <tbody id="sparepartTableBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="p-2">
                                            <button type="button" class="btn btn-outline-success btn-sm fw-bold w-100"
                                                onclick="addSparepartRow()">
                                                <i class="fas fa-plus me-1"></i> Tambah Barang
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-end">Total Part</td>
                                        <td colspan="2" class="text-success text-end px-3" id="totalPartDisplay">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="emptyPartState" class="text-center py-4 text-muted border rounded mt-0 bg-light"
                            style="border-top: none !important;">
                            <p class="small mb-0">Belum ada sparepart.</p>
                        </div>
                    </div>
                </div>
                

                <div class="d-grid mt-5 mb-5">
                    <button type="submit" class="btn btn-primary-custom btn-lg shadow">
                        <i class="fas fa-save me-2"></i> PERBARUI DATA
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            <?php if(session('success')): ?>
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: '<?php echo e(session('success')); ?>',
                    effect: 'slide',
                    autotimeout: 3000
                });
            <?php endif; ?>

            // Odometer format
            const display = document.getElementById('odometer_display');
            const real    = document.getElementById('odometer_real');
            display.addEventListener('input', function () {
                let angka = this.value.replace(/\D/g, '');
                this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                real.value = angka;
            });

            // Load existing jobs
            if (Array.isArray(existingJobs)) {
                existingJobs.forEach(job => addJobRow(job.name || '', parseInt(job.price) || 0));
            }
            if (document.getElementById('jobListBody').children.length === 0) {
                document.getElementById('emptyJobState').style.display = 'block';
            }

            // Load existing spareparts
            if (Array.isArray(existingParts)) {
                existingParts.forEach(part => addSparepartRow(part.id, part.qty, part.price));
            }
            if (document.getElementById('sparepartTableBody').children.length === 0) {
                document.getElementById('emptyPartState').style.display = 'block';
            }

            calcJobTotal();
            calcPartTotal();
        });

        // Copy Pembawa → Pemilik
        function copyCarrierToOwner() {
            const checked = document.getElementById('copyDataCheck').checked;
            if (checked) {
                document.getElementById('owner_name').value    = document.querySelector('[name=carrier_name]').value;
                document.getElementById('owner_address').value = document.querySelector('[name=carrier_address]').value;
                document.getElementById('owner_area').value    = document.querySelector('[name=carrier_area]').value;
                document.getElementById('owner_phone').value   = document.querySelector('[name=carrier_phone]').value;
            } else {
                ['owner_name','owner_address','owner_area','owner_phone'].forEach(id => {
                    document.getElementById(id).value = '';
                });
            }
        }

        // ── DATA ──────────────────────────────────────────────────────────────
        const servicesData  = <?php echo json_encode($services, 15, 512) ?>;
        const sparepartsData = <?php echo json_encode($spareparts, 15, 512) ?>;
        const existingJobs  = <?php echo json_encode($advisor->jobs ?? [], 15, 512) ?>;
        const existingParts = <?php echo json_encode($advisor->spareparts ?? [], 15, 512) ?>;

        let jobRowIdx  = 0;
        let partRowIdx = 0;

        // ── JOB LOGIC ─────────────────────────────────────────────────────────
        function fillJobPrice(rowId, val) {
            const svc = servicesData.find(s => s.name === val);
            const row = document.getElementById(rowId);
            if (!row) return;

            const displayInput = row.querySelector('.job-price-display');
            const rawInput     = row.querySelector('.job-price-raw');

            if (svc && svc.price) {
                displayInput.value = new Intl.NumberFormat('id-ID').format(svc.price);
                rawInput.value     = svc.price;
            } else {
                // Custom — clear harga, fokus ke input agar user isi manual
                displayInput.value = '';
                rawInput.value     = 0;
                setTimeout(() => displayInput.focus(), 100);
            }
            calcJobTotal();
        }

        function addJobRow(name = '', price = 0) {
            document.getElementById('emptyJobState').style.display = 'none';
            const tbody    = document.getElementById('jobListBody');
            const rowId    = `job-row-${jobRowIdx}`;
            const selectId = `job-select-${jobRowIdx}`;
            const priceFormatted = price ? new Intl.NumberFormat('id-ID').format(price) : '';

            let optionsHtml = '<option value="">Pilih / Ketik Pekerjaan...</option>';
            servicesData.forEach(svc => {
                optionsHtml += `<option value="${svc.name}">${svc.name}</option>`;
            });

            const rowHtml = `
                <tr id="${rowId}">
                    <td>
                        <select name="jobs_name[]" id="${selectId}" class="form-select form-select-sm" required>
                            ${optionsHtml}
                        </select>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control form-control-sm job-price-display text-end"
                                placeholder="0" value="${priceFormatted}"
                                oninput="syncJobPrice('${rowId}', this)"
                                onkeyup="syncJobPrice('${rowId}', this)">
                            <input type="hidden" name="jobs_price[]" class="job-price-raw" value="${price}">
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeJobRow('${rowId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>`;

            tbody.insertAdjacentHTML('beforeend', rowHtml);

            const ts = new TomSelect(`#${selectId}`, {
                create       : true,
                createOnBlur : true,
                sortField    : { field: 'text', direction: 'asc' },
                placeholder  : 'Pilih / Ketik baru...',
                onChange: function (val) {
                    fillJobPrice(rowId, val);
                }
            });

            if (name) {
                if (!servicesData.find(s => s.name === name)) {
                    ts.addOption({ value: name, text: name });
                }
                // Jika price sudah ada → silent (tidak timpa), jika tidak → trigger onChange
                ts.setValue(name, price > 0);
            }

            jobRowIdx++;
            calcJobTotal();
        }

        function syncJobPrice(rowId, input) {
            let angka = input.value.replace(/\D/g, '');
            input.value = angka ? new Intl.NumberFormat('id-ID').format(parseInt(angka)) : '';
            document.getElementById(rowId).querySelector('.job-price-raw').value = angka || 0;
            calcJobTotal();
        }

        function removeJobRow(rowId) {
            document.getElementById(rowId).remove();
            calcJobTotal();
            if (document.getElementById('jobListBody').children.length === 0) {
                document.getElementById('emptyJobState').style.display = 'block';
            }
        }

        function calcJobTotal() {
            let total = 0;
            document.querySelectorAll('.job-price-raw').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('totalJobCost').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // ── SPAREPART LOGIC ───────────────────────────────────────────────────
        function addSparepartRow(id = '', qty = 1, price = 0) {
            document.getElementById('emptyPartState').style.display = 'none';
            const tbody    = document.getElementById('sparepartTableBody');
            const rowId    = `part-row-${partRowIdx}`;
            const selectId = `part-select-${partRowIdx}`;
            const subtotal = qty * price;

            let optionsHtml = '<option value="">Cari & Pilih Barang...</option>';
            sparepartsData.forEach(p => {
                optionsHtml += `<option value="${p.id}" data-price="${p.harga_jual}"
                    ${p.id == id ? 'selected' : ''}>${p.nama_barang} (Stok: ${p.jumlah_barang})</option>`;
            });

            const rowHtml = `
                <tr id="${rowId}">
                    <td style="min-width: 250px;">
                        <select name="parts_id[]" id="${selectId}" class="form-select form-select-sm" required>
                            ${optionsHtml}
                        </select>
                    </td>
                    <td style="min-width: 70px;">
                        <input type="number" name="parts_qty[]" class="form-control form-control-sm text-center part-qty"
                            value="${qty}" min="1" oninput="updatePartRow('${rowId}')" required>
                    </td>
                    <td style="min-width: 100px;">
                        <input type="text" class="form-control form-control-sm bg-light text-end part-price-display" readonly
                            value="${price ? new Intl.NumberFormat('id-ID').format(price) : '0'}">
                        <input type="hidden" name="parts_price[]" class="part-price-raw" value="${price}">
                    </td>
                    <td style="min-width: 100px;">
                        <input type="text" class="form-control form-control-sm bg-light text-end fw-bold part-subtotal-display" readonly
                            value="${new Intl.NumberFormat('id-ID').format(subtotal)}">
                        <input type="hidden" class="part-subtotal-raw" value="${subtotal}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removePartRow('${rowId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>`;

            tbody.insertAdjacentHTML('beforeend', rowHtml);

            new TomSelect(`#${selectId}`, {
                create      : false,
                sortField   : { field: 'text', direction: 'asc' },
                placeholder : 'Ketik nama barang...',
                onChange: function (val) {
                    const option = sparepartsData.find(p => p.id == val);
                    if (option) {
                        const p = parseInt(option.harga_jual) || 0;
                        const row = document.getElementById(rowId);
                        row.querySelector('.part-price-raw').value     = p;
                        row.querySelector('.part-price-display').value = new Intl.NumberFormat('id-ID').format(p);
                        updatePartRow(rowId);
                    }
                }
            });

            partRowIdx++;
            calcPartTotal();
        }

        function updatePartRow(rowId) {
            const row      = document.getElementById(rowId);
            const qty      = parseInt(row.querySelector('.part-qty').value) || 0;
            const price    = parseInt(row.querySelector('.part-price-raw').value) || 0;
            const subtotal = qty * price;
            row.querySelector('.part-subtotal-raw').value          = subtotal;
            row.querySelector('.part-subtotal-display').value      = new Intl.NumberFormat('id-ID').format(subtotal);
            calcPartTotal();
        }

        function removePartRow(rowId) {
            document.getElementById(rowId).remove();
            calcPartTotal();
            if (document.getElementById('sparepartTableBody').children.length === 0) {
                document.getElementById('emptyPartState').style.display = 'block';
            }
        }

        function calcPartTotal() {
            let total = 0;
            document.querySelectorAll('.part-subtotal-raw').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('totalPartDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/advisor/edit.blade.php ENDPATH**/ ?>