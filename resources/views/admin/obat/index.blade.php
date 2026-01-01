@extends('app')

@section('breadcrumb')
Data Obat
@endsection
@section('content')
<div class="content">

    <!-- HEADER -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Data Obat
        </h2>

        <a href="javascript:;"
           data-toggle="modal"
           data-target="#modal-tambah-obat"
           class="button text-white bg-theme-1 shadow-md">
            + Tambah Obat
        </a>
    </div>

    <!-- TABLE OBAT -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($obat as $o)
                <tr>
                    <td>
                        <div class="font-medium">{{ $o->nama_obat }}</div>
                    </td>

                    <td>{{ $o->kategori->nama_kategori }}</td>

                    <td class="text-center">{{ $o->stok }}</td>

                    <td class="text-right">
                        Rp {{ number_format($o->harga, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        <div class="flex justify-center items-center gap-4">
                    
                            <a href="{{ route('obat.edit', $o->id) }}"
                               class="text-theme-1 font-medium leading-none">
                                Edit
                            </a>
                    
                            <form action="{{ route('obat.destroy', $o->id) }}"
                                  method="POST"
                                  class=" m-0 p-0"
                                  onsubmit="return confirm('Yakin hapus obat ini?')">
                                @csrf
                                @method('DELETE')
                    
                                <button type="submit"
                                        class="text-theme-6 font-medium leading-none bg-transparent border-0 p-0">
                                    Delete
                                </button>
                            </form>
                    
                        </div>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL TAMBAH OBAT -->
<div class="modal" id="modal-tambah-obat">
    <div class="modal__content p-8">

        <h2 class="text-lg font-medium mb-4">
            Tambah Obat
        </h2>

        <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Obat</label>
                <input name="nama_obat"
                       class="input w-full border mt-2"
                       placeholder="Nama Obat"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id"
                        class="input w-full border mt-2"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number"
                       name="stok"
                       class="input w-full border mt-2"
                       placeholder="Stok"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Harga</label>
                <input type="number"
                       name="harga"
                       class="input w-full border mt-2"
                       placeholder="Harga"
                       required>
            </div>

            <!-- Tambah Deskripsi -->
            <div class="mb-4">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="input w-full border mt-2" placeholder="Deskripsi obat"></textarea>
            </div>

            <!-- Tambah Foto -->
            <div class="mb-4">
                <label class="form-label">Foto Obat</label>
                <input type="file" name="foto" class="input w-full border mt-2" accept="image/*">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        data-dismiss="modal"
                        class="button border">
                    Batal
                </button>

                <button type="submit"
                        class="button bg-theme-1 text-white">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
