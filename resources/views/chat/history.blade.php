@extends('app')

@section('breadcrumb', 'Riwayat Chat Konsultasi')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center justify-between mt-8">
    <h2 class="text-2xl font-bold text-gray-800">Riwayat Konsultasi</h2>

    <a href="{{ route('chat.create') }}" 
       class="button bg-theme-1 text-white shadow-md hover:bg-theme-9 transition mt-4 sm:mt-0 inline-flex items-center px-6 py-3">
        <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i>
        Konsultasi Baru
    </a>
</div>

<div class="intro-y box mt-8 p-5">
    @if($conversations->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($conversations as $conv)
            <a href="{{ route('chat.show', $conv->id) }}"
               class="block p-6 hover:bg-gray-50 transition rounded-lg border border-transparent hover:border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="w-12 h-12 image-fit rounded-full overflow-hidden mr-4 shadow-lg ring-2 ring-white">
                            @if($conv->nakes->profile && $conv->nakes->profile->foto)
                                <img src="{{ asset('storage/nakes_photos/' . $conv->nakes->profile->foto) }}"
                                     alt="{{ $conv->nakes->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <!-- Fallback kalau belum ada foto -->
                                <div class="w-full h-full bg-gradient-to-br from-theme-9 to-theme-12 flex items-center justify-center">
                                    <i data-feather="user" class="w-6 h-6 text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-lg">
                                Dr. {{ $conv->nakes->name ?? 'Tenaga Kesehatan' }}
                                <span class="text-sm font-normal text-gray-600 ml-2">
                                    ({{ $conv->nakes->profile->spesialisasi ?? 'Spesialisasi tidak tersedia' }})
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                @if($conv->messages->first())
                                    {{ Str::limit($conv->messages->first()->message, 80) }}
                                @else
                                    Belum ada pesan
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <div>{{ $conv->updated_at->format('d M Y') }}</div>
                        <div>{{ $conv->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <i data-feather="message-circle" class="w-24 h-24 text-gray-300 mx-auto"></i>
            <h3 class="mt-6 text-xl font-medium text-gray-600">Belum Ada Riwayat Konsultasi</h3>
            <p class="mt-3 text-gray-500 max-w-md mx-auto">
                Anda belum pernah melakukan konsultasi. Mulai sekarang untuk mendapatkan saran kesehatan dari dokter kami.
            </p>
            <a href="{{ route('chat.create') }}" class="button bg-theme-1 text-white mt-8 inline-flex">
                <i data-feather="plus" class="w-5 h-5 mr-2"></i> Mulai Konsultasi
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    feather.replace();
</script>
@endpush