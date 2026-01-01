@extends('app')
@section('breadcrumb')
    Dashboard
@endsection
@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                    <p class="text-gray-600 mt-1">Selamat datang, {{ Auth::user()->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ date('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Status Online Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Status Ketersediaan</h3>
                    <p class="text-gray-600 mt-1">Atur ketersediaan Anda untuk menerima chat pasien</p>
                </div>
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="status-online" 
                            class="sr-only peer"
                            {{-- {{ $statusOnline ? 'checked' : '' }} --}}
                        >
                        <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700" id="status-text">
                            {{-- {{ $statusOnline ? 'Online' : 'Offline' }} --}}
                        </span>
                    </label>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>
                    Status online memungkinkan pasien mengirim pesan kepada Anda
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Chat Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Chat</p>
                        <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $conversations->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-comments text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $conversations->where('updated_at', '>=', now()->subDay())->count() }} chat aktif hari ini
                    </span>
                </div>
            </div>

            <!-- Total Pasien Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                        <p class="text-2xl font-semibold text-gray-800 mt-2">
                            {{ $conversations->unique('pasien_id')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-user-plus mr-1"></i>
                        Pasien aktif
                    </span>
                </div>
            </div>

            <!-- Pesan Hari Ini Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pesan Hari Ini</p>
                        @php
                            $todayMessages = 0;
                            foreach ($conversations as $conversation) {
                                $todayMessages += $conversation->messages->where('created_at', '>=', today())->count();
                            }
                        @endphp
                        <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $todayMessages }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-calendar-day mr-1"></i>
                        {{ date('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Daftar Chat Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Section Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Chat</h2>
                    <span class="text-sm text-gray-500">{{ $conversations->count() }} percakapan</span>
                </div>
            </div>

            <!-- Chat List -->
            <div class="divide-y divide-gray-100">
                @forelse ($conversations as $conversation)
                    @php
                        $lastMessage = $conversation->messages->last();
                        $unreadCount = $conversation->messages->where('read_at', null)
                            ->where('sender_id', '!=', Auth::id())->count();
                    @endphp
                    <a 
                        href="{{ route('chat.show', $conversation->id) }}" 
                        class="block hover:bg-gray-50 transition-colors duration-150"
                    >
                        <div class="px-6 py-4">
                            <div class="flex items-start">
                                <!-- Avatar -->
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-800 truncate">
                                                {{ $conversation->pasien->name }}
                                            </h3>
                                            @if($lastMessage)
                                                <p class="text-sm text-gray-600 mt-1 truncate">
                                                    {{ $lastMessage->message }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Belum ada pesan
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex flex-col items-end ml-4">
                                            @if($lastMessage)
                                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                                    {{ $lastMessage->created_at->format('H:i') }}
                                                </span>
                                            @endif
                                            @if($unreadCount > 0)
                                                <span class="mt-2 bg-blue-600 text-white text-xs rounded-full px-2 py-1">
                                                    {{ $unreadCount }} baru
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Info -->
                                    <div class="flex items-center mt-3 space-x-4">
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <i class="fas fa-comment-alt mr-1"></i>
                                            {{ $conversation->messages->count() }} pesan
                                        </span>
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $conversation->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- Empty State -->
                    <div class="px-6 py-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-comments text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada chat</h3>
                        <p class="text-gray-500 max-w-sm mx-auto">
                            Anda belum memiliki percakapan dengan pasien. Status online akan memungkinkan pasien menghubungi Anda.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bottom Info -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                <i class="fas fa-shield-alt mr-1"></i>
                Semua percakapan dienkripsi untuk keamanan data pasien
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusToggle = document.getElementById('status-online');
    const statusText = document.getElementById('status-text');
    
    statusToggle.addEventListener('change', function() {
        const isOnline = this.checked;
        
        // Update text
        statusText.textContent = isOnline ? 'Online' : 'Offline';
        
        // Send request to server
        fetch('{{ route('nakes.status.update') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_online: isOnline })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            if (!data.success) {
                // Revert if failed
                statusToggle.checked = !isOnline;
                statusText.textContent = !isOnline ? 'Online' : 'Offline';
                showNotification('Gagal mengupdate status', 'error');
            } else {
                showNotification(
                    `Status berhasil diubah menjadi ${isOnline ? 'Online' : 'Offline'}`,
                    'success'
                );
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert on error
            statusToggle.checked = !isOnline;
            statusText.textContent = !isOnline ? 'Online' : 'Offline';
            showNotification('Terjadi kesalahan, coba lagi', 'error');
        });
    });
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        notification.textContent = message;
        notification.style.transform = 'translateX(100%)';
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Animate out and remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>

<style>
/* Custom scrollbar for chat list */
.chat-list-container {
    scrollbar-width: thin;
    scrollbar-color: #CBD5E1 #F8FAFC;
}

.chat-list-container::-webkit-scrollbar {
    width: 6px;
}

.chat-list-container::-webkit-scrollbar-track {
    background: #F8FAFC;
    border-radius: 10px;
}

.chat-list-container::-webkit-scrollbar-thumb {
    background-color: #CBD5E1;
    border-radius: 10px;
}

/* Smooth transitions */
a, button, .transition-colors {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>
@endsection