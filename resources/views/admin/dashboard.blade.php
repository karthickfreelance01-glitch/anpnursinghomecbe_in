@extends('admin.layout')
@section('title', 'Dashboard')
@section('subtitle', 'Welcome back, ' . auth()->user()->name . ' — here is what is happening today.')

@section('content')
<div class="stat-grid">
    <a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}" class="stat stat--hot">
        <i class="bi bi-bell"></i><div><strong>{{ $stats['new'] }}</strong><span>New enquiries</span></div>
    </a>
    <a href="{{ route('admin.enquiries.index') }}" class="stat">
        <i class="bi bi-inbox"></i><div><strong>{{ $stats['enquiries'] }}</strong><span>Total enquiries · {{ $stats['today'] }} today</span></div>
    </a>
    <a href="{{ route('admin.departments.index') }}" class="stat">
        <i class="bi bi-hospital"></i><div><strong>{{ $stats['departments'] }}</strong><span>Departments</span></div>
    </a>
    <a href="{{ route('admin.specialities.index') }}" class="stat">
        <i class="bi bi-capsule"></i><div><strong>{{ $stats['medical'] + $stats['surgical'] }}</strong><span>{{ $stats['medical'] }} medical · {{ $stats['surgical'] }} surgical</span></div>
    </a>
</div>

<div class="grid-2">
    <section class="card">
        <div class="card__head"><h3><i class="bi bi-bar-chart"></i> Enquiries – last 14 days</h3></div>
        @php($max = max(1, $chart->max('count')))
        <div class="bars">
            @foreach ($chart as $d)
                <div class="bars__col" title="{{ $d['label'] }}: {{ $d['count'] }}">
                    <span class="bars__val">{{ $d['count'] ?: '' }}</span>
                    <span class="bars__bar" style="height: {{ max(3, round($d['count'] / $max * 100)) }}%"></span>
                    <span class="bars__lbl">{{ \Illuminate\Support\Str::before($d['label'], ' ') }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="card">
        <div class="card__head"><h3><i class="bi bi-trophy"></i> Most requested</h3></div>
        @forelse ($topDepartments as $t)
            <div class="rank">
                <span>{{ $t->department }}</span><b>{{ $t->total }}</b>
                <i style="width: {{ round($t->total / max(1, $topDepartments->max('total')) * 100) }}%"></i>
            </div>
        @empty
            <p class="muted">No department requests yet.</p>
        @endforelse

        <div class="quick-links">
            <a href="{{ route('admin.banners.index') }}"><i class="bi bi-stars"></i> Edit home hero</a>
            <a href="{{ route('admin.departments.create') }}"><i class="bi bi-plus-circle"></i> Add department</a>
            <a href="{{ route('admin.specialities.create') }}"><i class="bi bi-plus-circle"></i> Add speciality</a>
            <a href="{{ route('admin.seo.index') }}"><i class="bi bi-search"></i> Edit SEO</a>
        </div>
    </section>
</div>

<section class="card">
    <div class="card__head">
        <h3><i class="bi bi-clock-history"></i> Latest enquiries</h3>
        <a href="{{ route('admin.enquiries.index') }}" class="b b--ghost b--sm">View all <i class="bi bi-arrow-right"></i></a>
    </div>
    @include('admin.enquiries._table', ['enquiries' => $recent])
</section>
@endsection
