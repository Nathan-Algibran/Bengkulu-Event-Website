<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug',
        'description', 'location', 'image',
        'start_date', 'end_date', 'price', 'quota',
        'is_active', 'is_recommended', 'is_popular', 'view_count',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_active'       => 'boolean',
        'is_recommended'  => 'boolean',
        'is_popular'      => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title) . '-' . Str::random(5);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}