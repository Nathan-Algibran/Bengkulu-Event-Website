<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')
            ->where('is_active', true);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter Harga
        if ($request->filled('price')) {
            match($request->price) {
                'free' => $query->where('price', 0),
                'paid' => $query->where('price', '>', 0),
                default => null,
            };
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            match($request->date) {
                'today'    => $query->whereDate('start_date', today()),
                'week'     => $query->whereBetween('start_date', [now(), now()->endOfWeek()]),
                'month'    => $query->whereMonth('start_date', now()->month),
                'upcoming' => $query->where('start_date', '>=', now()),
                default    => null,
            };
        }

        // Sort
        match($request->sort ?? 'latest') {
            'latest'   => $query->latest(),
            'oldest'   => $query->oldest(),
            'popular'  => $query->orderByDesc('view_count'),
            'cheapest' => $query->orderBy('price'),
            default    => $query->latest(),
        };

        $events     = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        // Ambil ID event yang sudah difavoritkan user
        $favoriteIds = Auth::user()
            ->favoriteEvents()
            ->pluck('events.id')
            ->toArray();

        return view('user.events.index', compact('events', 'categories', 'favoriteIds'));
    }

    public function show(string $slug)
    {
        $event = Event::with('category', 'user')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $event->increment('view_count');

        // Cek apakah user sudah favoritkan
        $isFavorited = Auth::user()
            ->favoriteEvents()
            ->where('events.id', $event->id)
            ->exists();

        // Event terkait (kategori sama, bukan event ini)
        $relatedEvents = Event::with('category')
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        return view('user.events.show', compact('event', 'isFavorited', 'relatedEvents'));
    }
}