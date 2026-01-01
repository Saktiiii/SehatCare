@extends('app')

@section('breadcrumb', 'Profil Nakes')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-2xl font-bold mr-auto">Profil Tenaga Kesehatan</h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
    <!-- Sidebar Profil -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
        <div class="intro-y box p-5">
            <div class="flex flex-col items-center text-center">
                <div class="w-32 h-32 image-fit rounded-full overflow-hidden shadow-lg mx-auto">
                    @if($profile?->foto)
                        <img src="{{ asset('storage/nakes_photos/' . $profile->foto) }}"
                             alt="Foto Profil" class="rounded-full">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full">
                            <i data-feather="user" class="w-16 h-16 text-gray-500"></i>
                        </div>
                    @endif
                </div>
                <div class="mt-5">
                    <div class="text-xl font-bold">{{ Auth::user()->name }}</div>
                    <div class="text-gray-600 mt-1">{{ $profile->spesialisasi ?? 'Tenaga Kesehatan' }}</div>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-6 pt-6">
                <a href="{{ route('nakes.profile.edit') }}"
                   class="flex items-center justify-center text-theme-1 font-medium hover:text-theme-9 transition">
                    <i data-feather="edit-3" class="w-5 h-5 mr-3"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Detail Profil -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="intro-y box p-5">
            @if(session('success'))
                <div class="alert alert-success show mb-5">
                    <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($profile)
                <div class="space-y-6">
                    <div>
                        <label class="form-label font-medium">Alamat Praktek</label>
                        <p class="mt-2 text-gray-700">{{ $profile->alamat_praktek ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="form-label font-medium">Lulusan</label>
                        <p class="mt-2 text-gray-700">{{ $profile->lulusan ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="form-label font-medium">Spesialisasi</label>
                        <p class="mt-2 text-gray-700">{{ $profile->spesialisasi ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="form-label font-medium">Nomor Registrasi</label>
                        <p class="mt-2 text-gray-700">{{ $profile->nomor_registrasi ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="form-label font-medium">Pengalaman Kerja</label>
                        <p class="mt-2 text-gray-700 whitespace-pre-line">{!! $profile->pengalaman_kerja ? nl2br(e($profile->pengalaman_kerja)) : '-' !!}</p>
                    </div>
                </div>
            @else
                <div class="text-center py-10">
                    <i data-feather="user-x" class="w-16 h-16 text-gray-400 mx-auto"></i>
                    <p class="mt-4 text-gray-600">Profil belum dibuat.</p>
                    <a href="{{ route('nakes.profile.edit') }}" class="button bg-theme-1 text-white mt-4 inline-flex">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i> Buat Profil Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    feather.replace();
</script>
@endpush