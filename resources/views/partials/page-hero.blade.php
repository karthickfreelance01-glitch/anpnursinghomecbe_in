<section class="page-hero">
    <div class="page-hero__bg" aria-hidden="true">
        <span class="blob blob--1"></span><span class="blob blob--2"></span>
    </div>
    <div class="container page-hero__inner">
        <nav class="crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a>
            <i class="bi bi-chevron-right"></i>
            <span>{{ $title }}</span>
        </nav>
        <h1>{{ $title }}</h1>
        @isset($subtitle)<p>{{ $subtitle }}</p>@endisset
    </div>
</section>
