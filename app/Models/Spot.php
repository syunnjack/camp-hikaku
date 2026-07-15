<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'name',
        'description',
        'area',
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
            'average_congestion' => 'float',
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
