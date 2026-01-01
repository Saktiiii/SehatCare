@extends('app')
@section('breadcrumb')
    Cari Obat
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Cari Obat</h1>
                    <p class="text-gray-600 mt-1">Temukan obat yang Anda butuhkan dengan mudah</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-pills mr-2"></i>
                     obat tersedia
                </div>
            </div>
        </div>

        <!-- Search and Filter Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" class="space-y-4 md:space-y-0 md:grid md:grid-cols-12 md:gap-4">
                <!-- Search Input -->
                <div class="md:col-span-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama obat, kandungan, atau kegunaan..."
                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="md:col-span-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                        <select name="kategori" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}"
                                    {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="md:col-span-2">
                    <button type="submit" 
                            class="w-full h-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </form>

            <!-- Active Filters -->
            @if(request('search') || request('kategori'))
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-600">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                {{ request('search') }}
                                <a href="{{ request()->fullUrlWithoutQuery('search') }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('kategori'))
                            @php
                                $selectedKategori = $kategori->firstWhere('id', request('kategori'));
                            @endphp
                            @if($selectedKategori)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                    {{ $selectedKategori->nama_kategori }}
                                    <a href="{{ request()->fullUrlWithoutQuery('kategori') }}" class="ml-2 text-green-600 hover:text-green-800">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Results Section -->
        @if($obat->count() > 0)
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($obat as $o)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <!-- Medicine Image -->
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <img src="{{ $o->foto ? asset('storage/'.$o->foto) : asset('images/no-image.png') }}"
                                 alt="{{ $o->nama_obat }}"
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $o->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $o->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $o->kategori->nama_kategori }}
                                </span>
                            </div>
                        </div>

                        <!-- Medicine Info -->
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-800 text-lg mb-2 truncate" title="{{ $o->nama_obat }}">
                                {{ $o->nama_obat }}
                            </h3>
                            
                            <!-- Price -->
                            <div class="mb-4">
                                <p class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format($o->harga,0,',','.') }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $o->stok }} unit tersedia
                                </p>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('pasien.obat.show', $o->id) }}"
                               class="block w-full text-center py-3 px-4 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-info-circle mr-2"></i>
                                Detail Obat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($obat->hasPages())
                <div class="mt-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                        {{ $obat->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-pills text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Obat tidak ditemukan</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Maaf, kami tidak dapat menemukan obat yang sesuai dengan pencarian Anda.
                    Coba kata kunci lain atau hapus filter yang diterapkan.
                </p>
                <a href="{{ route('pasien.obat.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Reset Pencarian
                </a>
            </div>
        @endif

        <!-- Info Section -->
        <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-medium text-blue-800 mb-2">Informasi Penting</h4>
                    <p class="text-blue-700 text-sm">
                        <i class="fas fa-check-circle mr-2"></i>
                        Semua obat yang tercantum telah terdaftar BPOM dan memiliki izin edar.
                        Konsultasikan dengan dokter atau apoteker sebelum menggunakan obat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom select arrow hiding */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

/* Pagination styling */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 2px;
}

.pagination li a,
.pagination li span {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    color: #4b5563;
    border: 1px solid #d1d5db;
    transition: all 0.2s;
}

.pagination li.active span {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.pagination li a:hover {
    background-color: #f3f4f6;
}

.pagination li.disabled span {
    color: #9ca3af;
    border-color: #e5e7eb;
    cursor: not-allowed;
}

/* Image hover effect */
img {
    backface-visibility: hidden;
    transform: translateZ(0);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && !searchInput.value) {
        setTimeout(() => {
            searchInput.focus();
        }, 300);
    }

    // Add smooth scroll to top when paginating
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            
            // Smooth scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Navigate after scroll
            setTimeout(() => {
                window.location.href = href;
            }, 500);
        });
    });

    // Filter chips removal
    const filterChips = document.querySelectorAll('.inline-flex.items-center a');
    filterChips.forEach(chip => {
        chip.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.getAttribute('href');
        });
    });
});
</script>
@endsection