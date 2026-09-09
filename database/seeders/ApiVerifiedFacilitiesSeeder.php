<?php

namespace Database\Seeders;

use App\Support\ApiVerifiedFacilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiVerifiedFacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        $added = 0;
        DB::transaction(function () use (&$added) {
            $existing = DB::table('spots')->get();
            foreach (ApiVerifiedFacilities::all() as $record) {
                $matches = $existing->filter(fn ($spot) => ApiVerifiedFacilities::matches($spot, $record));
                if ($matches->count() > 1) {
                    throw new \RuntimeException('重複候補を確認してください: '.$record['name']);
                }
                // Existing descriptions, reviews, coordinates and booking links belong to their authors.
                if ($matches->isNotEmpty()) { continue; }
                unset($record['city']);
                $record['source_checked_at'] = $record['checked_at'];
                unset($record['checked_at']);
                $record['source_urls'] = json_encode($record['source_urls'], JSON_UNESCAPED_SLASHES);
                $record['tags'] = json_encode($record['category'] === 'solo' ? ['solo'] : []);
                $record['lat'] = null;
                $record['lng'] = null;
                $record['location_note'] = '入口・集合場所は公式のアクセス案内でご確認ください。';
                $record['created_at'] = now();
                $record['updated_at'] = now();
                $id = DB::table('spots')->insertGetId($record);
                $existing->push((object) ($record + ['id' => $id]));
                $added++;
            }
        });
        $this->command?->info("公式サイトで照合した施設を{$added}件追加しました。");
    }
}
