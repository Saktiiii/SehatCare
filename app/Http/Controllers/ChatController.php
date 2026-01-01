<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class ChatController extends Controller
{
    // Form untuk mulai chat pilih spesialisasi + pesan pertama
    public function create()
    {
        $spesialisasi = User::where('role', 'nakes')
            ->with('profile')
            ->get()
            ->pluck('profile.spesialisasi')
            ->unique();

        return view('chat.create', compact('spesialisasi'));
    }

    // Proses mulai chat atau lanjut chat jika conversation sudah ada
    public function store(Request $request)
    {
        $request->validate([
            'spesialisasi' => 'required|string',
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        if (!$user->isPasien()) {
            abort(403, 'Hanya pasien yang boleh mulai chat');
        }

        // Cari nakes online sesuai spesialisasi
        $nakes = User::where('role', 'nakes')
            // ->where('is_online', true) // optional, kalau ada kolom is_online
            ->whereHas('profile', function ($query) use ($request) {
                $query->where('spesialisasi', $request->spesialisasi);
            })
            ->inRandomOrder()
            ->first();

        if (!$nakes) {
            return back()->with('error', 'Tidak ada tenaga kesehatan online dengan spesialisasi ini.');
        }

        // Cek conversation existing pasien dengan nakes
        $conversation = Conversation::where('pasien_id', $user->id)
            ->where('nakes_id', $nakes->id)
            ->first();

        if (!$conversation) {
            // Buat conversation baru jika belum ada
            $conversation = Conversation::create([
                'pasien_id' => $user->id,
                'nakes_id' => $nakes->id,
            ]);
        }

        // Simpan pesan baru
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    // Tampilkan chat
    public function show($id)
    {
        $conversation = Conversation::with('messages.sender', 'nakes', 'pasien')->findOrFail($id);

        $user = auth()->user();
        if ($user->id !== $conversation->pasien_id && $user->id !== $conversation->nakes_id) {
            abort(403);
        }

        return view('chat.show', compact('conversation'));
    }

    // Kirim pesan baru dalam chat
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $conversation = Conversation::findOrFail($id);
        $user = auth()->user();

        if ($user->id !== $conversation->pasien_id && $user->id !== $conversation->nakes_id) {
            abort(403);
        }

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('chat_photos', 'public');
            $data['photo_path'] = $path;
            $data['message'] = $request->message ?? '';
        } else {
            $data['message'] = $request->message;
        }

        Message::create($data);

        return redirect()->route('chat.show', $id);
    }

    // Halaman riwayat chat pasien (history)
    public function history()
    {
        // Hanya pasien yang boleh akses
        if (!auth()->user()->isPasien()) {
            abort(403);
        }
    
        $conversations = Conversation::with(['nakes.profile'])
            ->withCount('messages')
            ->where('pasien_id', auth()->id())
            ->latest('updated_at') // sama seperti latest() di order
            ->get();
    
        return view('chat.history', compact('conversations'));
    }

}
