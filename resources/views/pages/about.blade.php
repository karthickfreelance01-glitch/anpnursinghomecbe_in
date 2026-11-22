@extends('layouts.app')

@section('title', 'About Us')

@section('content')
@include('partials.page-hero', ['title' => 'About Us', 'subtitle' => 'Over 14 years of compassionate, reliable and advanced healthcare in Coimbatore.'])

<section class="section about">
    <div class="container about__grid">
        <div class="about__media reveal">
            <div class="about__img">
                <img src="{{ asset('assets/img/misc/hospital-building.webp') }}" alt="ANP Nursing Home building" loading="lazy">
            </div>
            <div class="float-card float-card--years"><strong>14+</strong><span>Years of<br>Trusted Care</span></div>
            <div class="float-card float-card--nabh">
                <img src="{{ asset('assets/img/misc/nabh.webp') }}" alt="NABH Pre-Accredited" loading="lazy">
                <span>NABH<br><small>Pre-Accredited</small></span>
            </div>
        </div>
        <div class="about__content reveal">
            <span class="eyebrow">ANP Nursing Home</span>
            <h2 class="title">Multi Speciality Hospital <span class="grad">with a patient-first heart</span></h2>
            <p class="tamil lead-tamil">{{ config('anp.tamil') }}</p>
            @foreach (config('anp.about') as $p)
                <p>{{ $p }}</p>
            @endforeach
            <div class="btn-row">
                <a href="{{ route('contact') }}#appointment" class="btn btn--primary"><i class="bi bi-calendar2-plus"></i> Request Appointment</a>
                <a href="{{ route('facilities') }}" class="btn btn--ghost">Our Facilities <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

@include('partials.stats')

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Our Doctors</span>
            <h2 class="title">Meet the <span class="grad">leadership</span></h2>
        </div>
        @include('partials.doctors')
    </div>
</section>

<section class="section section--tint">
    <div class="container vm">
        <article class="vm__card reveal">
            <span class="vm__icon"><i class="bi bi-eye"></i></span>
            <h3>Vision <span class="tamil">(தொலைநோக்கு)</span></h3>
            <blockquote class="tamil">{{ config('anp.vision.kural') }}</blockquote>
            <p class="tamil">{{ config('anp.vision.text') }}</p>
        </article>
        <article class="vm__card vm__card--alt reveal">
            <span class="vm__icon"><i class="bi bi-bullseye"></i></span>
            <h3>Mission <span class="tamil">(இலக்கு)</span></h3>
            <p class="tamil">{{ config('anp.mission') }}</p>
        </article>
    </div>
</section>

@include('partials.why')
@include('partials.testimonials')
@endsection
