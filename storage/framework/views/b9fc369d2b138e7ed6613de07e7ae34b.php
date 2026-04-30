<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-warning">Edit Layanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo e(route('layanan.update', $service->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Layanan</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e($service->name); ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe Layanan</label>
                                <select name="type" id="typeSelect" class="form-select" required
                                    onchange="toggleDescription()">
                                    <option value="non_paket" <?php echo e($service->type == 'non_paket' ? 'selected' : ''); ?>>Layanan
                                        Satuan</option>
                                    <option value="paket" <?php echo e($service->type == 'paket' ? 'selected' : ''); ?>>Paket Spesial
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>

                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="price_display" value="<?php echo e($service->price); ?>"
                                        class="form-control" placeholder="0" required onkeyup="formatRupiah(this)">
                                </div>
                                <input type="hidden" name="price" id="price_actual">
                            </div>

                            <div class="mb-4 <?php echo e($service->type == 'non_paket' ? 'd-none' : ''); ?>" id="descriptionBox">
                                <label class="form-label fw-bold">Deskripsi Paket</label>
                                <textarea name="description" class="form-control" rows="3"><?php echo e($service->description); ?></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('layanan.index')); ?>" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Update Layanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDescription() {
            var type = document.getElementById('typeSelect').value;
            var box = document.getElementById('descriptionBox');
            if (type === 'paket') {
                box.classList.remove('d-none');
            } else {
                box.classList.add('d-none');
            }
        }

        function formatRupiah(element) {
            // 1. Ambil value dari input tampilan
            let value = element.value;

            // 2. Hapus semua karakter selain angka (biar jadi angka murni)
            let number_string = value.replace(/[^,\d]/g, '').toString();

            // 3. Simpan angka murni ke input hidden (untuk dikirim ke server)
            document.getElementById('price_actual').value = number_string;

            // 4. Format tampilan jadi ada titiknya (Ribuan Indonesia)
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            // 5. Kembalikan tampilan yang sudah diformat ke input text
            element.value = rupiah;
        }

        // [OPSIONAL] Jika ini halaman EDIT, kita perlu format angka dari database saat loading
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil nilai lama (misal dari old('price') atau $service->price)
            // Ganti '0' di bawah dengan value dari backend
            let existingValue = "<?php echo e(old('price', $service->price ?? '')); ?>";

            if (existingValue) {
                let displayElement = document.getElementById('price_display');
                displayElement.value = existingValue;
                formatRupiah(displayElement); // Jalankan format sekali saat load
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/layanan/edit.blade.php ENDPATH**/ ?>