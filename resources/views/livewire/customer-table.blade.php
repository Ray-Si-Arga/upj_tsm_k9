<div>
    {{-- ==================== TABLE COMPONENT ==================== --}}
    <div class="table-card au d6 d-none d-md-block">
        <div class="table-header-bar">
            <div class="table-title">
                <i class="fas fa-address-book" style="color:#64748b;"></i>
                Daftar Akun
                <span class="item-count">{{ $users->total() }} akun</span>
            </div>
            <span style="font-size:.78rem; color:#94a3b8; font-weight:500;">
                <i class="far fa-calendar me-1"></i>{{ date('d M Y') }}
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
                    @forelse ($users as $index => $customer)
                        <tr>
                            <td class="row-num">{{ $users->firstItem() + $index }}</td>

                            <td>
                                <div class="item-name">{{ $customer->name }}</div>
                            </td>

                            <td>
                                <div class="price-row">
                                    <i class="fas fa-phone-alt price-label"></i>
                                    <span class="price-val"
                                        style="background:#f8fafc; color:#64748b;">{{ $customer->phone ?? '-' }}</span>
                                </div>
                                <div class="price-row">
                                    <i class="fas fa-envelope price-label"></i>
                                    <span class="price-val"
                                        style="background:#f8fafc; color:#64748b;">{{ Str::limit($customer->email, 40) }}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                @if($customer->role == 'admin')
                                    <span class="stok-badge stok-tipis"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                @else
                                    <span class="stok-badge stok-ok"><i class="fas fa-user me-1"></i>Customer</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="stok-badge" style="background:#e0f2fe; color:#0284c7;">
                                    <i class="fas fa-history me-1"></i>{{ $customer->bookings->count() }} Transaksi
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if ($customer->bookings->isNotEmpty())
                                        <a href="{{ route('customers.bookings', ['id' => $customer->id]) }}"
                                            class="btn-act btn-edit" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        <button class="btn-act" disabled title="Belum ada riwayat"
                                            style="background:#f1f5f9; color:#94a3b8; border-color:#e2e8f0;">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('hapus', $customer->id) }}"
                                        onclick="return confirm('Hapus data ini?')" class="btn-act btn-hapus" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <p>Belum ada akun ditemukan. Coba sesuaikan kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            {{ $users->links('livewire.custom-pagination') }}
        </div>
    </div>

    {{-- ==================== MOBILE CARDS ==================== --}}
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

        @forelse ($users as $index => $customer)
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: .95rem;">{{ $customer->name }}</div>
                        <small class="text-muted" style="font-size: .8rem;">#{{ $users->firstItem() + $index }}</small>
                    </div>
                    @if($customer->role == 'admin')
                        <span class="stok-badge stok-tipis"><i class="fas fa-user-shield me-1"></i>Admin</span>
                    @else
                        <span class="stok-badge stok-ok"><i class="fas fa-user me-1"></i>Customer</span>
                    @endif
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <div class="p-2 rounded-3" style="background:#f8fafc;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Kontak
                            </div>
                            <div style="font-weight:700; color:#475569; font-size:.85rem;">
                                <i class="fas fa-phone-alt me-1" style="color:#94a3b8;"></i>{{ $customer->phone ?? '-' }}
                                <br>
                                <i class="fas fa-envelope me-1"
                                    style="color:#94a3b8; margin-top:5px;"></i>{{ Str::limit($customer->email, 30) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-2 rounded-3 d-flex justify-content-between align-items-center"
                            style="background:#e0f2fe; border: 1px solid rgba(2, 132, 199, .14);">
                            <div style="font-size:.7rem; color:#0284c7; font-weight:700; text-transform:uppercase;">
                                Riwayat Transaksi</div>
                            <div style="font-weight:800; color:#0284c7; font-size:.85rem;">
                                <i class="fas fa-history me-1"></i>{{ $customer->bookings->count() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    @if ($customer->bookings->isNotEmpty())
                        <a href="{{ route('customers.bookings', ['id' => $customer->id]) }}" class="btn-act btn-edit flex-fill"
                            style="height:auto; padding:8px; width:auto; border-radius:8px;">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                    @else
                        <button class="btn btn-act flex-fill" disabled
                            style="height:auto; padding:8px; width:auto; border-radius:8px; background:#f1f5f9; color:#94a3b8; font-weight:600;">
                            <i class="fas fa-ban me-1"></i> Belum ada
                        </button>
                    @endif
                    <a href="{{ route('hapus', $customer->id) }}" onclick="return confirm('Hapus data ini?')"
                        class="btn-act btn-hapus flex-fill"
                        style="height:auto; padding:8px; width:auto; border-radius:8px;">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <p>Belum ada akun ditemukan. Coba sesuaikan kata kunci pencarian Anda.</p>
            </div>
        @endforelse

        {{ $users->links('livewire.mobile-pagination') }}
    </div>

    {{-- ==================== MODAL TAMBAH PENGGUNA ==================== --}}
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
                            @error('name') <span class="text-danger mt-1 d-block"
                            style="font-size: .75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Email</label>
                                <input type="email" class="form-control" wire:model="email" style="border-radius: 10px;"
                                    placeholder="Alamat email">
                                @error('email') <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Peran (Role)</label>
                                <select class="form-select" wire:model.live="role" style="border-radius: 10px;">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('role') <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: .85rem; font-weight: 600; color: #475569;">Nomor
                                WhatsApp</label>
                            <input type="text" class="form-control" wire:model="phone" style="border-radius: 10px;"
                                placeholder="08xxxxxxxxxx">
                            <div class="form-text" style="font-size: .75rem;">Status Admin tidak wajib mengisi nomor WA.
                            </div>
                            @error('phone') <span class="text-danger mt-1 d-block"
                            style="font-size: .75rem;">{{ $message }}</span> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    style="font-size: .85rem; font-weight: 600; color: #475569;">Password</label>
                                <input type="password" class="form-control" wire:model="password"
                                    style="border-radius: 10px;" placeholder="Minimal 6 karakter">
                                @error('password') <span class="text-danger mt-1 d-block"
                                style="font-size: .75rem;">{{ $message }}</span> @enderror
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

    {{-- Script for handling modal behavior --}}
    @script
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
    @endscript
</div>