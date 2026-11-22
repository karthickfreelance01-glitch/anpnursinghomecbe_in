<?php

namespace App\Models;

use App\Models\Concerns\HasLanding;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasLanding;

    public const CATEGORIES = [
        'medical'  => 'Medical Speciality',
        'surgical' => 'Surgical Speciality',
    ];

    protected $guarded = ['id'];

    public function scopeCategory(Builder $q, string $category): Builder
    {
        return $q->where('category', $category);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function getUrlAttribute(): string
    {
        return route('specialities.show', $this->slug);
    }
}
