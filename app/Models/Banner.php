<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order')->orderBy('id'); }

    public function getImageUrlAttribute(): string
    {
        return \App\Support\Asset::url($this->image);
    }

    public function getMobileUrlAttribute(): ?string
    {
        return $this->mobile_image ? \App\Support\Asset::url($this->mobile_image) : null;
    }
}
