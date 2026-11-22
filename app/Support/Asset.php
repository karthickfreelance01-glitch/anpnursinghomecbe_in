<?php

namespace App\Support;

use Illuminate\Support\Str;

/** Tiny helper: turn a stored path (relative to /public) into a URL. */
final class Asset
{
    public static function url(?string $path): ?string
    {
        if (! $path) return null;
        return Str::startsWith($path, ['http://', 'https://', '//']) ? $path : asset($path);
    }
}
