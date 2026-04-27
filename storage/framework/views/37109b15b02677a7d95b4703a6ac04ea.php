
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        :root {
            --brand-primary: #2A6E7F;
            --brand-primary-dark: #1D4F5D;
            --brand-secondary: #FF7A45;
            --bg-body: #f4f7f9;
        }

        :root {
            --brand-primary: #2A6E7F;
            --brand-primary-dark: #1D4F5D;
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

        /* Card Modern */
        .card-modern {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            height: 100%;
            transition: transform 0.2s ease;
        }

        .section-header {
            background: linear-gradient(to right, rgba(42, 110, 127, 0.05), transparent);
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--brand-primary);
            font-size: 1.1rem;
        }

        .section-header i {
            color: var(--brand-secondary);
            font-size: 1.25rem;
        }

        .form-label-custom {
            font-weight: 600;
            font-size: 0.85rem;
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
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(42, 110, 127, 0.1);
        }

        /* Service Cards */
        .service-card-label {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s;
            position: relative;
        }

        .service-card-label:hover {
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }

        .btn-check:checked+.service-card-label {
            border-color: var(--brand-secondary);
            background-color: #fffaf7;
            box-shadow: 0 8px 20px rgba(255, 122, 69, 0.15);
        }

        .check-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--brand-secondary);
            font-size: 1.2rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s;
        }

        .btn-check:checked+.service-card-label .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* 1. Style Default Deskripsi (Saat Belum Dipilih) */
        .desc-full {
            display: none;
            /* Sembunyikan deskripsi panjang */
            color: var(--text-main);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            line-height: 1.5;
        }

        .desc-short {
            display: block;
            /* Tampilkan deskripsi pendek */
        }

        /* 2. Logika Saat Dipilih (Checked) */

        /* Sembunyikan deskripsi pendek */
        .btn-check:checked+.service-card-label .desc-short {
            display: none;
        }

        /* Tampilkan deskripsi panjang dengan animasi */
        .btn-check:checked+.service-card-label .desc-full {
            display: block !important;
            animation: fadeInDown 0.4s ease forwards;
        }

        /* Animasi Turun Halus */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Summary Box */
        .summary-box {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(42, 110, 127, 0.25);
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.95rem;
        }

        .btn-submit {
            background: var(--brand-secondary);
            color: white;
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 122, 69, 0.3);
        }

        .btn-submit:hover {
            background: var(--brand-secondary-hover);
            transform: translateY(-2px);
        }

        .badge-price {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .category-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .category-divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin-left: 1rem;
            border-radius: 2px;
        }

        /* Helper untuk sticky di desktop */
        @media (min-width: 992px) {
            .sticky-desktop {
                position: sticky;
                top: 20px;
            }
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

            <form method="POST" action="<?php echo e(route('customer.booking.store')); ?>" id="bookingForm">
                <?php echo csrf_field(); ?>

                <div class="row g-4">

                    
                    <div class="col-lg-4">
                        <div class="sticky-desktop">
                            <div class="card-modern mb-4">
                                <div class="section-header">
                                    <i class="fas fa-id-card"></i> <span>Informasi Pelanggan</span>
                                </div>
                                <div class="card-body p-4">
                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom text-muted">Nama Pemilik</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="customer_name"
                                                class="form-control bg-light fw-bold text-dark" value="<?php echo e($user->name); ?>"
                                                readonly>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i
                                                    class="fab fa-whatsapp text-success"></i></span>
                                            <input type="text" name="customer_whatsapp" class="form-control"
                                                value="<?php echo e($user->phone); ?>" placeholder="08xxx" required>
                                        </div>
                                    </div>

                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <label class="form-label-custom">Jenis Motor</label>
                                            <select class="form-select" name="vehicle_type">
                                                <option value="" selected disabled>Pilih...</option>
                                                <option value="bebek">Bebek</option>
                                                <option value="sport">Sport</option>
                                                <option value="matic">Matic</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom">Plat Nomor</label>
                                            <input type="text" name="plate_number"
                                                class="form-control text-uppercase fw-medium" placeholder="* **** **"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label-custom">Rencana Booking</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i
                                                    class="fas fa-calendar-day text-primary"></i></span>
                                            <input type="datetime-local" name="booking_date" id="booking_date"
                                                class="form-control form-control-lg shadow-sm" required
                                                value="<?php echo e(old('booking_date')); ?>">
                                        </div>
                                        <div class="form-text small text-danger mt-1">
                                            <i class="fas fa-info-circle me-1"></i> Slot terbatas.
                                        </div>
                                    </div>

                                    
                                    <div id="date_feedback" class="mt-2"></div>

                                    
                                    <div>
                                        <label class="form-label-custom">Keluhan / Catatan</label>
                                        <textarea name="complaint" class="form-control" rows="0"
                                            placeholder="Contoh: Rem bunyi, Bocor alus, Rantai soak...."></textarea>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="d-none d-lg-block">
                                <div class="summary-box">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-receipt me-3"></i> Ringkasan Pesanan
                                    </h5>

                                    <div
                                        class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                        <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                        <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                    </div>

                                    <ul class="summary-list" style="display: none;"></ul>

                                    <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                        <div class="d-flex justify-content-between align-items-end mb-4">
                                            <span class="small text-uppercase opacity-75 ls-1">Total Estimasi</span>
                                            <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-paper-plane me-2"></i> Konfirmasi Booking
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
                                    <i class="fas fa-tools"></i> <span>Pilih Layanan Servis</span>
                                </div>
                                <span class="badge bg-light text-dark fw-normal border">
                                    <i class="fas fa-check-double me-1"></i> Multi-select
                                </span>
                            </div>

                            <div class="card-body p-4 p-md-5">
                                
                                <div class="category-divider">
                                    <span class="text-danger"><i class="fas fa-star me-2"></i>Paket Spesial</span>
                                </div>
                                <div class="row g-4 mb-5 align-items-start">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services->where('type', 'paket'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <div class="col-md-6">
                                            <input type="checkbox" class="btn-check service-checkbox" name="service_ids[]"
                                                id="service_<?php echo e($paket->id); ?>" value="<?php echo e($paket->id); ?>"
                                                data-name="<?php echo e($paket->name); ?>" data-price="<?php echo e($paket->price); ?>">

                                            <label class="service-card-label h-100" for="service_<?php echo e($paket->id); ?>">
                                                <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                    <h6 class="fw-bold text-dark mb-0 fs-5"><?php echo e($paket->name); ?></h6>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mb-3">
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                                        Rp <?php echo e(number_format($paket->price, 0, ',', '.')); ?>

                                                    </span>
                                                </div>
                                                <div class="text-muted small border-top pt-3 mt-auto">
                                                    <span
                                                        class="desc-short"><?php echo e(Str::limit($paket->description, 60, '...')); ?></span>
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
                                            <input type="checkbox" class="btn-check service-checkbox" name="service_ids[]"
                                                id="service_<?php echo e($layanan->id); ?>" value="<?php echo e($layanan->id); ?>"
                                                data-name="<?php echo e($layanan->name); ?>" data-price="<?php echo e($layanan->price); ?>">

                                            <label class="service-card-label" for="service_<?php echo e($layanan->id); ?>">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="fw-bold text-dark"><?php echo e($layanan->name); ?></div>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mt-auto pt-2">
                                                    <span class="fw-bold text-secondary fs-5">
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

                                <div
                                    class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                    <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                    <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                </div>

                                <ul class="summary-list" style="display: none;"></ul>

                                <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                    <div class="d-flex justify-content-between align-items-end mb-4">
                                        <span class="small text-uppercase opacity-75 ls-1">Total Estimasi</span>
                                        <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span></div>
                                    </div>

                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-paper-plane me-2"></i> Konfirmasi Booking
                                    </button>
                                </div>
                            </div>

                            <br>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.service-checkbox');

            // Selector Class (untuk menangkap element di Desktop & Mobile sekaligus)
            const summaryLists = document.querySelectorAll('.summary-list');
            const totalPriceDisplays = document.querySelectorAll('.total-price-display');
            const emptyStates = document.querySelectorAll('.empty-state');

            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID').format(number);
            };

            const updateSummary = () => {
                let total = 0;
                let html = '';
                let count = 0;

                checkboxes.forEach(chk => {
                    if (chk.checked) {
                        count++;
                        const name = chk.getAttribute('data-name');
                        const price = parseFloat(chk.getAttribute('data-price'));
                        total += price;

                        html += `
                                                        <li class="summary-item animate__animated animate__fadeInRight animate__faster">
                                                            <div><i class="fas fa-check text-white-50 me-2 small"></i><span>${name}</span></div>
                                                            <span class="badge-price">Rp ${formatRupiah(price)}</span>
                                                        </li>
                                                    `;
                    }
                });

                // Update konten ke SEMUA Ringkasan (Desktop & Mobile)
                summaryLists.forEach(list => {
                    list.innerHTML = html;
                    list.style.display = count > 0 ? 'block' : 'none';
                });

                totalPriceDisplays.forEach(display => {
                    display.innerText = formatRupiah(total);
                });

                emptyStates.forEach(state => {
                    state.style.display = count > 0 ? 'none' : 'block';
                });
            };

            checkboxes.forEach(chk => {
                chk.addEventListener('change', updateSummary);
            });
        });
    </script>

    <script>
        document.getElementById('booking_date').addEventListener('change', function () {
            let dateVal = this.value;
            let feedback = document.getElementById('date_feedback');
            let inputEl = this;

            if (!dateVal) return;

            fetch(`/cek-jadwal?date=${dateVal}`)
                .then(response => response.json())
                .then(data => {
                    // PERBAIKAN: Pastikan 'data' tidak null DAN properti 'title' tersedia
                    if (data && data.title) {
                        let isTutup = data.is_closed; 
                        let icon = isTutup ? 'fa-exclamation-triangle' : 'fa-info-circle';
                        
                        // Buat format deskripsi lebih rapi jika kosong
                        let desc = data.description ? `: ${data.description}` : '';

                        feedback.innerHTML = `
                        <div class="alert ${isTutup ? 'alert-danger' : 'alert-info'} border-0 shadow-sm rounded-3 py-2 px-3 animate__animated animate__shakeX">
                            <i class="fas ${icon} me-2"></i>
                            <strong>${data.title}</strong>${desc}
                        </div>`;

                        if (isTutup) {
                            showToast('error', 'Tanggal Tidak Tersedia', 'Maaf, bengkel kami tutup/libur pada tanggal tersebut.');
                            inputEl.value = ''; 
                        }
                    } else {
                        // Jika tidak ada data event (tanggal tersedia), kosongkan area feedback
                        feedback.innerHTML = '';
                    }
                })
                .catch(error => {
                    // Tambahan pengaman jika terjadi error koneksi ke backend
                    console.error('Error fetching jadwal:', error);
                    feedback.innerHTML = '';
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookingDateInput = document.getElementById('booking_date');

            // 1. Fungsi Notifikasi
            function showToast(status, title, msg) {
                new Notify({
                    status: status,
                    title: title,
                    text: msg,
                    effect: 'slide',
                    speed: 300,
                    autoclose: true,
                    autotimeout: 5000,
                    position: 'right top'
                });
            }

            // 2. Cek Notifikasi dari Session Laravel
            <?php if(Session::has('success')): ?>
                showToast('success', 'Berhasil', "<?php echo Session::get('success'); ?>");
            <?php endif; ?>

            <?php if(Session::has('error')): ?>
                showToast('error', 'Gagal', "<?php echo Session::get('error'); ?>");
            <?php endif; ?>

            // 3. Validasi Real-time Hari Minggu
            bookingDateInput.addEventListener('change', function () {
                const date = new Date(this.value);
                const day = date.getDay(); // 0 = Minggu

                if (day === 0) {
                    showToast('error', 'Bengkel Tutup', 'Mohon maaf, kami libur di hari Minggu. Silakan pilih hari lain.');
                    this.value = ''; // Reset input
                }
            });

            // 4. Script Perhitungan Harga (Ringkasan)
            const checkboxes = document.querySelectorAll('.service-checkbox');
            const summaryLists = document.querySelectorAll('.summary-list');
            const totalPriceDisplays = document.querySelectorAll('.total-price-display');

            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID').format(number);
            };

            const updateSummary = () => {
                let total = 0;
                let html = '';

                checkboxes.forEach(chk => {
                    if (chk.checked) {
                        const name = chk.getAttribute('data-name');
                        const price = parseFloat(chk.getAttribute('data-price'));
                        total += price;
                        html += `<li class="d-flex justify-content-between mb-2">
                                                                <span>${name}</span>
                                                                <strong>Rp ${formatRupiah(price)}</strong>
                                                             </li>`;
                    }
                });

                summaryLists.forEach(list => { list.innerHTML = html; });
                totalPriceDisplays.forEach(display => { display.innerText = formatRupiah(total); });
            };

            checkboxes.forEach(chk => chk.addEventListener('change', updateSummary));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/pelanggan/service.blade.php ENDPATH**/ ?>