@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mulai Konsultasi Medis</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Konsultasikan keluhan kesehatan Anda dengan dokter spesialis terpercaya
            </p>
            <div class="mt-4 flex flex-wrap justify-center gap-4 text-sm text-blue-600">
                <span class="flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Rahasia Terjaga
                </span>
                <span class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Respon Cepat
                </span>
                <span class="flex items-center">
                    <i class="fas fa-user-md mr-2"></i>
                    Dokter Spesialis
                </span>
            </div>
        </div>

        <!-- Error Alert -->
        @if(session('error'))
            <div class="mb-8">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 p-6 rounded-r-lg shadow-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-2xl mt-1"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-red-800">Perhatian</h3>
                            <div class="mt-2 text-red-700">
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Consultation Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-5">
                        <i class="fas fa-stethoscope text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Formulir Konsultasi</h2>
                        <p class="text-blue-100 mt-1">Isi data berikut untuk memulai konsultasi</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                <form action="{{ route('chat.store') }}" method="POST" id="consultationForm">
                    @csrf

                    <!-- Specialization Selection -->
                    <div class="mb-10">
                        <label for="spesialisasi" class="block mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-user-md text-blue-600"></i>
                                </div>
                                <div>
                                    <span class="text-lg font-bold text-gray-900">Pilih Spesialisasi Dokter</span>
                                    <p class="text-gray-600 text-sm mt-1">Pilih sesuai dengan keluhan Anda</p>
                                </div>
                            </div>
                        </label>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-filter text-gray-400"></i>
                            </div>
                            <select name="spesialisasi" id="spesialisasi" 
                                    class="pl-12 w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white text-gray-900 text-lg transition-all duration-200 hover:border-blue-400"
                                    required>
                                <option value="" class="text-gray-500">-- Pilih Spesialisasi --</option>
                                @foreach($spesialisasi as $sp)
                                    <option value="{{ $sp }}" {{ old('spesialisasi') == $sp ? 'selected' : '' }}>
                                        {{ $sp }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        
                        @error('spesialisasi')
                            <div class="mt-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center text-red-700">
                                    <i class="fas fa-exclamation-triangle mr-3"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <!-- Message Input -->
                    <div class="mb-10">
                        <label for="message" class="block mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-comment-dots text-green-600"></i>
                                </div>
                                <div>
                                    <span class="text-lg font-bold text-gray-900">Tulis Pertanyaan/Keluhan</span>
                                    <p class="text-gray-600 text-sm mt-1">Jelaskan kondisi kesehatan Anda secara detail</p>
                                </div>
                            </div>
                        </label>
                        
                        <div class="relative">
                            <textarea name="message" id="message" rows="6"
                                      class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-lg resize-none transition-all duration-200 hover:border-blue-400"
                                      placeholder="Contoh: Saya mengalami demam selama 3 hari dengan suhu 38°C, disertai batuk dan pilek. Sudah minum obat penurun panas tetapi belum membaik."
                                      required>{{ old('message') }}</textarea>
                            
                            <!-- Character Counter -->
                            <div class="absolute bottom-3 right-3 text-sm text-gray-500" id="charCounter">
                                <span id="charCount">0</span>/1000 karakter
                            </div>
                        </div>
                        
                        <!-- Tips -->
                        <div class="mt-3 bg-blue-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Tips menulis keluhan:</p>
                                    <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                                        <li>Sebutkan gejala utama yang dirasakan</li>
                                        <li>Sebutkan sudah berapa lama gejala berlangsung</li>
                                        <li>Sebutkan obat yang sudah dikonsumsi (jika ada)</li>
                                        <li>Sebutkan riwayat penyakit yang pernah dimiliki</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        @error('message')
                            <div class="mt-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center text-red-700">
                                    <i class="fas fa-exclamation-triangle mr-3"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                            <div class="order-2 sm:order-1">
                                <a href="{{ route('chat.history') }}" 
                                   class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-xl transition-all duration-200 hover:scale-105">
                                    <i class="fas fa-history mr-3"></i>
                                    Lihat Riwayat Konsultasi
                                </a>
                            </div>
                            
                            <div class="order-1 sm:order-2">
                                <button type="submit" 
                                        id="submitBtn"
                                        class="inline-flex items-center px-8 py-4 bg-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-xl shadow-lg w-full sm:w-auto justify-center">
                                    <i class="fas fa-paper-plane mr-3"></i>
                                    Mulai Konsultasi Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Consultation Benefits -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-center text-gray-900 mb-8">Manfaat Konsultasi Online</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-3">24/7 Tersedia</h4>
                    <p class="text-gray-600">
                        Konsultasi kapan saja, di mana saja tanpa perlu antre. Dokter siap membantu Anda 24 jam sehari.
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-3">Privasi Terjaga</h4>
                    <p class="text-gray-600">
                        Data dan percakapan Anda dienkripsi dan dijaga kerahasiaannya. Hanya Anda dan dokter yang tahu.
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-file-prescription text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-3">Rekomendasi Obat</h4>
                    <p class="text-gray-600">
                        Dapatkan resep dan rekomendasi obat yang tepat sesuai diagnosis dokter.
                    </p>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Konfirmasi Konsultasi</h3>
                <p class="text-gray-600 mb-6">
                    Anda akan memulai konsultasi dengan dokter spesialis 
                    <span id="selectedSpecialist" class="font-bold text-blue-600"></span>.
                    Pastikan keluhan Anda sudah ditulis dengan lengkap.
                </p>
                <div class="flex gap-4">
                    <button onclick="closeModal()"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition-colors">
                        Kembali Edit
                    </button>
                    <button onclick="submitForm()"
                            class="flex-1 px-4 py-3 bg-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-colors">
                        Ya, Mulai Konsultasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom select styling */
select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em;
    padding-right: 3rem;
}

/* Remove default arrow in IE */
select::-ms-expand {
    display: none;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Textarea focus effect */
textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Character counter styling */
#charCounter {
    background: white;
    padding: 2px 8px;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

#confirmationModal > div {
    animation: modalSlideIn 0.3s ease-out;
}

/* Hover effects for cards */
.bg-white.rounded-2xl {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.bg-white.rounded-2xl:hover {
    transform: translateY(-4px);
}

/* Gradient border effect */
.border-2.border-gray-300:focus {
    border-image: linear-gradient(to right, #3b82f6, #8b5cf6) 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const charCounter = document.getElementById('charCounter');
    
    if (messageTextarea && charCount) {
        messageTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            // Change color based on length
            if (length > 800) {
                charCounter.classList.remove('text-gray-500');
                charCounter.classList.add('text-yellow-600');
            } else if (length > 900) {
                charCounter.classList.remove('text-yellow-600');
                charCounter.classList.add('text-red-600');
            } else {
                charCounter.classList.remove('text-yellow-600', 'text-red-600');
                charCounter.classList.add('text-gray-500');
            }
        });
        
        // Initialize count
        charCount.textContent = messageTextarea.value.length;
    }
    
    // Form submission with confirmation
    const consultationForm = document.getElementById('consultationForm');
    const submitBtn = document.getElementById('submitBtn');
    const confirmationModal = document.getElementById('confirmationModal');
    const selectedSpecialist = document.getElementById('selectedSpecialist');
    const specialistSelect = document.getElementById('spesialisasi');
    
    if (consultationForm) {
        consultationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const specialist = specialistSelect.value;
            if (!specialist) {
                specialistSelect.focus();
                return;
            }
            
            // Show confirmation modal
            selectedSpecialist.textContent = specialist;
            confirmationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Auto-focus message textarea if specialist is selected
    if (specialistSelect) {
        specialistSelect.addEventListener('change', function() {
            if (this.value && messageTextarea) {
                setTimeout(() => {
                    messageTextarea.focus();
                }, 300);
            }
        });
    }
    
    // Add loading state to submit button
    if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.addEventListener('click', function() {
            // Button loading state will be handled by form submission
        });
    }
});

function closeModal() {
    const modal = document.getElementById('confirmationModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function submitForm() {
    const form = document.getElementById('consultationForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Memproses...';
    submitBtn.disabled = true;
    
    // Submit form
    form.submit();
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('confirmationModal');
    if (e.target === modal) {
        closeModal();
    }
});

// Form validation hints
const formFields = document.querySelectorAll('input, select, textarea');
formFields.forEach(field => {
    field.addEventListener('blur', function() {
        if (!this.value && this.required) {
            this.classList.add('border-red-300');
            this.classList.remove('hover:border-blue-400');
        } else {
            this.classList.remove('border-red-300');
            this.classList.add('hover:border-blue-400');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.value) {
            this.classList.remove('border-red-300');
        }
    });
});

// Specialization select enhancement
const specializationSelect = document.getElementById('spesialisasi');
if (specializationSelect) {
    specializationSelect.addEventListener('focus', function() {
        this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
    });
    
    specializationSelect.addEventListener('blur', function() {
        this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
    });
}
</script>
@endsection