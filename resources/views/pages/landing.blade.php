@extends('layouts.app')
@php($c = config('anp.contact'))

@section('content')
{{-- ============ LANDING HERO ============ --}}
<section class="lp-hero">
    <div class="lp-hero__bg" aria-hidden="true">
        <span class="blob blob--1"></span><span class="blob blob--2"></span>
    </div>
    <div class="container lp-hero__grid">
        <div class="lp-hero__text">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a>
                <i class="bi bi-chevron-right"></i>
                <a href="{{ $parent[1] }}">{{ $parent[0] }}</a>
                <i class="bi bi-chevron-right"></i>
                <span>{{ $item->name }}</span>
            </nav>
            <span class="lp-hero__kind"><i class="bi {{ $item->icon_class }}"></i> {{ $kind }}</span>
            <h1>{{ $item->name }}</h1>
            @if ($item->tagline)<p class="lp-hero__tagline">{{ $item->tagline }}</p>@endif
            @if ($item->short_description)<p class="lp-hero__lead">{{ $item->short_description }}</p>@endif
            <div class="btn-row">
                <a href="#lp-form" class="btn btn--light btn--lg"><i class="bi bi-calendar2-plus"></i> Book Appointment</a>
                <a href="tel:{{ $c['phone_raw'] }}" class="btn btn--outline-light btn--lg"><i class="bi bi-telephone"></i> {{ $c['phone'] }}</a>
            </div>
            <ul class="lp-hero__trust">
                <li><i class="bi bi-shield-check"></i> NABH Pre-Accredited</li>
                <li><i class="bi bi-clock-history"></i> 24×7 Emergency &amp; ICU</li>
                <li><i class="bi bi-credit-card-2-front"></i> Cashless Insurance</li>
            </ul>
        </div>
        <div class="lp-hero__media">
            @if ($item->banner_image)
                <img src="{{ $item->banner_url }}" alt="{{ $item->name }} – ANP Nursing Home, Coimbatore" width="1200" height="820" fetchpriority="high">
            @else
                <img src="{{ asset('assets/img/misc/hospital-building.webp') }}" alt="ANP Nursing Home – {{ $item->name }}, Thondamuthur Road, Coimbatore" width="1600" height="1068" fetchpriority="high" class="is-building">
                <span class="lp-hero__chip"><i class="bi {{ $item->icon_class }}"></i> {{ $item->name }}</span>
            @endif
            <div class="lp-hero__badge">
                <span class="pulse"><i class="bi bi-telephone-fill"></i></span>
                <span><small>Emergency 24/7</small><a href="tel:{{ $c['emergency_raw'] }}">{{ $c['emergency'] }}</a></span>
            </div>
        </div>
    </div>
</section>

{{-- ============ CONTENT + STICKY FORM ============ --}}
<section class="section lp-body">
    <div class="container lp-body__grid">
        <article class="lp-content">
            <div class="lp-block reveal">
                <span class="eyebrow">Overview</span>
                <h2 class="title title--sm">{{ $item->name }} at <span class="grad">ANP Nursing Home</span></h2>
                <div class="prose">{!! $item->description !!}</div>
            </div>

            @if (!empty($item->services))
                <div class="lp-block reveal">
                    <h3 class="lp-h3"><i class="bi bi-ui-checks-grid"></i> Treatments &amp; Services</h3>
                    <ul class="svc-list">
                        @foreach ($item->services as $svc)
                            <li><i class="bi bi-check2-circle"></i> {{ $svc }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="lp-block reveal">
                <h3 class="lp-h3"><i class="bi bi-stars"></i> Why patients choose us</h3>
                <div class="why-mini">
                    <div><i class="bi bi-person-badge"></i><strong>Experienced doctors</strong><span>Qualified specialists &amp; trained nursing team</span></div>
                    <div><i class="bi bi-hospital"></i><strong>All under one roof</strong><span>Lab, pharmacy, imaging, OT &amp; ICU</span></div>
                    <div><i class="bi bi-wallet2"></i><strong>Affordable care</strong><span>Transparent pricing &amp; insurance support</span></div>
                    <div><i class="bi bi-truck-front"></i><strong>24×7 ambulance</strong><span>Rapid response for emergencies</span></div>
                </div>
            </div>

            @if (!empty($item->faqs))
                <div class="lp-block reveal">
                    <h3 class="lp-h3"><i class="bi bi-question-circle"></i> Frequently asked questions</h3>
                    <div class="accordion">
                        @foreach ($item->faqs as $i => $f)
                            @continue(empty($f['q']))
                            <details class="accordion__item" @if($i === 0) open @endif>
                                <summary>
                                    <span class="accordion__icon"><i class="bi bi-chat-square-text"></i></span>
                                    {{ $f['q'] }}
                                    <i class="bi bi-plus-lg accordion__toggle"></i>
                                </summary>
                                <p>{{ $f['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        <aside class="lp-aside">
            <div class="lp-card lp-card--form" id="lp-form">
                <h3><i class="bi bi-calendar2-check"></i> Book an Appointment</h3>
                <p class="muted">Share your details — our front desk will call you to confirm.</p>
                @include('partials.enquiry-form', ['compact' => true, 'preset' => $item->name])
            </div>

            <div class="lp-card lp-card--call">
                <span class="pulse pulse--lg"><i class="bi bi-telephone-fill"></i></span>
                <div>
                    <small>Need urgent help?</small>
                    <a href="tel:{{ $c['emergency_raw'] }}">{{ $c['emergency'] }}</a>
                    <span>24/7 Emergency &amp; Ambulance</span>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="lp-card">
                    <h4>Other {{ $kind === 'Department' ? 'Departments' : $kind }}</h4>
                    <ul class="lp-links">
                        @foreach ($related->take(10) as $r)
                            <li><a href="{{ $r->url }}"><i class="bi {{ $r->icon_class }}"></i> {{ $r->name }} <i class="bi bi-chevron-right"></i></a></li>
                        @endforeach
                    </ul>
                    <a href="{{ $parent[1] }}" class="lp-links__all">View all <i class="bi bi-arrow-right"></i></a>
                </div>
            @endif
        </aside>
    </div>
</section>

@include('partials.consult-strip')
@endsection
