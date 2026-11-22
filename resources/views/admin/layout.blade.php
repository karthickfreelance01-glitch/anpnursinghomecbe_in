<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · ANP Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/misc/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=1">
    @stack('head')
</head>
<body>
<div class="adm">
    <aside class="adm-side" id="side">
        <a href="{{ route('admin.dashboard') }}" class="adm-brand">
            <img src="{{ asset('assets/img/misc/logo-mark.webp') }}" alt="" width="40" height="40">
            <span><strong>ANP Admin</strong><small>Nursing Home CMS</small></span>
        </a>

        <nav class="adm-nav">
            <span class="adm-nav__label">Overview</span>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a href="{{ route('admin.enquiries.index') }}" @class(['active' => request()->routeIs('admin.enquiries.*')])>
                <i class="bi bi-inbox"></i> Enquiries
                @if ($newEnquiries)<b class="adm-badge">{{ $newEnquiries }}</b>@endif
            </a>

            <span class="adm-nav__label">Website content</span>
            <a href="{{ route('admin.banners.index') }}" @class(['active' => request()->routeIs('admin.banners.*')])><i class="bi bi-stars"></i> Home Hero</a>
            <a href="{{ route('admin.departments.index') }}" @class(['active' => request()->routeIs('admin.departments.*')])><i class="bi bi-hospital"></i> Departments</a>
            <a href="{{ route('admin.specialities.index', ['category' => 'medical']) }}" @class(['active' => request()->routeIs('admin.specialities.*') && request('category') === 'medical'])><i class="bi bi-capsule"></i> Medical Speciality</a>
            <a href="{{ route('admin.specialities.index', ['category' => 'surgical']) }}" @class(['active' => request()->routeIs('admin.specialities.*') && request('category') === 'surgical'])><i class="bi bi-scissors"></i> Surgical Speciality</a>

            <span class="adm-nav__label">Marketing</span>
            <a href="{{ route('admin.seo.index') }}" @class(['active' => request()->routeIs('admin.seo.*')])><i class="bi bi-graph-up-arrow"></i> SEO Manager</a>

            <span class="adm-nav__label">Account</span>
            <a href="{{ route('admin.account') }}" @class(['active' => request()->routeIs('admin.account')])><i class="bi bi-person-gear"></i> My Account</a>
            <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Website</a>
        </nav>

        <form method="POST" action="{{ route('admin.logout') }}" class="adm-side__foot">
            @csrf
            <button type="submit"><i class="bi bi-power"></i> Logout</button>
        </form>
    </aside>

    <div class="adm-main">
        <header class="adm-top">
            <button class="adm-burger" type="button" onclick="document.body.classList.toggle('side-open')" aria-label="Menu"><i class="bi bi-list"></i></button>
            <div class="adm-top__title">
                <h1>@yield('title', 'Dashboard')</h1>
                @hasSection('subtitle')<p>@yield('subtitle')</p>@endif
            </div>
            <div class="adm-top__actions">
                @yield('actions')
                <span class="adm-user"><span>{{ \Illuminate\Support\Str::of(auth()->user()->name)->substr(0, 1)->upper() }}</span>{{ auth()->user()->name }}</span>
            </div>
        </header>

        <main class="adm-content">
            @if (session('ok'))
                <div class="adm-alert adm-alert--ok" data-autohide><i class="bi bi-check-circle-fill"></i> {{ session('ok') }}</div>
            @endif
            @if ($errors->any())
                <div class="adm-alert adm-alert--err">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><strong>Please fix the following:</strong>
                        <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<div class="adm-overlay" onclick="document.body.classList.remove('side-open')"></div>
<script src="{{ asset('assets/admin/admin.js') }}?v=1" defer></script>
@stack('scripts')
</body>
</html>
