<div>
    
    <div class="table-card au d6 d-none d-md-block">
        <div class="table-header-bar">
            <div class="table-title">
                <i class="fas fa-address-book" style="color:#64748b;"></i>
                Daftar Akun
                <span class="item-count"><?php echo e($users->total()); ?> akun</span>
            </div>
            <span style="font-size:.78rem; color:#94a3b8; font-weight:500;">
                <i class="far fa-calendar me-1"></i><?php echo e(date('d M Y')); ?>

            </span>
        </div>

        <div class="table-scroll" style="position: relative;">
            <div wire:loading wire:target="updateSearch, gotoPage, nextPage, previousPage" wire:loading.class="d-flex"
                class="position-absolute w-100 h-100 justify-content-center align-items-center"
                style="background: rgba(255,255,255,0.7); z-index: 10;">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <table class="inv-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:52px;">#</th>
                        <th>Akun</th>
                        <th>Kontak &amp; Alamat</th>
                        <th class="text-center">Hak Akses</th>
                        <th class="text-center">Riwayat</th>
                        <th class="text-center" style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr>
                            <td class="row-num"><?php echo e($users->firstItem() + $index); ?></td>

                            <td>
                                <div class="item-name"><?php echo e($customer->name); ?></div>
                            </td>

                            <td>
                                <div class="price-row">
                                    <i class="fas fa-phone-alt price-label"></i>
                                    <span class="price-val"
                                        style="background:#f8fafc; color:#64748b;"><?php echo e($customer->phone ?? '-'); ?></span>
                                </div>
                                <div class="price-row">
                                    <i class="fas fa-envelope price-label"></i>
                                    <span class="price-val"
                                        style="background:#f8fafc; color:#64748b;"><?php echo e(Str::limit($customer->email, 40)); ?></span>
                                </div>
                            </td>

                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->role == 'admin'): ?>
                                    <span class="stok-badge stok-tipis"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                <?php else: ?>
                                    <span class="stok-badge stok-ok"><i class="fas fa-user me-1"></i>Customer</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <td class="text-center">
                                <span class="stok-badge" style="background:#e0f2fe; color:#0284c7;">
                                    <i class="fas fa-history me-1"></i><?php echo e($customer->bookings->count()); ?> Transaksi
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->bookings->isNotEmpty()): ?>
                                        <a href="<?php echo e(route('customers.bookings', ['id' => $customer->id])); ?>"
                                            class="btn-act btn-edit" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-act" disabled title="Belum ada riwayat"
                                            style="background:#f1f5f9; color:#94a3b8; border-color:#e2e8f0;">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <form action="<?php echo e(route('hapus', $customer->id)); ?>" method="POST"
      onsubmit="return confirm('Yakin ingin menghapus pengguna ini? Semua data booking akan ikut terhapus.')">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn-act btn-hapus" title="Hapus">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <p>Belum ada akun ditemukan. Coba sesuaikan kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            <?php echo e($users->links('livewire.custom-pagination')); ?>

        </div>
    </div>

    
    <div class="d-md-none au d6 position-relative bg-white p-3 rounded-4 shadow-sm border"
        style="border-color: #e2e8f0;">

        <div wire:loading wire:target="updateSearch, gotoPage, nextPage, previousPage" wire:loading.class="d-flex"
            class="position-absolute w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 10; border-radius: 1rem;">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="mb-3 fw-bold text-dark d-flex justify-content-between align-items-center"
            style="font-size: 0.95rem;">
            <div><i class="fas fa-address-book text-muted me-2"></i>Daftar Akun</div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: .95rem;"><?php echo e($customer->name); ?></div>
                        <small class="text-muted" style="font-size: .8rem;">#<?php echo e($users->firstItem() + $index); ?></small>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->role == 'admin'): ?>
                        <span class="stok-badge stok-tipis"><i class="fas fa-user-shield me-1"></i>Admin</span>
                    <?php else: ?>
                        <span class="stok-badge stok-ok"><i class="fas fa-user me-1"></i>Customer</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <div class="p-2 rounded-3" style="background:#f8fafc;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Kontak
                            </div>
                            <div style="font-weight:700; color:#475569; font-size:.85rem;">
                                <i class="fas fa-phone-alt me-1" style="color:#94a3b8;"></i><?php echo e($customer->phone ?? '-'); ?>

                                <br>
                                <i class="fas fa-envelope me-1"
                                    style="color:#94a3b8; margin-top:5px;"></i><?php echo e(Str::limit($customer->email, 30)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-2 rounded-3 d-flex justify-content-between align-items-center"
                            style="background:#e0f2fe; border: 1px solid rgba(2, 132, 199, .14);">
                            <div style="font-size:.7rem; color:#0284c7; font-weight:700; text-transform:uppercase;">
                                Riwayat Transaksi</div>
                            <div style="font-weight:800; color:#0284c7; font-size:.85rem;">
                                <i class="fas fa-history me-1"></i><?php echo e($customer->bookings->count()); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->bookings->isNotEmpty()): ?>
                        <a href="<?php echo e(route('customers.bookings', ['id' => $customer->id])); ?>" class="btn-act btn-edit flex-fill"
                            style="height:auto; padding:8px; width:auto; border-radius:8px;">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                    <?php else: ?>
                        <button class="btn btn-act flex-fill" disabled
                            style="height:auto; padding:8px; width:auto; border-radius:8px; background:#f1f5f9; color:#94a3b8; font-weight:600;">
                            <i class="fas fa-ban me-1"></i> Belum ada
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a href="<?php echo e(route('hapus', $customer->id)); ?>" onclick="return confirm('Hapus data ini?')"
                        class="btn-act btn-hapus flex-fill"
                        style="height:auto; padding:8px; width:auto; border-radius:8px;">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </a>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <p>Belum ada akun ditemukan. Coba sesuaikan kata kunci pencarian Anda.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo e($users->links('livewire.mobile-pagination')); ?>

    </div>

    
    <div wire:ignore.self class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-bottom-0 pb-0" style="padding: 24px 24px 10px;">
                    <h5 class="modal-title fw-bold" id="addUserModalLabel" style="font-size: 1.2rem; color: #1e293b;">
                        Tambah Pengguna Baru
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>

                <form wire:submit.prevent="registerUser">
                    <div class="modal-body" style="padding: 20px 24px;">

                        <div class="mb-3">
                            <label class="form-label" style="font-size: .85rem; font-weight: 600; color: #475569;">Nama
                                Lengkap</label>
                            <input type="text" class="form-control" wire:model="name" style="border-radius: 10px;"
                                placeholder="Masukkan nama pengguna">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger mt-1 d-block"
                            style="font-size: .75rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Email</label>
                                <input type="email" class="form-control" wire:model="email" style="border-radius: 10px;"
                                    placeholder="Alamat email">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Peran (Role)</label>
                                <select class="form-select" wire:model.live="role" style="border-radius: 10px;">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: .85rem; font-weight: 600; color: #475569;">Nomor
                                WhatsApp</label>
                            <input type="text" class="form-control" wire:model="phone" style="border-radius: 10px;"
                                placeholder="08xxxxxxxxxx">
                            <div class="form-text" style="font-size: .75rem;">Status Admin tidak wajib mengisi nomor WA.
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger mt-1 d-block"
                            style="font-size: .75rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Password</label>
                                <input type="password" class="form-control" wire:model="password"
                                    style="border-radius: 10px;" placeholder="Minimal 6 karakter">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Konfirmasi
                                    Password</label>
                                <input type="password" class="form-control" wire:model="password_confirmation"
                                    style="border-radius: 10px;" placeholder="Ulangi password">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer border-top-0" style="padding: 16px 24px 24px; gap: 10px;">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            style="border-radius: 10px; font-weight: 600; color: #64748b;"
                            wire:click="resetForm">Batal</button>
                        <button type="submit" class="btn btn-primary px-4"
                            style="border-radius: 10px; font-weight: 600; background-color: var(--honda-red); border-color: var(--honda-red);">
                            <span wire:loading.remove wire:target="registerUser"><i
                                    class="fas fa-save me-2"></i>Simpan</span>
                            <span wire:loading wire:target="registerUser">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
        <?php
        $__scriptKey = '3276382470-2';
        ob_start();
    ?>
    <script>
        $wire.on('user-registered', () => {
            var addModal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            if (addModal) {
                addModal.hide();
            }

            // Optional: show a toast or alert using sweetalert if you have it
            // alert('Pengguna berhasil didaftarkan!');
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\livewire\customer-table.blade.php ENDPATH**/ ?>