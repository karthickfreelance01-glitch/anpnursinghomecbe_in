<?php

namespace App\Models;

use App\Models\Concerns\HasLanding;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasLanding;

    protected $guarded = ['id'];

    protected $casts = ['show_in_menu' => 'boolean'];

    public function getUrlAttribute(): string
    {
        return route('departments.show', $this->slug);
    }
}
