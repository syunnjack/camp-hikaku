<?php

namespace App\Support;

class ApiVerifiedFacilities
{
    public static function all(): array
    {
        return json_decode(file_get_contents(__DIR__.'/api-verified-facilities.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function canonicalUrl(?string $url): string
    {
        if (! $url) { return ''; }
        $parts = parse_url($url);
        return preg_replace('/^www\./', '', strtolower($parts['host'] ?? '')).rtrim($parts['path'] ?? '', '/');
    }

    public static function matches(object $spot, array $record): bool
    {
        if ($spot->area !== $record['area']) { return false; }
        $name = fn ($value) => preg_replace('/[\s　]+/u', '', mb_convert_kana($value, 'asKV'));
        return $name($spot->name) === $name($record['name'])
            || self::canonicalUrl($spot->official_url) === self::canonicalUrl($record['official_url']);
    }
}
