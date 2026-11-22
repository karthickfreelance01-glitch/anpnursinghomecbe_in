<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Department;
use App\Models\Enquiry;
use App\Models\Speciality;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $days = collect(range(13, 0))->map(fn ($i) => Carbon::today()->subDays($i));
        $counts = Enquiry::where('created_at', '>=', $days->first())
            ->get(['created_at'])
            ->groupBy(fn ($e) => $e->created_at->toDateString())
            ->map->count();

        return view('admin.dashboard', [
            'stats' => [
                'enquiries'   => Enquiry::count(),
                'new'         => Enquiry::where('status', 'new')->count(),
                'today'       => Enquiry::whereDate('created_at', today())->count(),
                'departments' => Department::count(),
                'medical'     => Speciality::category('medical')->count(),
                'surgical'    => Speciality::category('surgical')->count(),
                'banners'     => Banner::active()->count(),
            ],
            'chart'  => $days->map(fn ($d) => ['label' => $d->format('d M'), 'count' => $counts[$d->toDateString()] ?? 0]),
            'recent' => Enquiry::latest()->take(8)->get(),
            'topDepartments' => Enquiry::whereNotNull('department')->selectRaw('department, count(*) as total')
                ->groupBy('department')->orderByDesc('total')->take(5)->get(),
        ]);
    }
}
