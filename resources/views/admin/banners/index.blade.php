@extends('admin.layout')
@section('title', 'Home Hero')
@section('subtitle', 'Edit the headline, text and background photo at the top of the home page.')

@section('content')
<form method="POST" action="{{ route('admin.banners.hero') }}" enctype="multipart/form-data" class="card">
    @csrf @method('PUT')
    <div class="card__head"><h3><i class="bi bi-stars"></i> Home page hero</h3><a href="{{ route('home') }}" target="_blank" class="b b--ghost b--sm"><i class="bi bi-box-arrow-up-right"></i> Preview</a></div>
    <div class="form-grid">
        <div>
            <label class="f"><span>Small heading <em>gold text above the title</em></span><input type="text" name="hero_eyebrow" value="{{ old('hero_eyebrow', $settings['hero_eyebrow'] ?? '') }}" placeholder="Multi Speciality Hospital · Coimbatore"></label>
            <div class="row-2">
                <label class="f"><span>Title – line 1</span><input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" placeholder="Trusted healthcare,"></label>
                <label class="f"><span>Title – line 2 <em>gold italic</em></span><input type="text" name="hero_highlight" value="{{ old('hero_highlight', $settings['hero_highlight'] ?? '') }}" placeholder="close to home."></label>
            </div>
            <label class="f"><span>Tamil line</span><input type="text" name="hero_tamil" value="{{ old('hero_tamil', $settings['hero_tamil'] ?? '') }}" placeholder="அனைவரும் நலம்பெற — நம்பிக்கையான மருத்துவம், உங்கள் அருகில்"></label>
            <label class="f"><span>Description</span><textarea name="hero_text" rows="3" placeholder="NABH pre-accredited care on Thondamuthur Road …">{{ old('hero_text', $settings['hero_text'] ?? '') }}</textarea></label>
            <p class="muted small">Leave a field empty to use the default text.</p>
        </div>
        <div>
            @include('admin.partials.image-field', ['name' => 'hero_image', 'label' => 'Background photo (1920×1080, landscape)', 'value' => $settings['hero_image'] ?? 'assets/img/misc/hospital-building.webp', 'removable' => !empty($settings['hero_image'])])
            <button class="b b--primary b--block"><i class="bi bi-check2-circle"></i> Save hero</button>
        </div>
    </div>
</form>

@endsection
