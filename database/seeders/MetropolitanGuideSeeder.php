<?php

namespace Database\Seeders;

use App\Support\MetropolitanGuide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MetropolitanGuideSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (MetropolitanGuide::all() as $key => $guide) {
                if (DB::table('spots')->where('editorial_guide', $key)->exists()) {
                    continue;
                }
                $matches = DB::table('spots')->where('area', $guide['area'])
                    ->where(fn ($q) => $q->whereIn('name', $guide['aliases'])
                        ->orWhereIn('official_url', $guide['official_aliases']))->get();
                if ($matches->count() > 1) {
                    throw new RuntimeException('施設の重複候補を確認してください: '.$guide['name']);
                }
                if ($matches->isNotEmpty()) {
                    // Editorial metadata only: preserve visitor content and booking links.
                    DB::table('spots')->where('id', $matches->first()->id)->update(['editorial_guide' => $key]);
                    continue;
                }
                DB::table('spots')->insert([
                    'name' => $guide['name'], 'area' => $guide['area'], 'category' => $guide['category'],
                    'description' => $guide['summary'], 'address' => $guide['address'],
                    'official_url' => $guide['official_url'], 'source_checked_at' => $guide['checked_at'],
                    'source_urls' => json_encode(array_column($guide['sources'], 'url'), JSON_UNESCAPED_SLASHES),
                    'editorial_guide' => $key, 'lat' => null, 'lng' => null,
                    'location_note' => '入口・集合場所は公式のアクセス案内でご確認ください。',
                    'tags' => json_encode($guide['category'] === 'solo' ? ['solo'] : []),
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        });
    }
}
