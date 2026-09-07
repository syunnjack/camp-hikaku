<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

class Discovery
{
    public const CATEGORIES = [
        'glamping' => ['label' => 'グランピング', 'symbol' => '01', 'description' => 'テントや宿泊設備が用意された施設を探す。食事・持ち物・アクセスは各施設でご確認ください。'],
        'solo' => ['label' => 'ソロキャンプ', 'symbol' => '02', 'description' => 'ひとりの時間を楽しむキャンプ。ソロ向けのタグが付いたキャンプ場も掲載しています。'],
        'activity' => ['label' => 'アクティビティ', 'symbol' => '03', 'description' => '自然の中で体を動かす体験探し。参加条件や天候による開催状況は公式情報をご確認ください。'],
        'ganbanyoku' => ['label' => '岩盤浴', 'symbol' => '04', 'description' => '温かな空間でゆっくり過ごす岩盤浴探し。利用時間・館内着・年齢制限を確認しましょう。'],
        'healing' => ['label' => 'ヒーリング', 'symbol' => '05', 'description' => '森林や静かな環境で休息する体験探し。掲載内容は医療行為や健康効果を保証するものではありません。'],
        'spa' => ['label' => 'スパ', 'symbol' => '06', 'description' => '日帰りや旅の途中に立ち寄れるスパ探し。料金や予約の要否は公式情報で確認できます。'],
        'campground' => ['label' => 'キャンプ場', 'symbol' => '07', 'description' => '全国のキャンプ場をエリア・利用シーン・体験記から比較できます。'],
    ];

    public const TAGS = ['solo' => 'ひとりで', 'couple' => 'ふたりで', 'family' => '家族で', 'friends' => '友人と'];

    public static function category(Builder $query, string $category): void
    {
        if ($category === 'solo') {
            $query->where(fn ($q) => $q->where('category', 'solo')->orWhere(fn ($q) => $q
                ->where(fn ($q) => $q->where('category', 'campground')->orWhereNull('category'))
                ->whereJsonContains('tags', 'solo')));
        } elseif ($category === 'campground') {
            $query->where(fn ($q) => $q->where('category', 'campground')->orWhereNull('category'));
        } else {
            $query->where('category', $category);
        }
    }

    public static function label(?string $category): string
    {
        return self::CATEGORIES[$category ?? 'campground']['label'] ?? '施設';
    }

    public static function json(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR);
    }
}
