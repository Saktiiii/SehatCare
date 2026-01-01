@extends('app')
@section('breadcrumb')
Data Kategori Obat
@endsection

@section('content')
<div class="content">

    <!-- HEADER -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Data Kategori
        </h2>

        <a href="javascript:;"
           data-toggle="modal"
           data-target="#modal-tambah-kategori"
           class="button text-white bg-theme-1 shadow-md">
            + Tambah Kategori
        </a>
    </div>

        <!-- TABLE KATEGORI -->
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
    
                <tbody>
                    @foreach($kategori as $k)
                    <tr>
                        <td>
                            <div class="font-medium">{{ $k->nama_kategori }}</div>
                        </td>
    
                        <td class="text-center">
                            <form action="{{ route('kategori.destroy', $k->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
    
                                <button type="submit"
                                        class="text-theme-6 font-medium bg-transparent border-0 p-0">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</div>

<!-- MODAL TAMBAH KATEGORI -->
<div class="modal" id="modal-tambah-kategori">
    <div class="modal__content p-8">

        <h2 class="text-lg font-medium mb-4">
            Tambah Kategori
        </h2>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label">Nama Kategori</label>
                <input type="text"
                       name="nama_kategori"
                       class="input w-full border mt-2"
                       placeholder="Masukkan nama kategori"
                       required>
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
