<?php

namespace App\Http\Controllers\Admin;

use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecialityController extends LandingCrudController
{
    protected function model(): string { return Speciality::class; }
    protected function folder(): string { return 'specialities'; }
    protected function routeBase(): string { return 'admin.specialities'; }
    protected function label(): string { return 'Speciality'; }

    protected function extraRules(?Model $item): array
    {
        return ['category' => ['required', Rule::in(array_keys(Speciality::CATEGORIES))]];
    }

    protected function extraData(Request $r): array
    {
        return ['category' => $r->input('category')];
    }

    protected function filterIndex($q, Request $r): void
    {
        if (array_key_exists($r->get('category'), Speciality::CATEGORIES)) {
            $q->where('category', $r->get('category'));
        }
        $q->reorder()->orderBy('category')->orderBy('sort_order')->orderBy('name');
    }

    protected function indexExtras(Request $r): array
    {
        return ['category' => $r->get('category')];
    }
}
