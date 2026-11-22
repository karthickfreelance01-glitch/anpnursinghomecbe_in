@extends('admin.layout')
@section('title', 'SEO Manager')
@section('subtitle', 'Control how every page appears on Google and when shared on WhatsApp / Facebook.')
@section('actions')
    <a href="{{ route('sitemap') }}" target="_blank" class="b b--ghost"><i class="bi bi-diagram-3"></i> sitemap.xml</a>
@endsection

@section('content')
<section class="card">
    <div class="card__head"><h3><i class="bi bi-file-earmark-text"></i> Page SEO</h3></div>
    <div class="table-wrap">
    <table class="table">
        <thead><tr><th>Page</th><th>Meta title</th><th>Description</th><th class="t-right"></th></tr></thead>
        <tbody>
        @foreach ($pages as $p)
            <tr>
                <td class="t-strong">{{ $p->label }} @if($p->noindex)<span class="pill pill--off">noindex</span>@endif</td>
                <td><span class="len {{ mb_strlen($p->meta_title) > 60 ? 'len--warn' : '' }}">{{ mb_strlen((string) $p->meta_title) }}</span> {{ \Illuminate\Support\Str::limit($p->meta_title, 60) }}</td>
                <td><span class="len {{ mb_strlen($p->meta_description) > 160 ? 'len--warn' : '' }}">{{ mb_strlen((string) $p->meta_description) }}</span> <span class="muted">{{ \Illuminate\Support\Str::limit($p->meta_description, 70) }}</span></td>
                <td class="t-right"><a href="{{ route('admin.seo.edit', $p) }}" class="b b--ghost b--sm"><i class="bi bi-pencil"></i> Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</section>

<div class="grid-2">
    <section class="card">
        <div class="card__head"><h3><i class="bi bi-hospital"></i> Departments &amp; specialities</h3></div>
        <p class="muted">SEO for each landing page is edited inside the department / speciality form.</p>
        <ul class="seo-list">
            @foreach ($departments as $d)
                <li><a href="{{ route('admin.departments.edit', $d) }}"><i class="bi bi-hospital"></i> {{ $d->name }}</a>
                    <span class="seo-dot seo-dot--{{ (int) filled($d->meta_title) + (int) filled($d->meta_description) + 1 }}"></span></li>
            @endforeach
            @foreach ($specialities as $d)
                <li><a href="{{ route('admin.specialities.edit', $d) }}"><i class="bi bi-{{ $d->category === 'medical' ? 'capsule' : 'scissors' }}"></i> {{ $d->name }}</a>
                    <span class="seo-dot seo-dot--{{ (int) filled($d->meta_title) + (int) filled($d->meta_description) + 1 }}"></span></li>
            @endforeach
        </ul>
    </section>

    <section class="card">
        <div class="card__head"><h3><i class="bi bi-gear"></i> Global SEO settings</h3></div>
        <form method="POST" action="{{ route('admin.seo.settings') }}" enctype="multipart/form-data" class="stack">
            @csrf @method('PUT')
            <div class="row-2">
                <label class="f"><span>Site name</span><input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'ANP Nursing Home') }}" required></label>
                <label class="f"><span>Title suffix <em>added after every title</em></span><input type="text" name="title_suffix" value="{{ old('title_suffix', $settings['title_suffix'] ?? '') }}"></label>
            </div>
            <label class="f"><span>Default meta description</span><textarea name="default_description" rows="2">{{ old('default_description', $settings['default_description'] ?? '') }}</textarea></label>
            <label class="f"><span>Default keywords</span><input type="text" name="default_keywords" value="{{ old('default_keywords', $settings['default_keywords'] ?? '') }}"></label>
            <div class="row-2">
                <label class="f"><span>Google Search Console code</span><input type="text" name="google_verification" value="{{ old('google_verification', $settings['google_verification'] ?? '') }}" placeholder="abc123…"></label>
                <label class="f"><span>Bing Webmaster code</span><input type="text" name="bing_verification" value="{{ old('bing_verification', $settings['bing_verification'] ?? '') }}"></label>
            </div>
            <label class="f"><span>Google Analytics 4 ID</span><input type="text" name="ga4_id" value="{{ old('ga4_id', $settings['ga4_id'] ?? '') }}" placeholder="G-XXXXXXXXXX"></label>
            @include('admin.partials.image-field', ['name' => 'default_og_image', 'label' => 'Default share image (1200×630)', 'value' => $settings['default_og_image'] ?? null, 'removable' => false])
            <button class="b b--primary"><i class="bi bi-check2"></i> Save settings</button>
        </form>
    </section>
</div>
@endsection
