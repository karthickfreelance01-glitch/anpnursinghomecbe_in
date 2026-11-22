@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'title' => $label,
    'crumbs' => ['Departments' => route('departments')],
    'subtitle' => $category === 'medical'
        ? 'Expert physicians with in-house lab, imaging, pharmacy and a 24×7 ICU behind every consultation.'
        : 'Modern operation theatres, experienced surgeons and dedicated post-operative care.',
])

<section class="section">
    <div class="container">
        <div class="switcher reveal">
            <a href="{{ route('specialities.category', 'medical') }}" @class(['is-active' => $category === 'medical'])><i class="bi bi-capsule"></i> Medical Speciality <small>{{ $medicalList->count() }}</small></a>
            <a href="{{ route('specialities.category', 'surgical') }}" @class(['is-active' => $category === 'surgical'])><i class="bi bi-scissors"></i> Surgical Speciality <small>{{ $surgicalList->count() }}</small></a>
        </div>

        <div class="spec-grid">
            @forelse ($items as $d)
                @include('partials.spec-card', ['d' => $d])
            @empty
                <p class="muted center">Specialities will be listed here soon.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.consult-strip')
@include('partials.appointment')
@endsection
