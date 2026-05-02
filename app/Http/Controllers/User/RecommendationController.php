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

        $recommendedEvents = Event::with('category')
            ->where('is_active', true)
            ->where('is_recommended', true)
            ->latest()
            ->get();

        $popularEvents = Event::with('category')
            ->where('is_active', true)
            ->where('is_popular', true)
            ->orderByDesc('view_count')
            ->get();

        // Ambil langsung dari tabel favorites dengan join
        $favoriteData = \DB::table('favorites')
            ->join('events', 'favorites.event_id', '=', 'events.id')
            ->where('favorites.user_id', $user->id)
            ->select('events.id', 'events.category_id')
            ->get();

        $favoriteEventIds    = $favoriteData->pluck('id')->toArray();
        $favoriteCategoryIds = $favoriteData->pluck('category_id')->unique()->toArray();

        // Tampilkan semua event di kategori favorit
        // (termasuk yang sudah difavoritkan agar tidak kosong)
        $personalEvents = collect();
        if (!empty($favoriteCategoryIds)) {
            $personalEvents = Event::with('category')
                ->where('is_active', true)
                ->whereIn('category_id', $favoriteCategoryIds)
                ->latest()
                ->take(8)
                ->get();
        }

        $latestEvents = Event::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $favoriteIds = $favoriteEventIds;

        return view('user.recommendations.index', [
            'recommendedEvents' => $recommendedEvents,
            'popularEvents'     => $popularEvents,
            'personalEvents'    => $personalEvents,
            'latestEvents'      => $latestEvents,
            'favoriteIds'       => $favoriteIds,
            'user'              => $user,
        ]);
    }
}