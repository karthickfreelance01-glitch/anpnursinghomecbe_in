@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'title' => 'Departments',
    'subtitle' => 'Core departments, medical and surgical specialities under one roof — with visiting consultants as per schedule.',
])

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow"><i class="bi bi-grid"></i> Core Departments</span>
            <h2 class="title">Our <span class="grad">Departments</span></h2>
        </div>
        <div class="dept-grid">
            @foreach ($navDepartments as $d)
                @include('partials.dept-card', ['d' => $d, 'url' => route('departments.show', $d->slug)])
            @endforeach
        </div>
    </div>
</section>

@foreach (['medical' => [$medicalList, 'bi-capsule', 'Evidence-based medical care backed by in-house diagnostics, pharmacy and lab.'],
           'surgical' => [$surgicalList, 'bi-scissors', 'Modern operation theatres, experienced surgeons and post-operative ICU care.']] as $group => [$list, $icon, $intro])
<section @class(['section', 'section--tint' => $group === 'medical']) id="{{ $group }}">
    <div class="container">
        <div class="section-head section-head--split reveal">
            <div>
                <span class="eyebrow"><i class="bi {{ $icon }}"></i> {{ \App\Models\Speciality::CATEGORIES[$group] }}</span>
                <h2 class="title">{{ $list->count() }} <span class="grad">{{ $group }}</span> specialities</h2>
                <p class="muted mb-0">{{ $intro }}</p>
            </div>
            <a href="{{ route('specialities.category', $group) }}" class="btn btn--ghost">Open {{ ucfirst($group) }} Speciality <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="spec-grid">
            @foreach ($list as $d)
                @include('partials.spec-card', ['d' => $d])
            @endforeach
        </div>
    </div>
</section>
@endforeach

@include('partials.consult-strip')
@include('partials.appointment')
@endsection
