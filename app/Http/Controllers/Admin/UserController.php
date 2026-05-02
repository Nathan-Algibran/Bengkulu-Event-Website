<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('user')->withCount(['favorites', 'events']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount(['favorites']);
        $favorites = $user->favoriteEvents()->with('category')->latest()->take(5)->get();

        return view('admin.users.show', compact('user', 'favorites'));
    }

    public function toggleActive(User $user)
    {
        // Proteksi agar admin tidak bisa menonaktifkan dirinya sendiri
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Tidak dapat mengubah status akun admin.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }
}