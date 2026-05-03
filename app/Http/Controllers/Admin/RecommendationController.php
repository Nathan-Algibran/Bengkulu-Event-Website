<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('filter')) {
            match($request->filter) {
                'recommended' => $query->where('is_recommended', true),
                'popular'     => $query->where('is_popular', true),
                'none'        => $query->where('is_recommended', false)->where('is_popular', false),
                default       => null,
            };
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        $totalRecommended = Event::where('is_recommended', true)->count();
        $totalPopular     = Event::where('is_popular', true)->count();
        $totalUntagged    = Event::where('is_active', true)
                                 ->where('is_recommended', false)
                                 ->where('is_popular', false)
                                 ->count();

        return view('admin.recommendations.index', compact(
            'events', 'totalRecommended', 'totalPopular', 'totalUntagged'
        ));
    }

    public function toggleRecommended(Event $event)
    {
        $event->update(['is_recommended' => !$event->is_recommended]);

        $status = $event->is_recommended ? 'ditandai sebagai rekomendasi' : 'dihapus dari rekomendasi';

        return back()->with('success', "Event \"{$event->title}\" berhasil {$status}.");
    }

    public function togglePopular(Event $event)
    {
        $event->update(['is_popular' => !$event->is_popular]);

        $status = $event->is_popular ? 'ditandai sebagai populer' : 'dihapus dari populer';

        return back()->with('success', "Event \"{$event->title}\" berhasil {$status}.");
    }

    public function statistics()
    {
        $mostFavorited = Event::withCount('favorites')
            ->with('category')
            ->orderByDesc('favorites_count')
            ->take(10)
            ->get();

        $mostViewed = Event::with('category')
            ->orderByDesc('view_count')
            ->take(10)
            ->get();

        $categoryStats = \App\Models\Category::withCount('events')
            ->orderByDesc('events_count')
            ->get();

        $summary = [
            'total_events'      => Event::count(),
            'active_events'     => Event::where('is_active', true)->count(),
            'total_recommended' => Event::where('is_recommended', true)->count(),
            'total_popular'     => Event::where('is_popular', true)->count(),
            'total_favorites'   => \App\Models\Favorite::count(),
            'free_events'       => Event::where('price', 0)->count(),
            'paid_events'       => Event::where('price', '>', 0)->count(),
        ];

        return view('admin.recommendations.statistics', compact(
            'mostFavorited', 'mostViewed', 'categoryStats', 'summary'
        ));
    }
}