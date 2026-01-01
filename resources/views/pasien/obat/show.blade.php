@extends('app')
@section('breadcrumb')
    Cari Obat
@endsection
@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <!-- Medicine Header with Image -->
                <div class="md:flex">
                    <!-- Image Section -->
                    <div class="md:w-2/5 bg-gray-100 p-8 flex items-center justify-center">
                        <div class="relative w-full max-w-sm">
                            <img src="{{ $obat->foto ? asset('storage/' . $obat->foto) : asset('images/no-image.png') }}"
                                alt="{{ $obat->nama_obat }}"
                                class="w-full h-auto max-h-80 object-contain rounded-xl shadow-sm" id="medicine-image">

                            <!-- Stock Status Badge -->
                            <div class="absolute top-4 right-4">
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-semibold shadow-sm {{ $obat->stok > 0 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                    <i class="fas {{ $obat->stok > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                    {{ $obat->stok > 0 ? 'Tersedia' : 'Stok Habis' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="md:w-3/5 p-8">
                        <!-- Category Badge -->
                        <div class="mb-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-2"></i>
                                {{ $obat->kategori->nama_kategori }}
                            </span>
                        </div>

                        <!-- Medicine Name -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $obat->nama_obat }}</h1>

                        <!-- Price & Stock -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="text-3xl font-bold text-blue-600">
                                        Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-500 text-sm ml-2">/ unit</span>
                                </div>
                                <div class="text-right">
                                    <p
                                        class="text-lg font-medium {{ $obat->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <i class="fas fa-box-open mr-1"></i>
                                        Stok: {{ $obat->stok }} unit
                                    </p>
                                    <p class="text-sm text-gray-500">Updated {{ now()->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Deskripsi Obat
                            </h3>
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                @if($obat->deskripsi)
                                    <p class="text-gray-700 leading-relaxed">{{ $obat->deskripsi }}</p>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-info-circle text-gray-400 text-2xl mb-3"></i>
                                        <p class="text-gray-500">Deskripsi obat belum tersedia</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">

                            <!-- Kembali ke Daftar -->
                            <a href="{{ route('pasien.obat.index') }}" class="flex-1 inline-flex items-center justify-center
                                px-6 py-3
                                border-2 border-blue-600
                                text-blue-600 font-semibold
                                rounded-xl
                                hover:bg-blue-50
                                transition-all duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Daftar
                            </a>
                            <label class="form-label mt-4">Jumlah</label>
                            <input type="number" id="qty" min="1" max="{{ $obat->stok }}" value="1"
                                class="input w-32 border mt-2">


                            @if($obat->stok > 0)
                                <!-- Pesan Obat -->
                                <button type="button" onclick="orderMedicine()" class="flex-1 inline-flex items-center justify-center
                                            px-6 py-3
                                            bg-blue-600 hover:bg-blue-700
                                            text-white font-semibold
                                            rounded-xl
                                            transition-all duration-200
                                            shadow-md hover:shadow-lg">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Pesan Obat Sekarang
                                </button>

                            @else
                                <!-- Stok Habis -->
                                <button class="flex-1 inline-flex items-center justify-center
                                           px-6 py-3
                                           bg-blue-200 text-blue-400
                                           font-semibold
                                           rounded-xl
                                           cursor-not-allowed" disabled>
                                    <i class="fas fa-ban mr-2"></i>
                                    Stok Habis
                                </button>
                            @endif

                        </div>

                    </div>
                </div>

                <!-- Additional Information -->
                <div class="border-t border-gray-200">
                    <div class="p-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Informasi Tambahan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Usage Info -->
                            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                                <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-capsules mr-2"></i>
                                    Cara Penggunaan
                                </h4>
                                <p class="text-blue-700 text-sm leading-relaxed">
                                    Konsultasikan dengan dokter atau apoteker untuk dosis dan cara penggunaan yang tepat.
                                    Baca petunjuk pada kemasan sebelum digunakan.
                                </p>
                            </div>

                            <!-- Warning Info -->
                            <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                                <h4 class="font-semibold text-yellow-800 mb-3 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Peringatan
                                </h4>
                                <p class="text-yellow-700 text-sm leading-relaxed">
                                    Simpan di tempat kering dan sejuk, jauh dari jangkauan anak-anak.
                                    Hentikan penggunaan jika terjadi efek samping yang tidak diinginkan.
                                </p>
                            </div>
                        </div>

                        <!-- Consultation CTA -->
                        <div class="mt-8 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="mb-4 md:mb-0 md:mr-6">
                                    <h4 class="font-semibold text-blue-800 mb-1">Perlu Konsultasi?</h4>
                                    <p class="text-blue-700 text-sm">
                                        Konsultasikan dengan dokter sebelum menggunakan obat ini
                                    </p>
                                </div>
                                <a href="{{ route('chat.create') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-comment-medical mr-2"></i>
                                    Konsultasi Dokter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Medicines (Optional) -->
            @if(isset($relatedMedicines) && $relatedMedicines->count() > 0)
                <div class="mt-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-pills mr-2 text-blue-500"></i>
                        Obat Serupa
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedMedicines->take(3) as $related)
                            <a href="{{ route('pasien.obat.show', $related->id) }}"
                                class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-pills text-blue-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800 truncate">{{ $related->nama_obat }}</h4>
                                        <p class="text-sm text-blue-600 font-medium mt-1">
                                            Rp {{ number_format($related->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $related->kategori->nama_kategori }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Safety Information -->
            <div class="mt-10">
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <div class="flex items-center justify-center text-center">
                        <div class="flex-shrink-0 mr-4">
                            <i class="fas fa-shield-alt text-green-500 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium text-gray-800">Obat Terdaftar BPOM</span> •
                                Pastikan obat yang dibeli memiliki izin edar dan dalam kemasan asli
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="orderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Pemesanan</h3>
                <p class="text-gray-500 mb-6">
                    Anda akan memesan obat <span class="font-semibold text-blue-600">{{ $obat->nama_obat }}</span>
                    seharga <span class="font-semibold text-blue-600">Rp
                        {{ number_format($obat->harga, 0, ',', '.') }}</span>
                </p>
                <div class="flex gap-3">
                    <button onclick="closeModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button onclick="confirmOrder()"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Image zoom on hover */
        #medicine-image {
            transition: transform 0.3s ease;
        }

        #medicine-image:hover {
            transform: scale(1.02);
        }

        /* Smooth transitions */
        .bg-gradient-to-r {
            transition: all 0.3s ease;
        }

        /* Modal animation */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #orderModal>div {
            animation: modalFadeIn 0.3s ease-out;
        }

        /* Scrollbar styling */
        .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 transparent;
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 3px;
        }
    </style>

    <script>
        function orderMedicine() {
            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function confirmOrder() {
            // In a real application, you would submit a form here
            // For now, we'll simulate the process
            closeModal();

            // Show success notification
            showNotification('Pesanan berhasil dibuat!', 'success');

            // Simulate redirect to order page
            setTimeout(() => {
                // In real app: window.location.href = '/orders/create?medicine_id={{ $obat->id }}';
                console.log('Redirecting to order page for medicine ID: {{ $obat->id }}');
            }, 1500);
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
            notification.textContent = message;
            notification.style.transform = 'translateX(100%)';

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Close modal when clicking outside
        document.addEventListener('click', function (event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    <script>
        function orderMedicine() {
            const qty = document.getElementById('qty').value;

            if (qty < 1) {
                alert('Jumlah tidak valid');
                return;
            }

            const url = "{{ route('pasien.checkout') }}" +
                "?items[0][obat_id]={{ $obat->id }}" +
                "&items[0][nama]={{ $obat->nama_obat }}" +
                "&items[0][harga]={{ $obat->harga }}" +
                "&items[0][qty]=" + qty;

            window.location.href = url;
        }
    </script>

@endsection