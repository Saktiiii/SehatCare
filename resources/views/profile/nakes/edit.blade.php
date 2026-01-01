{{-- resources/views/profile/nakes/edit.blade.php --}}

@extends('app') {{-- Ganti dengan nama layout utama Midone kamu jika berbeda --}}

@section('breadcrumb', 'Edit Profil Nakes')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-2xl font-bold mr-auto">Edit Profil Tenaga Kesehatan</h2>
    <div class="flex mt-4 sm:mt-0">
        <a href="{{ route('nakes.profile.show') }}" class="button bg-gray-200 text-gray-700 mr-2">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <div class="intro-y box p-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible show mb-6 flex items-center">
                    <i data-feather="check-circle" class="w-6 h-6 mr-3"></i>
                    <div class="flex-1">{{ session('success') }}</div>
                    <button class="ml-4" data-dismiss="alert">
                        <i data-feather="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            <!-- Form Edit Profil -->
            <form action="{{ route('nakes.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Foto Profil + Upload -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start border-b border-gray-200 pb-8 mb-8">
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 image-fit rounded-full overflow-hidden shadow-xl border-4 border-white">
                            @if($profile?->foto)
                                <img id="previewFoto" src="{{ asset('storage/nakes_photos/' . $profile->foto) }}"
                                     alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <div id="previewFoto" class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full">
                                    <i data-feather="user" class="w-16 h-16 text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="sm:ml-8 mt-6 sm:mt-0 text-center sm:text-left">
                        <label for="foto" class="button bg-theme-1 text-white inline-flex items-center cursor-pointer shadow-md">
                            <i data-feather="camera" class="w-4 h-4 mr-2"></i> Ganti Foto Profil
                        </label>
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/jpeg,image/png,image/gif" onchange="previewImage(event)">
                        
                        <p class="text-xs text-gray-600 mt-3">
                            Format: JPG, PNG, GIF • Maksimal 2MB
                        </p>

                        @error('foto')
                            <p class="text-theme-6 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-6">
                        <label class="form-label">Alamat Praktek</label>
                        <input type="text" name="alamat_praktek" class="input w-full border mt-2"
                               value="{{ old('alamat_praktek', $profile->alamat_praktek ?? '') }}"
                               placeholder="Contoh: Jl. Sudirman No. 123, Jakarta">
                        @error('alamat_praktek')
                            <div class="text-theme-6 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 lg:col-span-6">
                        <label class="form-label">Lulusan</label>
                        <input type="text" name="lulusan" class="input w-full border mt-2"
                               value="{{ old('lulusan', $profile->lulusan ?? '') }}"
                               placeholder="Contoh: Universitas Indonesia, Fakultas Kedokteran">
                        @error('lulusan')
                            <div class="text-theme-6 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 lg:col-span-6">
                        <label class="form-label">Spesialisasi</label>
                        <input type="text" name="spesialisasi" class="input w-full border mt-2"
                               value="{{ old('spesialisasi', $profile->spesialisasi ?? '') }}"
                               placeholder="Contoh: Dokter Umum, Apoteker, Ahli Gizi">
                        @error('spesialisasi')
                            <div class="text-theme-6 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12 lg:col-span-6">
                        <label class="form-label">Nomor Registrasi (STR/SIP)</label>
                        <input type="text" name="nomor_registrasi" class="input w-full border mt-2"
                               value="{{ old('nomor_registrasi', $profile->nomor_registrasi ?? '') }}"
                               placeholder="Contoh: 1234567890">
                        @error('nomor_registrasi')
                            <div class="text-theme-6 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="form-label">Pengalaman Kerja</label>
                        <textarea name="pengalaman_kerja" rows="6" class="input w-full border mt-2"
                                  placeholder="Ceritakan pengalaman kerja Anda, mulai dari yang terbaru...">{{ old('pengalaman_kerja', $profile->pengalaman_kerja ?? '') }}</textarea>
                        @error('pengalaman_kerja')
                            <div class="text-theme-6 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end mt-10">
                    <button type="submit" class="button bg-theme-1 text-white px-8 py-3 shadow-md hover:bg-theme-9 transition">
                        <i data-feather="save" class="w-5 h-5 mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview foto sebelum upload
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('previewFoto');
        output.src = reader.result;
        output.classList.remove('bg-gray-200', 'flex', 'items-center', 'justify-center');
        output.classList.add('w-full', 'h-full', 'object-cover');
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Refresh Feather icons
feather.replace();
</script>
@endpush