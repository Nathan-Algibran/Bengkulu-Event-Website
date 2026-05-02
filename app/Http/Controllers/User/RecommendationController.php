<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Event Rekomendasi dari Admin
        $recommendedEvents = Event::with('category')
            ->where('is_active', true)
            ->where('is_recommended', true)
            ->latest()
            ->get();

        // Event Populer
        $popularEvents = Event::with('category')
            ->where('is_active', true)
            ->where('is_popular', true)
            ->orderByDesc('view_count')
            ->get();

        // Rekomendasi Personal — berdasarkan kategori favorit user
        $favoriteCategoryIds = $user->favoriteEvents()
            ->pluck('category_id')
            ->unique()
            ->toArray();

        $personalEvents = collect();
        if (!empty($favoriteCategoryIds)) {
            $personalEvents = Event::with('category')
                ->where('is_active', true)
                ->whereIn('category_id', $favoriteCategoryIds)
                ->whereNotIn('id', $user->favoriteEvents()->pluck('events.id')->toArray())
                ->latest()
                ->take(8)
                ->get();
        }

        // Event Terbaru
        $latestEvents = Event::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        // Ambil ID favorit user untuk tombol favorit
        $favoriteIds = $user->favoriteEvents()
            ->pluck('events.id')
            ->toArray();

        return view('user.recommendations.index', compact(
            'recommendedEvents',
            'popularEvents',
            'personalEvents',
            'latestEvents',
            'favoriteIds'
        ));
    }
}