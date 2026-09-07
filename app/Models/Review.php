<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'spot_id',
        'nickname',
        'rating',
        'comment',
        'ip_hash',
        'visited_on',
        'party',
        'cost',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'visited_on' => 'date',
            'cost' => 'integer',
            'is_hidden' => 'boolean',
        ];
    }

    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }
}
