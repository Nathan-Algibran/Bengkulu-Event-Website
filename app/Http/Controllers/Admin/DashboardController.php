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
        $totalEvents     = Event::count();
        $totalUsers      = User::role('user')->count();
        $totalCategories = Category::count();
        $activeEvents    = Event::where('is_active', true)->count();
        $inactiveEvents  = Event::where('is_active', false)->count();
        $recommendedCount = Event::where('is_recommended', true)->count();
        $totalEv         = $totalEvents ?: 1; // hindari division by zero

        $stats = [
            [
                'icon'    => 'ph-ticket',
                'label'   => 'Total Event',
                'value'   => $totalEvents,
                'sub'     => $activeEvents . ' aktif',
                'color'   => '#C0392B',
                'iconBg'  => '#FFF1F0',
                'route'   => route('admin.events.index'),
            ],
            [
                'icon'    => 'ph-users',
                'label'   => 'Total Pengguna',
                'value'   => $totalUsers,
                'sub'     => 'User terdaftar',
                'color'   => '#3B82F6',
                'iconBg'  => '#DBEAFE',
                'route'   => route('admin.users.index'),
            ],
            [
                'icon'    => 'ph-tag',
                'label'   => 'Total Kategori',
                'value'   => $totalCategories,
                'sub'     => 'Kategori event',
                'color'   => '#1A5C38',
                'iconBg'  => '#DCFCE7',
                'route'   => route('admin.categories.index'),
            ],
            [
                'icon'    => 'ph-star',
                'label'   => 'Rekomendasi',
                'value'   => $recommendedCount,
                'sub'     => 'Event dikurasi',
                'color'   => '#8B6914',
                'iconBg'  => '#FFFBEB',
                'route'   => route('admin.recommendations.index'),
            ],
        ];

        $eventStatus = [
            [
                'label'   => 'Aktif',
                'icon'    => 'ph-check-circle',
                'color'   => '#27AE60',
                'count'   => $activeEvents,
                'percent' => round(($activeEvents / $totalEv) * 100),
            ],
            [
                'label'   => 'Nonaktif',
                'icon'    => 'ph-x-circle',
                'color'   => '#C0392B',
                'count'   => $inactiveEvents,
                'percent' => round(($inactiveEvents / $totalEv) * 100),
            ],
            [
                'label'   => 'Rekomendasi',
                'icon'    => 'ph-star',
                'color'   => '#D4A843',
                'count'   => $recommendedCount,
                'percent' => round(($recommendedCount / $totalEv) * 100),
            ],
        ];

        $quickLinks = [
            [
                'href'  => route('admin.events.create'),
                'icon'  => 'ph-plus-circle',
                'label' => 'Tambah Event Baru',
                'bg'    => '#FFF1F0',
                'color' => '#C0392B',
            ],
            [
                'href'  => route('admin.categories.create'),
                'icon'  => 'ph-folder-plus',
                'label' => 'Tambah Kategori',
                'bg'    => '#FFFBEB',
                'color' => '#8B6914',
            ],
            [
                'href'  => route('admin.recommendations.index'),
                'icon'  => 'ph-star',
                'label' => 'Kelola Rekomendasi',
                'bg'    => '#F0FDF4',
                'color' => '#1A5C38',
            ],
            [
                'href'  => route('admin.recommendations.statistics'),
                'icon'  => 'ph-chart-bar',
                'label' => 'Lihat Statistik',
                'bg'    => '#EFF6FF',
                'color' => '#3B82F6',
            ],
        ];

        $recentEvents = Event::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'eventStatus',
            'quickLinks',
            'recentEvents',
            'totalEvents',
            'totalUsers',
            'totalCategories'
        ));
    }
}