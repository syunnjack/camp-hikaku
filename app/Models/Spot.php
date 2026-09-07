<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'name',
        'description',
        'area',
        'category',
        'tags',
        'booking_url',
        'booking_provider',
        'official_url',
        'lat',
        'lng',
        'congestion_reports',
        'average_congestion',
        'likes_count',
    ];

    protected function casts(): array
    {
        return [
            'congestion_reports' => 'array',
            'tags' => 'array',
            'average_congestion' => 'float',
            'source_checked_at' => 'date',
            'source_urls' => 'array',
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_hidden', false);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
