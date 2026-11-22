<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends LandingCrudController
{
    protected function model(): string { return Department::class; }
    protected function folder(): string { return 'departments'; }
    protected function routeBase(): string { return 'admin.departments'; }
    protected function label(): string { return 'Department'; }

    protected function extraData(Request $r): array
    {
        return ['show_in_menu' => $r->boolean('show_in_menu')];
    }
}
