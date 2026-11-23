@extends('layouts.app')


@section('content')
@include('partials.page-hero', ['title' => 'Facilities', 'subtitle' => '24×7 ICU, emergency, diagnostics, pharmacy and more — everything your care needs, in one place.'])

<section class="section">
    <div class="container">
        <div class="facilities">
            @foreach (config('anp.facilities') as $f)
                <article @class(['facility', 'reveal', 'facility--featured' => $f['featured'] ?? false, 'facility--has-img' => !empty($f['image'])])>
                    @if (!empty($f['image']))
                        <div class="facility__img">
                            <img src="{{ asset('assets/img/' . $f['image']) }}" alt="{{ $f['title'] }} at ANP Nursing Home, Coimbatore" loading="lazy">
                        </div>
                    @endif
                    <span class="facility__icon"><i class="bi {{ $f['icon'] }}"></i></span>
                    <h3>{{ $f['title'] }}</h3>
                    <p>{{ $f['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="emergency">
    <div class="container emergency__inner reveal">
        <div>
            <span class="eyebrow eyebrow--light">Available Anytime, Anywhere</span>
            <h2>24/7 Emergency &amp; Ambulance Services</h2>
            <p>Heart attack, stroke, poisoning or any life-threatening emergency — our team responds in seconds.</p>
        </div>
        <a href="tel:{{ config('anp.contact.emergency_raw') }}" class="emergency__call">
            <span class="pulse pulse--lg"><i class="bi bi-telephone-fill"></i></span>
            <span><small>Call Now</small><strong>{{ config('anp.contact.emergency') }}</strong></span>
        </a>
    </div>
</section>

@include('partials.appointment')
@endsection
