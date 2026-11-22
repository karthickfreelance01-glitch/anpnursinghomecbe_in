@extends('layouts.app')

@section('title', 'Departments')

@section('content')
@include('partials.page-hero', ['title' => 'Departments', 'subtitle' => 'Medical and surgical specialities under one roof — with visiting consultants as per schedule.'])

@foreach ([
    'surgical' => ['Surgical Speciality', 'bi-scissors', 'Modern operation theatres, experienced surgeons and post-operative ICU care.'],
    'medical'  => ['Medical Speciality', 'bi-capsule', 'Evidence-based medical care backed by in-house diagnostics, pharmacy and lab.'],
] as $group => [$label, $icon, $intro])
<section @class(['section', 'section--tint' => $group === 'medical']) id="{{ $group }}">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow"><i class="bi {{ $icon }}"></i> {{ $label }}</span>
            <h2 class="title">{{ count(config('anp.' . $group)) }} <span class="grad">{{ strtolower($label) }}</span> departments</h2>
            <p class="muted">{{ $intro }}</p>
        </div>
        <div class="spec-grid">
            @foreach (config('anp.' . $group) as $d)
                <a href="{{ route('contact') }}?dept={{ urlencode($d['name']) }}#appointment" class="spec-card reveal">
                    <img src="{{ asset('assets/img/specialities/' . $d['slug'] . '.webp') }}" alt="{{ $d['name'] }}" loading="lazy" width="640" height="438">
                    <span class="spec-card__hover"><i class="bi bi-calendar2-plus"></i> Book {{ $d['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<section class="section section--tight">
    <div class="container">
        <div class="consult reveal">
            <div class="consult__icon"><i class="bi bi-calendar-week"></i></div>
            <div>
                <h3 class="tamil">சிறப்பு மருத்துவர் வருகை – குறிப்பிட்ட நாட்களில் மட்டும்</h3>
                <p>Availability of Special Consultants – as per schedule dates only.</p>
            </div>
            <button class="btn btn--light" data-lightbox="{{ asset('assets/img/misc/special-consultants.webp') }}"><i class="bi bi-clock-history"></i> View Doctor Timings</button>
        </div>
    </div>
</section>

@include('partials.appointment')
@endsection
