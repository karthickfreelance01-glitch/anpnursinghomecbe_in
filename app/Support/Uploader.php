<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Stores uploads directly in /public/uploads/<folder> so they work on
 * XAMPP and cPanel without `php artisan storage:link`.
 */
class Uploader
{
    public static function store(?UploadedFile $file, string $folder, ?string $old = null): ?string
    {
        if (! $file || ! $file->isValid()) return $old;

        $dir = public_path('uploads/' . $folder);
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $name = Str::limit($name, 60, '') . '-' . Str::lower(Str::random(6)) . '.' . strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $file->move($dir, $name);

        static::delete($old);

        return 'uploads/' . $folder . '/' . $name;
    }

    /** Only ever deletes files we uploaded (never the bundled /assets images). */
    public static function delete(?string $path): void
    {
        if ($path && Str::startsWith($path, 'uploads/') && ! Str::contains($path, '..')) {
            $full = public_path($path);
            if (is_file($full)) @unlink($full);
        }
    }
}
