@php($c = config('anp.contact'))
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <script>document.documentElement.classList.remove('no-js')</script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')
    <meta name="theme-color" content="#a0268f">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/misc/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500;1,600&family=Exo+2:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Noto+Sans+Tamil:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v=8">
    @stack('head')
</head>
<body>

    {{-- Top bar --}}
    <div class="topbar">
        <div class="container topbar__inner">
            <p class="topbar__welcome"><i class="bi bi-hospital"></i> Welcome To ANP Nursing Home!</p>
            <div class="topbar__links">
                <a href="tel:{{ $c['phone_raw'] }}"><i class="bi bi-telephone"></i> {{ $c['phone'] }}</a>
                <a href="mailto:{{ $c['email'] }}"><i class="bi bi-envelope"></i> {{ $c['email'] }}</a>
                <span class="topbar__open"><i class="bi bi-clock"></i> Open 24/7</span>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="header" id="header">
        <div class="container header__inner">
            <a href="{{ route('home') }}" class="brand" aria-label="ANP Nursing Home home">
                <img src="{{ asset('assets/img/misc/logo-mark.webp') }}" alt="ANP logo" width="56" height="56">
                <span class="brand__text">
                    <strong>ANP Nursing Home</strong>
                    <small>Multi Speciality Hospital</small>
                </span>
            </a>

            <nav class="nav" id="nav" aria-label="Main">
                <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Home</a>
                <a href="{{ route('about') }}" @class(['active' => request()->routeIs('about')])>About Us</a>
                <div class="nav__drop" data-drop>
                    <a href="{{ route('departments') }}" @class(['active' => request()->routeIs('departments*', 'specialities*')]) aria-haspopup="true">Departments <i class="bi bi-chevron-down"></i></a>
                    <button class="nav__toggle" type="button" aria-label="Show departments"><i class="bi bi-plus-lg"></i></button>
                    <div class="nav__menu">
                        @foreach ($navDepartments->where('show_in_menu', true) as $d)
                            <a href="{{ route('departments.show', $d->slug) }}" @class(['active' => request()->is('departments/' . $d->slug)])><i class="bi {{ $d->icon_class }}"></i> {{ $d->name }}</a>
                        @endforeach
                        <div class="nav__sub">
                            <a href="{{ route('departments') }}" class="nav__viewall">View All <i class="bi bi-plus-lg"></i></a>
                            <div class="nav__submenu">
                                <a href="{{ route('specialities.category', 'medical') }}"><i class="bi bi-capsule"></i> Medical Speciality <small>{{ $medicalList->count() }}</small></a>
                                <a href="{{ route('specialities.category', 'surgical') }}"><i class="bi bi-scissors"></i> Surgical Speciality <small>{{ $surgicalList->count() }}</small></a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('facilities') }}" @class(['active' => request()->routeIs('facilities')])>Facilities</a>
                <a href="{{ route('health-checkup') }}" @class(['active' => request()->routeIs('health-checkup')])>Master Health Checkup</a>
                <a href="{{ route('contact') }}" @class(['active' => request()->routeIs('contact')])>Contact Us</a>
                <a href="{{ route('contact') }}#appointment" class="btn btn--primary nav__cta-mobile">Book Appointment</a>
            </nav>

            <div class="header__actions">
                <a href="tel:{{ $c['emergency_raw'] }}" class="header__emergency" aria-label="Emergency 24/7: {{ $c['emergency'] }}">
                    <span class="pulse"><i class="bi bi-telephone-fill"></i></span>
                    <span class="header__emergency-text"><small>Emergency 24/7</small><strong>{{ $c['emergency'] }}</strong></span>
                </a>
                <a href="{{ route('contact') }}#appointment" class="btn btn--primary header__cta">Book Appointment</a>
                <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
            </div>
        </div>
    </header>

    {{-- Emergency ticker --}}
    <div class="ticker" aria-label="Announcements">
        <div class="ticker__label"><i class="bi bi-megaphone-fill"></i> Alert</div>
        <div class="ticker__track"><span>{{ config('anp.marquee') }}</span><span aria-hidden="true">{{ config('anp.marquee') }}</span></div>
    </div>

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer__wave" aria-hidden="true">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,80 L0,80 Z"/></svg>
        </div>
        <div class="container footer__grid">
            <div class="footer__about">
                <a href="{{ route('home') }}" class="brand brand--light">
                    <img src="{{ asset('assets/img/misc/logo-mark.webp') }}" alt="ANP logo" width="56" height="56">
                    <span class="brand__text"><strong>ANP Nursing Home</strong><small>Multi Speciality Hospital</small></span>
                </a>
                <p>Compassionate, reliable and advanced healthcare for every family in Coimbatore for over 14 years.</p>
                <ul class="footer__contact">
                    <li><i class="bi bi-geo-alt"></i><span>{{ $c['address'] }}</span></li>
                    <li><i class="bi bi-telephone"></i><a href="tel:{{ $c['phone_raw'] }}">{{ $c['phone'] }}</a></li>
                    <li><i class="bi bi-truck-front"></i><a href="tel:{{ $c['emergency_raw'] }}">Emergency: {{ $c['emergency'] }}</a></li>
                    <li><i class="bi bi-envelope"></i><a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></li>
                </ul>
                <div class="social">
                    <a href="{{ config('anp.social.facebook') }}" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="{{ config('anp.social.instagram') }}" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="{{ config('anp.social.youtube') }}" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="https://wa.me/{{ $c['whatsapp'] }}" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <h4><a href="{{ route('specialities.category', 'medical') }}">Medical Speciality</a></h4>
                <ul class="footer__links">
                    @foreach ($medicalList as $m)
                        <li><a href="{{ route('specialities.show', $m->slug) }}">{{ $m->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4><a href="{{ route('specialities.category', 'surgical') }}">Surgical Speciality</a></h4>
                <ul class="footer__links">
                    @foreach ($surgicalList as $m)
                        <li><a href="{{ route('specialities.show', $m->slug) }}">{{ $m->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Departments</h4>
                <ul class="footer__links">
                    @foreach ($navDepartments as $d)
                        <li><a href="{{ route('departments.show', $d->slug) }}">{{ $d->name }}</a></li>
                    @endforeach
                </ul>
                <h4 class="mt-h4">Quick Links</h4>
                <ul class="footer__links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('facilities') }}">Facilities</a></li>
                    <li><a href="{{ route('health-checkup') }}">Master Health Checkup</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
                <div class="footer__nabh">
                    <img src="{{ asset('assets/img/misc/nabh.webp') }}" alt="NABH Pre-Accredited – Patient Safety & Quality of Care" loading="lazy" width="120">
                    <span>NABH<br><small>Pre-Accredited</small></span>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container">
                <p>© {{ date('Y') }} ANP Nursing Home. All rights reserved.</p>
                <p class="tamil">{{ config('anp.tamil') }} · Thondamuthur Road, Coimbatore</p>
            </div>
        </div>
    </footer>

    {{-- Floating actions --}}
    <div class="fab">
        <a href="https://wa.me/{{ $c['whatsapp'] }}" class="fab__btn fab__btn--wa" aria-label="WhatsApp" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
        <a href="tel:{{ $c['emergency_raw'] }}" class="fab__btn fab__btn--call" aria-label="Call emergency"><i class="bi bi-telephone-fill"></i></a>
    </div>
    {{-- Quick Enquiry side tab + drawer --}}
    <button class="qe-tab" type="button" data-qe-open aria-controls="quickEnquiry"><i class="bi bi-envelope-paper-heart"></i> Quick Enquiry</button>
    <div class="qe" id="quickEnquiry" aria-hidden="true">
        <div class="qe__overlay" data-qe-close></div>
        <aside class="qe__panel" role="dialog" aria-modal="true" aria-labelledby="qeTitle">
            <div class="qe__head">
                <div>
                    <h3 id="qeTitle">Quick <em>Enquiry</em></h3>
                    <p>Leave your details – we will call you back shortly.</p>
                </div>
                <button class="qe__close" type="button" data-qe-close aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            @include('partials.enquiry-form', ['compact' => true])
            <div class="qe__call"><i class="bi bi-telephone-fill"></i> <span>Emergency 24/7: <a href="tel:{{ $c['emergency_raw'] }}">{{ $c['emergency'] }}</a></span></div>
        </aside>
    </div>

    <button class="to-top" id="toTop" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

    {{-- Image lightbox (doctor timings, offers) --}}
    <div class="lightbox" id="lightbox" aria-hidden="true">
        <button class="lightbox__close" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        <img src="" alt="">
    </div>

    <script src="{{ asset('assets/js/main.js') }}?v=6" defer></script>
    @stack('scripts')
</body>
</html>
