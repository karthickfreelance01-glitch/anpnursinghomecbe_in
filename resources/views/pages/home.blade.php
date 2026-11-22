@extends('layouts.app')
@php($c = config('anp.contact'))

@section('title', 'Best Diabetologist in Coimbatore')

@section('content')

{{-- ============ HERO SLIDER ============ --}}
<section class="hero">
    <div class="hero__bg" aria-hidden="true">
        <span class="blob blob--1"></span><span class="blob blob--2"></span><span class="blob blob--3"></span>
    </div>

    <div class="container">
        <div class="slider" id="heroSlider" aria-roledescription="carousel" aria-label="ANP Nursing Home highlights">
            <div class="slider__track">
                @foreach (config('anp.hero_slides') as $i => $s)
                    <figure class="slide {{ $i === 0 ? 'is-active' : '' }}" aria-roledescription="slide" aria-label="{{ $i + 1 }} of {{ count(config('anp.hero_slides')) }}">
                        <img src="{{ asset('assets/img/hero/' . $s['img']) }}" alt="{{ $s['alt'] }}" width="1600" height="800" @if($i > 0) loading="lazy" @else fetchpriority="high" @endif>
                    </figure>
                @endforeach
            </div>

            <button class="slider__arrow slider__arrow--prev" aria-label="Previous slide"><i class="bi bi-chevron-left"></i></button>
            <button class="slider__arrow slider__arrow--next" aria-label="Next slide"><i class="bi bi-chevron-right"></i></button>

            <div class="slider__dots" role="tablist">
                @foreach (config('anp.hero_slides') as $i => $s)
                    <button class="slider__dot {{ $i === 0 ? 'is-active' : '' }}" aria-label="Go to slide {{ $i + 1 }}"><span></span></button>
                @endforeach
            </div>
        </div>

        {{-- Quick actions overlapping the slider --}}
        <div class="quick">
            <a href="tel:{{ $c['emergency_raw'] }}" class="quick__item quick__item--hot">
                <span class="quick__icon"><i class="bi bi-truck-front-fill"></i></span>
                <span><small>24/7 Emergency &amp; Ambulance</small><strong>{{ $c['emergency'] }}</strong></span>
            </a>
            <a href="{{ route('contact') }}#appointment" class="quick__item">
                <span class="quick__icon"><i class="bi bi-calendar2-check"></i></span>
                <span><small>Book an Appointment</small><strong>{{ $c['phone'] }}</strong></span>
            </a>
            <a href="tel:{{ $c['pharmacy_raw'] }}" class="quick__item">
                <span class="quick__icon"><i class="bi bi-capsule"></i></span>
                <span><small>Pharmacy – Home Delivery</small><strong>{{ $c['pharmacy'] }}</strong></span>
            </a>
            <a href="tel:{{ $c['lab_raw'] }}" class="quick__item">
                <span class="quick__icon"><i class="bi bi-eyedropper"></i></span>
                <span><small>Lab – Home Collection</small><strong>{{ $c['lab'] }}</strong></span>
            </a>
        </div>
    </div>
</section>

{{-- ============ ABOUT ============ --}}
<section class="section about">
    <div class="container about__grid">
        <div class="about__media reveal">
            <div class="about__img">
                <img src="{{ asset('assets/img/misc/hospital-building.webp') }}" alt="ANP Nursing Home building, Thondamuthur Road, Coimbatore" loading="lazy">
            </div>
            <div class="float-card float-card--years">
                <strong>14+</strong><span>Years of<br>Trusted Care</span>
            </div>
            <div class="float-card float-card--nabh">
                <img src="{{ asset('assets/img/misc/nabh.webp') }}" alt="NABH Pre-Accredited" loading="lazy">
                <span>NABH<br><small>Pre-Accredited</small></span>
            </div>
        </div>

        <div class="about__content reveal">
            <span class="eyebrow">About ANP Nursing Home</span>
            <h1 class="title">Multi Speciality Hospital <span class="grad">caring for Coimbatore</span></h1>
            <p class="tamil lead-tamil">{{ config('anp.tamil') }}</p>
            @foreach (config('anp.about') as $p)
                <p>{{ $p }}</p>
            @endforeach
            <ul class="checks">
                <li><i class="bi bi-check2-circle"></i> 24×7 ICU &amp; Emergency</li>
                <li><i class="bi bi-check2-circle"></i> Cashless Insurance Support</li>
                <li><i class="bi bi-check2-circle"></i> In-house Pharmacy &amp; Lab</li>
                <li><i class="bi bi-check2-circle"></i> Modern Operation Theatres</li>
            </ul>
            <div class="btn-row">
                <a href="{{ route('contact') }}#appointment" class="btn btn--primary"><i class="bi bi-calendar2-plus"></i> Request Appointment</a>
                <a href="{{ route('about') }}" class="btn btn--ghost">Meet The Doctors <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- ============ VISION & MISSION ============ --}}
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

{{-- ============ DOCTORS ============ --}}
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Our Doctors</span>
            <h2 class="title">Led by experienced <span class="grad">specialists</span></h2>
        </div>
        @include('partials.doctors')
    </div>
</section>

{{-- ============ SPECIALITIES ============ --}}
<section class="section section--tint" id="specialities">
    <div class="container">
        <div class="section-head section-head--split reveal">
            <div>
                <span class="eyebrow">Departments</span>
                <h2 class="title">Our <span class="grad">Specialities</span></h2>
            </div>
            <div class="tabs" role="tablist">
                <button class="tabs__btn is-active" data-tab="surgical" role="tab">Surgical Speciality</button>
                <button class="tabs__btn" data-tab="medical" role="tab">Medical Speciality</button>
            </div>
        </div>

        @foreach (['surgical', 'medical'] as $group)
            <div class="tab-panel {{ $group === 'surgical' ? 'is-active' : '' }}" data-panel="{{ $group }}">
                <div class="carousel" data-carousel>
                    <div class="carousel__track">
                        @foreach (config('anp.' . $group) as $d)
                            <a href="{{ route('contact') }}?dept={{ urlencode($d['name']) }}#appointment" class="spec-card">
                                <img src="{{ asset('assets/img/specialities/' . $d['slug'] . '.webp') }}" alt="{{ $d['name'] }}" loading="lazy" width="640" height="438">
                                <span class="spec-card__hover"><i class="bi bi-calendar2-plus"></i> Book {{ $d['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    <button class="carousel__btn carousel__btn--prev" aria-label="Scroll left"><i class="bi bi-arrow-left"></i></button>
                    <button class="carousel__btn carousel__btn--next" aria-label="Scroll right"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        @endforeach

        <div class="center mt-3">
            <a href="{{ route('departments') }}" class="btn btn--ghost">View All Departments <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

{{-- ============ STATS ============ --}}
@include('partials.stats')

{{-- ============ WHY CHOOSE ============ --}}
@include('partials.why')

{{-- ============ OFFERS ============ --}}
<section class="section section--tint">
    <div class="container offers">
        <article class="offer reveal">
            <button class="offer__img" data-lightbox="{{ asset('assets/img/misc/pharmacy-offer.webp') }}" aria-label="View pharmacy offer poster">
                <img src="{{ asset('assets/img/misc/pharmacy-offer.webp') }}" alt="ANP Pharmacy 5% discount poster" loading="lazy">
            </button>
            <div class="offer__body">
                <span class="badge badge--hot"><i class="bi bi-percent"></i> 5% OFF</span>
                <h3 class="tamil">மருந்துகளில் 5% தள்ளுபடி</h3>
                <p class="tamil">ANP Nursing Home நோயாளிகளின் நலனைக் கருத்தில் கொண்டு, எங்கள் Pharmacy-யில் கிடைக்கும் அனைத்து Medicines-க்கும் 5% Discount வழங்கப்படுகிறது.</p>
                <p class="tamil">உயர்தரமான, நம்பகமான மருந்துகள் மற்றும் மருத்துவ ஆலோசனையுடன் கூடிய சேவை ஒரே இடத்தில். உங்கள் ஆரோக்கியமும் சேமிப்பும் எங்களின் முதன்மை இலக்கு.</p>
                <a href="tel:{{ $c['pharmacy_raw'] }}" class="btn btn--primary"><i class="bi bi-telephone"></i> Pharmacy: {{ $c['pharmacy'] }}</a>
            </div>
        </article>

        <article class="offer offer--wide reveal">
            <div class="offer__body">
                <span class="badge"><i class="bi bi-heart-pulse"></i> New Centre</span>
                <h3>Diabetic, Cardio &amp; Renal Center</h3>
                <p class="tamil">ANP Hospital-இல் உள்ள Cardio &amp; Diabetic Centre இதய நோய்கள் மற்றும் சர்க்கரை நோய்க்கு முழுமையான, ஒருங்கிணைந்த சிகிச்சை மையமாக செயல்படுகிறது.</p>
                <ul class="checks checks--1">
                    <li><i class="bi bi-check2-circle"></i> Type 1, Type 2 &amp; gestational diabetes, uncontrolled sugar and complications</li>
                    <li><i class="bi bi-check2-circle"></i> Blood sugar monitoring, HbA1c, insulin &amp; medication management</li>
                    <li><i class="bi bi-check2-circle"></i> ECG, Echo, TMT &amp; preventive cardiac evaluation</li>
                    <li><i class="bi bi-check2-circle"></i> Personalised diet &amp; lifestyle guidance with long-term follow-up</li>
                </ul>
                <a href="{{ route('contact') }}?dept=Diabetology#appointment" class="btn btn--primary">Book a Consultation</a>
            </div>
            <button class="offer__img" data-lightbox="{{ asset('assets/img/misc/diabetic-cardio-renal.webp') }}" aria-label="View Diabetic Cardio Renal Center poster">
                <img src="{{ asset('assets/img/misc/diabetic-cardio-renal.webp') }}" alt="Diabetic Cardio Renal Center poster" loading="lazy">
            </button>
        </article>
    </div>
</section>

{{-- ============ EMERGENCY BANNER ============ --}}
<section class="emergency">
    <div class="container emergency__inner reveal">
        <div>
            <span class="eyebrow eyebrow--light">Available Anytime, Anywhere</span>
            <h2>24/7 Emergency &amp; Ambulance Services</h2>
            <p>Our emergency and ambulance services are available around the clock to ensure your health and safety.</p>
            <ul class="pills">
                <li><i class="bi bi-hospital"></i> Hospital Discharge</li>
                <li><i class="bi bi-house-heart"></i> Home-to-Home Transfers</li>
                <li><i class="bi bi-activity"></i> Emergency Medical Response</li>
            </ul>
        </div>
        <a href="tel:{{ $c['emergency_raw'] }}" class="emergency__call">
            <span class="pulse pulse--lg"><i class="bi bi-telephone-fill"></i></span>
            <span><small>Call Now</small><strong>{{ $c['emergency'] }}</strong></span>
        </a>
    </div>
</section>

{{-- ============ PACKAGES ============ --}}
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Master Health Checkup</span>
            <h2 class="title">Prevention is the <span class="grad">best cure</span></h2>
            <p class="muted">Affordable, comprehensive screening packages with expert evaluation.</p>
        </div>
        @include('partials.packages')
    </div>
</section>

{{-- ============ TESTIMONIALS ============ --}}
@include('partials.testimonials')

{{-- ============ SPECIAL CONSULTANTS ============ --}}
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
