<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --brand-secondary: #FF7A45;
            --brand-secondary-hover: #e6602e;
            --bg-body: #f4f7f9;
            --bg-card: #ffffff;
            --text-main: #2d3748;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* ===== CARD ===== */
        .card-modern {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(to right, var(--honda-red-soft), transparent);
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--honda-red);
            font-size: 1.05rem;
        }

        .section-header i {
            color: var(--honda-red);
            font-size: 1.2rem;
        }

        /* ===== FORM FIELDS ===== */
        .form-label-custom {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background: #f8fafc;
            border-color: var(--border-color);
            color: #718096;
        }

        .form-control,
        .form-select {
            border-color: var(--border-color);
            padding: 0.72rem 1rem;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--honda-red);
            box-shadow: 0 0 0 3px rgba(177, 0, 0, 0.1);
        }

        /* ===== SERVICE CARD CHECKBOX ===== */
        .service-card-label {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 1.1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s;
            position: relative;
            word-break: break-word;
        }

        .service-card-label:hover {
            border-color: #fca5a5;
            transform: translateY(-2px);
        }

        .btn-check:checked + .service-card-label {
            border-color: var(--honda-red);
            background-color: #fff5f5;
            box-shadow: 0 8px 20px rgba(177, 0, 0, 0.12);
        }

        .check-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--honda-red);
            font-size: 1.1rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s;
        }

        .btn-check:checked + .service-card-label .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        .desc-full  { 
            display: none; 
            color: var(--text-main); 
            font-size: 0.88rem; 
            margin-top: 0.5rem; 
            line-height: 1.5; 
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .desc-short { 
            display: block; 
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .btn-check:checked + .service-card-label .desc-short { display: none; }
        .btn-check:checked + .service-card-label .desc-full  { display: block !important; animation: fadeInDown 0.4s ease forwards; }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== CATEGORY DIVIDER ===== */
        .category-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.25rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.88rem;
        }

        .category-divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin-left: 1rem;
            border-radius: 2px;
        }

        /* ===== SUMMARY BOX ===== */
        .summary-box {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(177, 0, 0, 0.22);
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 1.25rem 0;
            max-height: 280px;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.92rem;
        }

        .badge-price {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.82rem;
            white-space: nowrap;
        }

        .btn-submit {
            background: white;
            color: var(--honda-red);
            width: 100%;
            padding: 0.9rem;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            font-size: 1rem;
        }

        .btn-submit:hover {
            background: #f8f8f8;
            transform: translateY(-2px);
            color: var(--honda-red-dark);
        }

        /* ===== PAGE HEADER ===== */
        .page-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--honda-red-soft);
            border: 1px solid rgba(177, 0, 0, 0.15);
            color: var(--honda-red);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        /* ===== INFO BOX ===== */
        .info-box-red {
            background: #fff5f5;
            border: 1px solid rgba(177, 0, 0, 0.2);
            border-left: 4px solid var(--honda-red);
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 0.88rem;
            color: #7f1d1d;
            margin-bottom: 1.5rem;
        }

        /* ===== STICKY SIDEBAR ===== */
        @media (min-width: 992px) {
            .sticky-desktop { position: sticky; top: 20px; }
        }

        /* ===== ESTIMASI DURATION ===== */
        .estimasi-box {
            background: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
    </style>

    <main class="py-5">
        <div class="container-xl">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4 animate__animated animate__fadeIn">
                    <ul class="mb-0 ps-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <li><?php echo e($error); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="page-header-badge">
                        <i class="fas fa-user-plus"></i> Booking Walk-In
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Booking Manual oleh Admin</h4>
                    <p class="text-muted small mb-0">Untuk pelanggan yang datang langsung ke bengkel.</p>
                </div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-light border fw-semibold">
                    <i class="fas fa-arrow-left me-2 text-muted"></i>Kembali
                </a>
            </div>

            
            <div class="info-box-red">
                <i class="fas fa-circle-info mt-1"></i>
                <div>
                    <strong>Info Antrian Hari Ini:</strong>
                    Saat ini ada <strong><?php echo e($todayactive); ?></strong> antrian aktif. Slot terbatas <strong>2 motor/jam</strong> booking akan ditolak otomatis jika slot penuh.
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('booking.storeWalkIn')); ?>" id="bookingForm">
                <?php echo csrf_field(); ?>

                <div class="row g-4 align-items-start">

                    
                    <div class="col-lg-4">
                        <div class="sticky-desktop">

                            
                            <div class="card-modern mb-4">
                                <div class="section-header">
                                    <i class="fas fa-id-card"></i>
                                    <span>Data Pelanggan</span>
                                </div>
                                <div class="card-body p-4">

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">Nama Pelanggan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <select name="user_id" id="userSelect" class="form-select" required
                                                    onchange="fillUserData(this)">
                                                <option value="" data-wa="" data-name="">-- Pilih Pelanggan --</option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                    <option
                                                        value="<?php echo e($customer->id); ?>"
                                                        data-name="<?php echo e($customer->name); ?>"
                                                        data-wa="<?php echo e($customer->phone ?? ''); ?>"
                                                        <?php echo e(old('user_id') == $customer->id ? 'selected' : ''); ?>>
                                                        <?php echo e($customer->name); ?>

                                                    </option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </select>
                                        </div>
                                        
                                        <input type="hidden" name="customer_name" id="customerNameHidden"
                                               value="<?php echo e(old('customer_name')); ?>">
                                        <div class="form-text small text-muted mt-1">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Pelanggan harus sudah terdaftar untuk booking walk-in.
                                            </small>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">WhatsApp / HP
                                            <small class="text-muted fw-normal normal-case">(Opsional)</small>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text text-success"><i class="fab fa-whatsapp"></i></span>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                inputmode="numeric"
                                                maxlength="12"
                                                name="customer_whatsapp" 
                                                id="customerWa" 
                                                placeholder="08xxxxxxxxxx"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            >
                                        </div>
                                    </div>

                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <label class="form-label-custom">Jenis Motor</label>
                                            <select class="form-select" name="vehicle_type" required>
                                                <option value="" disabled <?php echo e(old('vehicle_type') ? '' : 'selected'); ?>>Pilih...</option>
                                                <option value="bebek" <?php echo e(old('vehicle_type') == 'bebek' ? 'selected' : ''); ?>>Bebek</option>
                                                <option value="sport" <?php echo e(old('vehicle_type') == 'sport' ? 'selected' : ''); ?>>Sport</option>
                                                <option value="matic" <?php echo e(old('vehicle_type') == 'matic' ? 'selected' : ''); ?>>Matic</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom">Plat Nomor</label>
                                            <input 
                                                type="text" 
                                                name="plate_number"
                                                class="form-control text-uppercase fw-medium"
                                                placeholder="N **** **"
                                                maxlength="8"
                                                value="<?php echo e(old('plate_number')); ?>"
                                                required
                                            >
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">Tanggal & Jam Booking <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-day text-danger"></i></span>
                                            <input type="datetime-local" name="booking_date" class="form-control" required
                                                   value="<?php echo e(old('booking_date', now()->format('Y-m-d\TH:i'))); ?>">
                                        </div>
                                        <div class="form-text small text-danger mt-1">
                                            <small><i class="fas fa-info-circle me-1"></i> Slot terbatas 2 motor/jam.</small>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">Keluhan / Catatan</label>
                                        <textarea name="complaint" class="form-control" rows="3"
                                                  placeholder="Contoh: Rem bunyi, Bocor alus, Rantai soak..."><?php echo e(old('complaint')); ?></textarea>
                                    </div>

                                    
                                    <div class="estimasi-box">
                                        <label class="form-label-custom mb-2">
                                            Estimasi Durasi <small class="text-muted fw-normal">(Opsional)</small>
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <input type="number" name="estimation_hours" class="form-control"
                                                           placeholder="0" min="0"
                                                           value="<?php echo e(old('estimation_hours')); ?>">
                                                    <span class="input-group-text bg-white text-muted small">Jam</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <input type="number" name="estimation_minutes" class="form-control"
                                                           placeholder="0" min="0" max="59"
                                                           value="<?php echo e(old('estimation_minutes')); ?>">
                                                    <span class="input-group-text bg-white text-muted small">Menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            
                            <div class="d-none d-lg-block">
                                <div class="summary-box">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-receipt me-3"></i> Ringkasan Pesanan
                                    </h5>

                                    <div class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                        <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                        <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                    </div>

                                    <ul class="summary-list" style="display: none;"></ul>

                                    <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                        <div class="d-flex justify-content-between align-items-end mb-4">
                                            <span class="small text-uppercase opacity-75">Total Estimasi</span>
                                            <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span></div>
                                        </div>

                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-check-circle me-2"></i> Simpan Booking
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    
                    
                    
                    <div class="col-lg-8">
                        <div class="card-modern mb-4">
                            <div class="section-header justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-tools"></i>
                                    <span>Pilih Layanan Servis</span>
                                </div>
                                <span class="badge bg-light text-dark fw-normal border">
                                    <i class="fas fa-check-double me-1"></i> Multi-select
                                </span>
                            </div>

                            <div class="card-body p-4 p-md-5">

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['service_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert alert-danger py-2 small mb-3">
                                        <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <div class="category-divider">
                                    <span class="text-danger"><i class="fas fa-star me-2"></i>Paket Spesial</span>
                                </div>
                                <div class="row g-4 mb-5 align-items-start">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services->where('type', 'paket'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <div class="col-md-6">
                                            <input type="checkbox" class="btn-check service-checkbox"
                                                   name="service_ids[]"
                                                   id="service_<?php echo e($paket->id); ?>"
                                                   value="<?php echo e($paket->id); ?>"
                                                   data-name="<?php echo e($paket->name); ?>"
                                                   data-price="<?php echo e($paket->price); ?>"
                                                   <?php echo e(in_array($paket->id, old('service_ids', [])) ? 'checked' : ''); ?>>

                                            <label class="service-card-label h-100" for="service_<?php echo e($paket->id); ?>">
                                                <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                    <h6 class="fw-bold text-dark mb-0 fs-6"><?php echo e($paket->name); ?></h6>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                                        Rp <?php echo e(number_format($paket->price, 0, ',', '.')); ?>

                                                    </span>
                                                </div>
                                                <div class="text-muted small border-top pt-3 mt-auto">
                                                    <span class="desc-short"><?php echo e(Str::limit($paket->description, 60, '...')); ?></span>
                                                    <span class="desc-full"><?php echo e($paket->description); ?></span>
                                                </div>
                                            </label>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                
                                <div class="category-divider">
                                    <span class="text-primary"><i class="fas fa-wrench me-2"></i>Layanan Regular</span>
                                </div>
                                <div class="row g-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services->where('type', 'non_paket'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $layanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <div class="col-md-4 col-sm-6">
                                            <input type="checkbox" class="btn-check service-checkbox"
                                                   name="service_ids[]"
                                                   id="service_<?php echo e($layanan->id); ?>"
                                                   value="<?php echo e($layanan->id); ?>"
                                                   data-name="<?php echo e($layanan->name); ?>"
                                                   data-price="<?php echo e($layanan->price); ?>"
                                                   <?php echo e(in_array($layanan->id, old('service_ids', [])) ? 'checked' : ''); ?>>

                                            <label class="service-card-label" for="service_<?php echo e($layanan->id); ?>">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="fw-bold text-dark small"><?php echo e($layanan->name); ?></div>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mt-auto pt-2">
                                                    <span class="fw-bold text-secondary">
                                                        Rp <?php echo e(number_format($layanan->price, 0, ',', '.')); ?>

                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                            </div>
                        </div>

                        
                        <div class="d-block d-lg-none">
                            <div class="summary-box">
                                <h5 class="fw-bold mb-4 d-flex align-items-center">
                                    <i class="fas fa-receipt me-3"></i> Ringkasan Pesanan
                                </h5>

                                <div class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                    <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                    <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                </div>

                                <ul class="summary-list" style="display: none;"></ul>

                                <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                    <div class="d-flex justify-content-between align-items-end mb-4">
                                        <span class="small text-uppercase opacity-75">Total Estimasi</span>
                                        <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span></div>
                                    </div>

                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-check-circle me-2"></i> Simpan Booking
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // =============================================
        // Auto-fill WA saat pilih pelanggan
        // =============================================
        function fillUserData(select) {
            const opt = select.options[select.selectedIndex];
            const wa   = opt.getAttribute('data-wa')   || '';
            const name = opt.getAttribute('data-name') || '';

            document.getElementById('customerWa').value          = wa;
            document.getElementById('customerNameHidden').value  = name;
        }

        // Jalankan saat halaman pertama kali load (untuk old() value)
        document.addEventListener('DOMContentLoaded', function () {
            const sel = document.getElementById('userSelect');
            if (sel && sel.value) fillUserData(sel);
        });

        // =============================================
        // Live Summary Calculator
        // =============================================
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes          = document.querySelectorAll('.service-checkbox');
            const summaryLists        = document.querySelectorAll('.summary-list');
            const totalPriceDisplays  = document.querySelectorAll('.total-price-display');
            const emptyStates         = document.querySelectorAll('.empty-state');

            const fmt = (n) => new Intl.NumberFormat('id-ID').format(n);

            const updateSummary = () => {
                let total = 0, html = '', count = 0;

                checkboxes.forEach(chk => {
                    if (chk.checked) {
                        count++;
                        const name  = chk.getAttribute('data-name');
                        const price = parseFloat(chk.getAttribute('data-price'));
                        total += price;
                        html  += `
                            <li class="summary-item animate__animated animate__fadeInRight animate__faster">
                                <div><i class="fas fa-check text-white-50 me-2 small"></i><span>${name}</span></div>
                                <span class="badge-price">Rp ${fmt(price)}</span>
                            </li>`;
                    }
                });

                summaryLists.forEach(l => {
                    l.innerHTML    = html;
                    l.style.display = count > 0 ? 'block' : 'none';
                });
                totalPriceDisplays.forEach(d => d.innerText = fmt(total));
                emptyStates.forEach(s => s.style.display = count > 0 ? 'none' : 'block');
            };

            checkboxes.forEach(chk => chk.addEventListener('change', updateSummary));

            // Trigger jika ada old() checked saat back dari validasi
            updateSummary();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/booking/admin_create.blade.php ENDPATH**/ ?>