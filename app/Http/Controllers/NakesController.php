<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;

class NakesController extends Controller
{
    public function dashboard()
    {
        $nakesId = auth()->id();

        // Ambil semua percakapan dimana nakes adalah yang login (pesertanya)
        $conversations = Conversation::with(['pasien', 'messages'])
            ->where('nakes_id', $nakesId)
            ->get();
    
        return view('nakes.dashboard', compact('conversations'));
    }

    public function chat(Conversation $conversation)
    {
        // Pastikan nakes adalah peserta conversation ini
        $this->authorize('view', $conversation);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();

        return view('nakes.chat', compact('conversation', 'messages'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if (!$request->message && !$request->photo) {
            return back()->withErrors('Pesan atau foto harus diisi.');
        }

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'message' => $request->message ?? null,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('chat_photos', 'public');
            $data['photo_path'] = $path;
        }

        Message::create($data);

        // Update updated_at conversation
        $conversation->touch();

        return redirect()->route('nakes.chat', $conversation->id);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'is_online' => 'required|boolean',
        ]);

        $user = auth()->user();
        $user->is_online = $request->is_online;
        $user->save();

        return response()->json(['success' => true]);
    }
}
