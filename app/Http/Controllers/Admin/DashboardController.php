<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalEvents'      => Event::count(),
            'totalUsers'       => User::role('user')->count(),
            'totalCategories'  => Category::count(),
            'recentEvents'     => Event::latest()->take(5)->with('category')->get(),
        ];

        return view('admin.dashboard', $data);
    }
}