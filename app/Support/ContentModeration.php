<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContentModeration
{
    private const NG_WORDS = ['死ね', '殺す', 'バカ', 'カス', 'http://', 'https://', 'www.'];

    public static function containsNgWord(string $text): bool
    {
        foreach (self::NG_WORDS as $word) {
            if ($word !== '' && mb_stripos($text, $word) !== false) {
                return true;
            }
        }

        return false;
    }

    public static function clientIpHash(Request $request): string
    {
        return hash_hmac('sha256', $request->ip() ?? 'unknown', config('app.key'));
    }

    public static function isTooSoon(string $key, int $seconds): bool
    {
        return ! Cache::add($key, true, $seconds);
    }
}
