<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()
            ->favoriteEvents()
            ->with('category')
            ->where('is_active', true)
            ->latest('favorites.created_at')
            ->paginate(12);

        return view('user.favorites.index', compact('favorites'));
    }

    public function store(Event $event)
    {
        // Cek apakah event aktif
        if (!$event->is_active) {
            return back()->with('error', 'Event tidak tersedia.');
        }

        // Cek apakah sudah difavoritkan
        $already = Favorite::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Event sudah ada di favorit Anda.');
        }

        Favorite::create([
            'user_id'  => Auth::id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', "\"$event->title\" berhasil disimpan ke favorit.");
    }

    public function destroy(Event $event)
    {
        $deleted = Favorite::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->delete();

        if (!$deleted) {
            return back()->with('error', 'Event tidak ditemukan di favorit Anda.');
        }

        return back()->with('success', "\"$event->title\" berhasil dihapus dari favorit.");
    }
}