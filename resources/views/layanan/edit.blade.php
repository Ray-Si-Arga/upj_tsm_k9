@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-warning">Edit Layanan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('layanan.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Layanan</label>
                            <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipe Layanan</label>
                            <select name="type" id="typeSelect" class="form-select" required onchange="toggleDescription()">
                                <option value="non_paket" {{ $service->type == 'non_paket' ? 'selected' : '' }}>Layanan Satuan</option>
                                <option value="paket" {{ $service->type == 'paket' ? 'selected' : '' }}>Paket Spesial</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ $service->price }}" required>
                        </div>

                        <div class="mb-4 {{ $service->type == 'non_paket' ? 'd-none' : '' }}" id="descriptionBox">
                            <label class="form-label fw-bold">Deskripsi Paket</label>
                            <textarea name="description" class="form-control" rows="3">{{ $service->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('layanan.index') }}" class="btn btn-light">Batal</a>
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
</script>
@endsection