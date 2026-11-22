@extends('admin.layout')
@section('title', 'SEO · ' . $page->label)
@section('subtitle', 'Recommended: title up to 60 characters, description 120–160 characters.')
@section('actions')
    <a href="{{ route('admin.seo.index') }}" class="b b--ghost"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.seo.update', $page) }}" enctype="multipart/form-data" class="form-grid" id="landingForm">
    @csrf @method('PUT')
    <div class="form-grid__main">
        <section class="card">
            <div class="serp" data-serp>
                <span class="serp__url">{{ preg_replace('#^https?://#', '', url('/')) }} › <b>{{ $page->page_key }}</b></span>
                <span class="serp__title" data-serp-title></span>
                <span class="serp__desc" data-serp-desc></span>
            </div>
            <input type="hidden" name="name" value="{{ $page->label }}">
            <label class="f"><span>Meta title <em data-counter-for="meta_title"></em></span><input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" maxlength="255" data-max="60"></label>
            <label class="f"><span>Meta description <em data-counter-for="meta_description"></em></span><textarea name="meta_description" rows="3" maxlength="500" data-max="160">{{ old('meta_description', $page->meta_description) }}</textarea></label>
            <label class="f"><span>Meta keywords</span><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" maxlength="500"></label>
            <label class="f"><span>Canonical URL <em>optional – leave blank for automatic</em></span><input type="url" name="canonical" value="{{ old('canonical', $page->canonical) }}"></label>
            @include('admin.partials.image-field', ['name' => 'og_image', 'label' => 'Share image (1200×630)', 'value' => $page->og_image])
        </section>
    </div>
    <aside class="form-grid__side">
        <section class="card sticky">
            <label class="switch"><input type="checkbox" name="noindex" value="1" @checked(old('noindex', $page->noindex))><span></span> Hide from Google (noindex)</label>
            <button class="b b--primary b--block b--lg"><i class="bi bi-check2-circle"></i> Save SEO</button>
        </section>
    </aside>
</form>
@endsection
