<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $recommendedEvents = Event::where('is_recommended', true)
            ->where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();

        $popularEvents = Event::where('is_popular', true)
            ->where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();

        return view('user.dashboard', compact('recommendedEvents', 'popularEvents'));
    }
}