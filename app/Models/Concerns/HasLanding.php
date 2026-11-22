<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Shared behaviour for Department + Speciality (both have a public landing page).
 */
trait HasLanding
{
    protected static function bootHasLanding(): void
    {
        static::saving(function ($m) {
            $m->slug = Str::slug($m->slug ?: $m->name);
        });
    }

    public function initializeHasLanding(): void
    {
        $this->mergeCasts(['services' => 'array', 'faqs' => 'array', 'is_active' => 'boolean']);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('name');
    }

    /** Public URL to an image stored relative to /public (or a full URL). */
    public static function assetUrl(?string $path): ?string
    {
        return \App\Support\Asset::url($path);
    }

    public function getImageUrlAttribute(): ?string
    {
        return static::assetUrl($this->image);
    }

    public function getBannerUrlAttribute(): ?string
    {
        return static::assetUrl($this->banner_image ?: $this->image);
    }

    public function getIconClassAttribute(): string
    {
        return $this->icon ?: 'bi-heart-pulse';
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->short_description ?: $this->description), 150);
    }
}
