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
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }
}
