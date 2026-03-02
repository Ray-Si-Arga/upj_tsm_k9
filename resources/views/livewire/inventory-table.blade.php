<div @open-create-modal.window="$wire.create()">
    {{-- ==================== TABLE COMPONENT ==================== --}}
    <div class="table-card au d6 d-none d-md-block">
        <div class="table-header-bar">
            <div class="table-title">
                <i class="fas fa-list" style="color:#64748b;"></i>
                Daftar Inventori
                <span class="item-count">{{ $Inventory->total() }} item</span>
            </div>
            <span style="font-size:.78rem; color:#94a3b8; font-weight:500;">
                <i class="far fa-calendar me-1"></i>{{ date('d M Y') }}
            </span>
        </div>

        <div class="table-scroll" style="position: relative;">
            {{-- Loading Spinner hanya untuk event update tabel --}}
            <div wire:loading wire:target="updateSearch, updateFilter, gotoPage, nextPage, previousPage"
                wire:loading.class="d-flex"
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
                        <th>Nama Barang</th>
                        <th class="text-center">Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th class="text-center">Laba / Unit</th>
                        <th class="text-center">Potensi Total</th>
                        <th class="text-center" style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Inventory as $index => $data)
                        @php
                            $laba = $data->harga_jual - $data->harga_beli;
                            $totalLaba = $laba * $data->jumlah_barang;
                        @endphp
                        <tr>
                            <td class="row-num">{{ $Inventory->firstItem() + $index }}</td>

                            {{-- Nama --}}
                            <td>
                                <div class="item-name">{{ $data->nama_barang }}</div>
                                @if($data->jumlah_barang <= 6)
                                    <small class="text-danger"><i class="fas fa-circle-exclamation me-1"></i>Perlu
                                        restock</small>
                                @endif
                            </td>

                            {{-- Stok --}}
                            <td class="text-center">
                                @if($data->jumlah_barang == 0)
                                    <span class="stok-badge stok-tipis"><i class="fas fa-times-circle"></i>Habis</span>
                                @elseif($data->jumlah_barang <= 6)
                                    <span class="stok-badge stok-tipis"><i
                                            class="fas fa-triangle-exclamation"></i>{{ $data->jumlah_barang }} unit</span>
                                @elseif($data->jumlah_barang <= 15)
                                    <span class="stok-badge stok-warn"><i
                                            class="fas fa-minus-circle"></i>{{ $data->jumlah_barang }} unit</span>
                                @else
                                    <span class="stok-badge stok-ok"><i
                                            class="fas fa-check-circle"></i>{{ $data->jumlah_barang }} unit</span>
                                @endif
                            </td>

                            {{-- Harga Beli --}}
                            <td class="price-cell">
                                <span class="price-val price-beli">Rp
                                    {{ number_format($data->harga_beli, 0, ',', '.') }}</span>
                            </td>

                            {{-- Harga Jual --}}
                            <td class="price-cell">
                                <span class="price-val price-jual">Rp
                                    {{ number_format($data->harga_jual, 0, ',', '.') }}</span>
                            </td>

                            {{-- Laba per unit --}}
                            <td class="text-center">
                                <div class="laba-per">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                                <div class="laba-total">
                                    {{ round(($laba / max($data->harga_beli, 1)) * 100, 1) }}% margin
                                </div>
                            </td>

                            {{-- Potensi Total --}}
                            <td class="text-center">
                                <div class="laba-per" style="color:#059669;">Rp {{ number_format($totalLaba, 0, ',', '.') }}
                                </div>
                                <div class="laba-total">{{ $data->jumlah_barang }} × Rp
                                    {{ number_format($laba, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button wire:click="edit({{ $data->id }})" data-bs-toggle="modal"
                                        data-bs-target="#formModal" class="btn-act btn-edit" title="Edit">
                                        <i class="fas fa-pencil"></i>
                                    </button>
                                    <button wire:click="delete({{ $data->id }})"
                                        wire:confirm="Hapus barang '{{ $data->nama_barang }}'?" class="btn-act btn-hapus"
                                        title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <p>Belum ada data inventori.</p>
                                    @if(empty($search))
                                        <button wire:click="create" data-bs-toggle="modal" data-bs-target="#formModal"
                                            class="btn-add mt-2">
                                            Tambah Sekarang
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            {{ $Inventory->links('livewire.custom-pagination') }}
        </div>
    </div>

    {{-- ==================== MOBILE CARDS ==================== --}}
    <div class="d-md-none au d6 position-relative bg-white p-3 rounded-4 shadow-sm border"
        style="border-color: #e2e8f0;">
        <div wire:loading wire:target="updateSearch, updateFilter, gotoPage, nextPage, previousPage"
            wire:loading.class="d-flex" class="position-absolute w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 10; border-radius: 1rem;">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="mb-3 fw-bold text-dark" style="font-size: 0.95rem;">
            <i class="fas fa-list text-muted me-2"></i>Daftar Inventori
        </div>

        @forelse ($Inventory as $index => $data)
            @php
                $laba = $data->harga_jual - $data->harga_beli;
                $totalLaba = $laba * $data->jumlah_barang;
            @endphp
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div>
                        <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                        <small class="text-muted">#{{ $Inventory->firstItem() + $index }}</small>
                    </div>
                    @if($data->jumlah_barang <= 6)
                        <span class="stok-badge stok-tipis"><i
                                class="fas fa-triangle-exclamation"></i>{{ $data->jumlah_barang }} unit</span>
                    @elseif($data->jumlah_barang <= 15)
                        <span class="stok-badge stok-warn">{{ $data->jumlah_barang }} unit</span>
                    @else
                        <span class="stok-badge stok-ok"><i class="fas fa-check-circle"></i>{{ $data->jumlah_barang }}
                            unit</span>
                    @endif
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 rounded-3" style="background:#fef2f2;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Harga
                                Beli</div>
                            <div style="font-weight:800; color:#b91c1c; font-size:.88rem;">Rp
                                {{ number_format($data->harga_beli, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded-3" style="background:#f0fdf4;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Harga
                                Jual</div>
                            <div style="font-weight:800; color:#15803d; font-size:.88rem;">Rp
                                {{ number_format($data->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded-3" style="background:#eff6ff;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Laba /
                                Unit</div>
                            <div style="font-weight:800; color:#1d4ed8; font-size:.88rem;">Rp
                                {{ number_format($laba, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded-3" style="background:#f0fdf4;">
                            <div style="font-size:.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Potensi
                                Total</div>
                            <div style="font-weight:800; color:#059669; font-size:.88rem;">Rp
                                {{ number_format($totalLaba, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button wire:click="edit({{ $data->id }})" data-bs-toggle="modal" data-bs-target="#formModal"
                        class="btn-act btn-edit flex-fill justify-content-center"
                        style="width:auto; height:auto; padding:8px;">
                        <i class="fas fa-pencil me-1"></i> Edit
                    </button>
                    <button wire:click="delete({{ $data->id }})" wire:confirm="Hapus barang ini?"
                        class="btn-act btn-hapus flex-fill"
                        style="height:auto; padding:8px; width:auto; border-radius:8px;">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Belum ada data inventori mencocokkan pencarian Anda.</p>
            </div>
        @endforelse

        {{-- Gunakan template pagination praktis khusus mobile --}}
        {{ $Inventory->links('livewire.mobile-pagination') }}
    </div>

    <style>
        /* Styling Font dan Warna Label */
        form label,
        form .input-group-text,
        .modal-title {
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
            font-size: medium !important;
            /* Warna teks label jadi Merah Gelap */
            font-weight: 500;
        }

        /* Styling Tombol Batal (Hitam) */
        .btn-hitam {
            background-color: #1a1a1a !important;
            color: white !important;
            border: none;
            transition: 0.3s;
        }

        .btn-hitam:hover {
            background-color: #000000 !important;
            transform: translateY(-1px);
        }

        /* Styling Tombol Simpan (Merah) */
        .btn-simpan-merah {
            background-color: #8B0000 !important;
            color: white !important;
            border: none;
            transition: 0.3s;
        }

        .btn-simpan-merah:hover {
            background-color: #B10000 !important;
            transform: translateY(-1px);
        }

        .form-control:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.1);
        }
    </style>

    <!-- Modal Bootstrap -->
    <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: 900" class="modal-title" id="formModalLabel">
                        {{ $inventory_id ? 'Edit Barang' : 'Tambah Barang' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body position-relative">
                    <div wire:loading wire:target="edit, create" wire:loading.class="d-flex"
                        class="position-absolute w-100 h-100 top-0 start-0 justify-content-center align-items-center"
                        style="background: rgba(255,255,255,0.8); z-index: 10;">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control"
                                placeholder="Contoh: Oli Mesin MPX 2">
                            @error('nama_barang') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Stok Barang</label>
                            <input type="number" wire:model="jumlah_barang" class="form-control" placeholder="0"
                                min="0">
                            @error('jumlah_barang') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" wire:model="harga_beli" class="form-control" placeholder="0"
                                    min="0">
                            </div>
                            @error('harga_beli') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" wire:model="harga_jual" class="form-control" placeholder="0"
                                    min="0">
                            </div>
                            @error('harga_jual') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-hitam" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-simpan-merah">
                                <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"
                                    role="status" aria-hidden="true"></span>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>