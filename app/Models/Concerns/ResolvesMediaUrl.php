<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

/**
 * Resolusi seragam untuk kolom gambar: URL eksternal dipakai apa adanya,
 * path lokal diambil dari disk public, dan nilai kosong jatuh ke gambar cadangan template.
 */
trait ResolvesMediaUrl
{
    protected function mediaUrl(?string $value, string $fallback): Attribute
    {
        return Attribute::make(
            get: function () use ($value, $fallback) {
                if (blank($value)) {
                    return asset($fallback);
                }

                return Str::startsWith($value, ['http://', 'https://'])
                    ? $value
                    : asset('storage/' . $value);
            },
        );
    }
}
