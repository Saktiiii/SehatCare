@extends('app')

@section('content')
    <div class="h-screen bg-white flex flex-col">

        <!-- Chat Header -->
        <header
            class="bg-gradient-to-r from-blue-50 to-blue-100 border-b px-4 sm:px-6 py-3 sm:py-4 shadow-sm flex items-center">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-blue-700 mr-3 sm:mr-4 text-lg">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div
                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 flex items-center justify-center mr-3 sm:mr-4 shrink-0">
                <i class="fas fa-user-md text-blue-700 text-lg sm:text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="font-semibold text-gray-900 truncate text-sm sm:text-base">
                    Chat dengan {{ $conversation->nakes->name }}
                </h2>
                <div class="flex items-center space-x-3 mt-1 text-xs sm:text-sm text-gray-600">
                    <div class="flex items-center text-green-600">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        <span>Online</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-clock mr-1"></i>
                        <span>Respon cepat</span>
                    </div>
                </div>
            </div>
            <div class="flex space-x-2 ml-3 sm:ml-4">
                <button class="p-2 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="p-2 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition">
                    <i class="fas fa-video"></i>
                </button>
                <button class="p-2 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
        </header>

        <!-- Chat Area -->
        <main class="flex-1 overflow-hidden flex flex-col">
            <div id="chat-box"
                class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-6 scrollbar-thin scrollbar-thumb-blue-300 scrollbar-track-blue-50">
                <!-- Tanggal -->
                <div class="text-center">
                    <span
                        class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full select-none">
                        {{ date('d F Y') }}
                    </span>
                </div>

                <!-- Pesan-pesan -->
                @foreach ($conversation->messages as $msg)
                    <div class="mb-4 flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div>
                            <div
                                class="flex {{ $msg->sender_id == auth()->id() ? 'flex-row-reverse' : '' }} items-end space-x-2 space-x-reverse">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center {{ $msg->sender_id == auth()->id() ? 'bg-blue-600' : 'bg-blue-100' }}">
                                        @if($msg->sender_id == auth()->id())
                                            <i class="fas fa-user text-white text-xs"></i>
                                        @else
                                            <i class="fas fa-user-md text-blue-700 text-xs"></i>
                                        @endif
                                    </div>
                                </div>

                                <!-- Bubble pesan -->
                                <div class="chat-bubble {{ $msg->sender_id == auth()->id() ? 'sender' : 'receiver' }}">
                                    <!-- Nama pengirim -->
                                    <div
                                        class="font-semibold text-sm mb-1 {{ $msg->sender_id == auth()->id() ? 'text-blue-100' : 'text-blue-700' }}">
                                        {{ $msg->sender->name }}
                                    </div>

                                    <!-- Foto jika ada -->
                                    @if ($msg->photo_path)
                                        <img src="{{ asset('storage/' . $msg->photo_path) }}" alt="Foto"
                                            class="rounded-lg max-w-full max-h-60 mb-2 object-contain cursor-pointer hover:opacity-80 transition" />
                                    @endif

                                    <!-- Pesan teks -->
                                    @if ($msg->message)
                                        <div class="whitespace-pre-wrap">{{ $msg->message }}</div>
                                    @endif

                                    <!-- Waktu -->
                                    <div class="text-xs text-right {{ $msg->sender_id == auth()->id() ? 'text-blue-200' : 'text-gray-500' }}"
                                        data-timestamp="{{ $msg->created_at->toIso8601String() }}">
                                       {{ $msg->created_at->format('H:i') }}
                                   </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



                <!-- Indikator mengetik -->
                <div class="flex justify-start" id="typing-indicator" style="display: none;">
                    <div class="max-w-[70%]">
                        <div class="flex items-end space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user-md text-blue-700 text-sm"></i>
                                </div>
                            </div>
                            <div class="bg-gray-100 text-gray-800 rounded-r-2xl rounded-tl-2xl p-4 shadow-sm">
                                <div class="typing-dots flex space-x-1">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></span>
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce delay-150"></span>
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce delay-300"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Form Input Pesan -->
        <footer class="border-t bg-white px-4 sm:px-6 py-4">
            <form action="{{ route('chat.send', $conversation->id) }}" method="POST" id="chat-form"
                enctype="multipart/form-data" class="flex items-center space-x-3">
                @csrf

                <!-- Tombol upload foto -->
                <button type="button" id="btn-upload-photo"
                    class="p-3 text-gray-500 hover:text-blue-700 rounded-full transition">
                    <i class="fas fa-camera"></i>
                </button>

                <!-- Input file tersembunyi -->
                <input type="file" name="photo" id="input-photo" accept="image/*" class="hidden" />

                <!-- Preview foto -->
                <div id="photo-preview"
                    class="hidden relative mr-3 max-w-[150px] max-h-[150px] overflow-hidden sm:max-w-[150px] sm:max-h-[150px] xs:max-w-[100px] xs:max-h-[100px]">
                    <img id="preview-img" src="#" alt="Preview Foto"
                        class="rounded-lg max-w-full max-h-full object-contain" />
                    <button type="button" id="remove-photo"
                        class="absolute top-0 right-0 bg-black bg-opacity-50 text-white rounded-full p-1 hover:bg-opacity-75">
                        &times;
                    </button>
                </div>

                <!-- Input pesan teks -->
                <div class="flex-1 relative">
                    <input type="text" name="message" id="message-input"
                        class="w-full border border-gray-300 rounded-full py-3 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent text-sm sm:text-base"
                        placeholder="Tulis pesan..." autocomplete="off">
                    <button type="button"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-700 transition">
                        <i class="far fa-smile"></i>
                    </button>
                </div>

                <!-- Tombol kirim -->
                <button type="submit" id="send-button"
                    class="bg-blue-700 text-white p-3 rounded-full hover:bg-blue-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    disabled>
                    <i class="fas fa-paper-plane text-lg"></i>
                </button>
            </form>
        </footer>
    </div>

    <script>
        // Klik tombol kamera untuk pilih file
        document.getElementById('btn-upload-photo').addEventListener('click', () => {
            document.getElementById('input-photo').click();
        });

        const inputPhoto = document.getElementById('input-photo');
        const photoPreview = document.getElementById('photo-preview');
        const previewImg = document.getElementById('preview-img');
        const removePhotoBtn = document.getElementById('remove-photo');
        const sendButton = document.getElementById('send-button');
        const messageInput = document.getElementById('message-input');

        // Saat file dipilih, tampilkan preview dan jangan langsung submit
        inputPhoto.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    photoPreview.classList.remove('hidden');
                };

                reader.readAsDataURL(file);

                // Aktifkan tombol kirim walau input teks kosong
                sendButton.disabled = false;
            } else {
                previewImg.src = '#';
                photoPreview.classList.add('hidden');
                toggleSendButton();
            }
        });

        // Tombol hapus preview foto
        removePhotoBtn.addEventListener('click', function () {
            inputPhoto.value = ''; // reset input file
            previewImg.src = '#';
            photoPreview.classList.add('hidden');
            toggleSendButton();
        });

        // Fungsi aktifkan tombol kirim jika ada teks atau foto
        function toggleSendButton() {
            if (messageInput.value.trim() !== '' || inputPhoto.files.length > 0) {
                sendButton.disabled = false;
                sendButton.classList.add('bg-blue-800');
                sendButton.classList.remove('bg-blue-700');
            } else {
                sendButton.disabled = true;
                sendButton.classList.remove('bg-blue-800');
                sendButton.classList.add('bg-blue-700');
            }
        }

        // Toggle tombol kirim saat input teks berubah
        messageInput.addEventListener('input', toggleSendButton);
        toggleSendButton();

        // Auto scroll chat ke bawah
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;

            // Submit form dengan Enter (tanpa shift)
            messageInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (messageInput.value.trim() !== '' || inputPhoto.files.length > 0) {
                        document.getElementById('chat-form').submit();
                    }
                }
            });

            messageInput.focus();
        });
    </script>

    <style>
        @media (max-width: 640px) {
            #photo-preview {
                max-width: 100px !important;
                max-height: 100px !important;
            }
        }
    </style>
@endsection