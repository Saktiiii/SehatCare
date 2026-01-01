@extends('app')

@section('breadcrumb')
    Edit Obat
@endsection
@section('content')
    <div class="content">
        <!-- HEADER -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Edit Obat
            </h2>


        </div>
        <!-- FORM EDIT -->
        <div class="intro-y box p-12 mt-5 ">

            <form action="{{ route('obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                        class="input w-full border mt-2" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="input w-full border mt-2" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $obat->kategori_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" class="input w-full border mt-2"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}"
                        class="input w-full border mt-2" required>
                </div>

                <!-- Tambah Deskripsi -->
                <div class="mb-4">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="input w-full border mt-2"
                        placeholder="Deskripsi obat">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                </div>

                <!-- Tambah Foto -->
                <div class="mb-4">
                    <label class="form-label">Foto Obat</label>
                    <input type="file" name="foto" class="input w-full border mt-2" accept="image/*">
                    @if($obat->foto)
                        <img src="{{ asset('storage/' . $obat->foto) }}" alt="Foto Obat" class="mt-2" width="150">
                    @endif
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('obat.index') }}" class="button border">
                        Batal
                    </a>

                    <button type="submit" class="button bg-theme-1 text-white">
                        Update
                    </button>
                </div>
            </form>

        </div>

    </div>
@endsection