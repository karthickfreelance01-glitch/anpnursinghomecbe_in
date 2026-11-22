@extends('layouts.app')
@php($c = config('anp.contact'))

@section('title', 'Contact Us')

@section('content')
@include('partials.page-hero', ['title' => 'Contact Us', 'subtitle' => 'We are here for you 24/7 — call, WhatsApp or visit us on Thondamuthur Road.'])

<section class="section">
    <div class="container contact-cards">
        <a href="tel:{{ $c['emergency_raw'] }}" class="contact-card contact-card--hot reveal">
            <span class="contact-card__icon"><i class="bi bi-truck-front-fill"></i></span>
            <h3>Emergency Contact</h3>
            <p>{{ $c['emergency'] }}</p>
            <small>24/7 ICU &amp; Ambulance</small>
        </a>
        <a href="tel:{{ $c['pharmacy_raw'] }}" class="contact-card reveal">
            <span class="contact-card__icon"><i class="bi bi-capsule"></i></span>
            <h3>For Pharmacy</h3>
            <p>{{ $c['pharmacy'] }}</p>
            <small>Home Delivery</small>
        </a>
        <a href="tel:{{ $c['lab_raw'] }}" class="contact-card reveal">
            <span class="contact-card__icon"><i class="bi bi-eyedropper"></i></span>
            <h3>For Lab</h3>
            <p>{{ $c['lab'] }}</p>
            <small>Home Collection</small>
        </a>
        <div class="contact-card reveal">
            <span class="contact-card__icon"><i class="bi bi-calendar2-check"></i></span>
            <h3>Appointment Call</h3>
            @foreach ($c['appointment'] as $num)
                <p><a href="tel:{{ preg_replace('/\s+/', '', $num) }}">{{ $num }}</a></p>
            @endforeach
        </div>
    </div>

    <div class="container contact-map">
        <div class="contact-map__info reveal">
            <h3><i class="bi bi-geo-alt-fill"></i> Address</h3>
            <p>{{ $c['address'] }}</p>
            <h3><i class="bi bi-envelope-fill"></i> Email</h3>
            <p><a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></p>
            <a class="btn btn--primary" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($c['map_query']) }}"><i class="bi bi-sign-turn-right"></i> Get Directions</a>
        </div>
        <div class="contact-map__frame reveal">
            <iframe title="ANP Nursing Home location" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                src="https://maps.google.com/maps?q={{ urlencode($c['map_query']) }}&z=15&output=embed"></iframe>
        </div>
    </div>
</section>

@include('partials.appointment')
@endsection
