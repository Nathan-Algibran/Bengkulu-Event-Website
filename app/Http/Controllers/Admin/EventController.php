<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $events     = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'price'       => 'required|numeric|min:0',
            'quota'       => 'nullable|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'location'    => $request->location,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'price'       => $request->price,
            'quota'       => $request->quota,
            'image'       => $imagePath,
            'is_active'   => $request->boolean('is_active', true),
            'is_recommended' => $request->boolean('is_recommended', false), // ← TAMBAH INI
            'is_popular'     => $request->boolean('is_popular', false),     // ← TAMBAH INI

        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        $event->load('category', 'user');
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'price'       => 'required|numeric|min:0',
            'quota'       => 'nullable|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ]);

        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'location'    => $request->location,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'price'       => $request->price,
            'quota'       => $request->quota,
            'image'       => $imagePath,
            'is_active'   => $request->boolean('is_active', true),
            'is_recommended' => $request->boolean('is_recommended', false), // ← TAMBAH INI
            'is_popular'     => $request->boolean('is_popular', false),     // ← TAMBAH INI
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}